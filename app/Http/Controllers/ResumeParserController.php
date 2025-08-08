<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ParsedCv; // Make sure you have this model

class ResumeParserController extends Controller
{
    public function showForm()
    {
        return view('resume');
    }

    public function parse(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048',
        ]);

        $filePath = $request->file('resume')->getPathname();
        $fileName = $request->file('resume')->getClientOriginalName();

        $response = Http::withToken(env('AFFINDA_API_KEY'))
            ->attach('file', file_get_contents($filePath), $fileName)
            ->post('https://api.affinda.com/v2/resumes');

        if ($response->successful()) {
            $data = $response->json()['data'];
            
            // Store in database
            $parsedCv = $this->storeParsedData($data, $fileName);
            
            return redirect()->route('resume.form')->with('success', 'CV parsed successfully!');
        } else {
            return back()->withErrors(['msg' => 'Failed to parse resume.']);
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $file = $request->file('resume');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('resumes');

        $response = Http::withToken(env('AFFINDA_API_KEY'))
            ->attach('file', file_get_contents($file->getRealPath()), $fileName)
            ->post('https://api.affinda.com/v2/resumes');

        if ($response->successful()) {
            $data = $response->json()['data'];
            
            // Store in database
            $parsedCv = $this->storeParsedData($data, $fileName, $filePath);
            
            return view('resume.result', ['data' => $data]);
        } else {
            \Log::error('Affinda API Error: ' . $response->body());
            return back()->withErrors([
                'msg' => 'Failed to parse resume. Try using a different file or check the format.',
            ]);
        }
    }

    protected function storeParsedData($data, $fileName, $filePath = null)
    {
        $skills = isset($data['skills']) ? array_column($data['skills'], 'name') : [];
        
        return ParsedCv::create([
            'candidate_name' => $data['name']['raw'] ?? null,
            'candidate_first_name' => $data['name']['first'] ?? null,
            'candidate_last_name' => $data['name']['last'] ?? null,
            'email' => $data['emails'][0] ?? null,
            'phone_number' => $data['phoneNumbers'][0] ?? null,
            'address_line_1' => $data['location']['streetNumber'] . ' ' . $data['location']['street'] ?? null,
            'area' => $data['location']['formatted'] ?? null,
            'city' => $data['location']['city'] ?? null,
            'partial_post_code' => $data['location']['postalCode'] ?? null,
            'full_post_code' => $data['location']['postalCode'] ?? null,
            'summary' => $data['summary'] ?? null,
            'skills' => json_encode($skills),
            'experience' => json_encode(array_map(function($exp) {
                return $exp['jobTitle'] . ' at ' . $exp['organization'] . ': ' . $exp['jobDescription'];
            }, $data['workExperience'] ?? [])),
            'education' => json_encode(array_map(function($edu) {
                return $edu['organization'] . ' - ' . ($edu['dates']['rawText'] ?? '');
            }, $data['education'] ?? [])),
            'certifications' => json_encode($data['certifications'] ?? []),
            'current_organization' => $data['workExperience'][0]['organization'] ?? null,
            'position_title' => $data['workExperience'][0]['jobTitle'] ?? null,
            'total_experience' => $data['totalYearsExperience'] ?? null,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'parsed_fields' => json_encode($data),
        ]);
    }

    // Add a method to show all parsed CVs
    public function index()
    {
        $parsedCvs = ParsedCv::all();
        return view('resume.index', compact('parsedCvs'));
    }

    public function uploadMultiple(Request $request)
    {
        $request->validate([
            'resumes' => 'required',
            'resumes.*' => 'mimes:pdf,doc,docx|max:2048'
        ]);

        $results = [];
        $errors = [];

        foreach ($request->file('resumes') as $file) {
            try {
                $fileName = $file->getClientOriginalName();
                $filePath = $file->store('resumes');

                $response = Http::withToken(env('AFFINDA_API_KEY'))
                    ->attach('file', file_get_contents($file->getRealPath()), $fileName)
                    ->post('https://api.affinda.com/v2/resumes');

                if ($response->successful()) {
                    $data = $response->json()['data'];
                    $parsedCv = $this->storeParsedData($data, $fileName, $filePath);
                    $results[] = $parsedCv;
                } else {
                    $errors[] = [
                        'file' => $fileName,
                        'error' => $response->body()
                    ];
                }
            } catch (\Exception $e) {
                $errors[] = [
                    'file' => $fileName,
                    'error' => $e->getMessage()
                ];
            }
        }

        return view('resume.multiple-results', [
            'results' => $results,
            'errors' => $errors
        ]);
    }
}