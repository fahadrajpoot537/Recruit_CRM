<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\ParsedCv;
use Exception;
use Illuminate\Support\Facades\Auth;

class ResumeParserController extends Controller
{
    //Production n8n webhook URL which is active
    private const N8N_WEBHOOK_URL = 'https://n8n.srv904634.hstgr.cloud/webhook-test/resume';

    /**
     * Show the upload form and CV list
     */
    public function showForm()
    {
        $parsedCvs = ParsedCv::latest()->take(10)->get();
        return view('resume', compact('parsedCvs'));
    }

    /**
     * Show CV list (same as showForm for now)
     */
    public function index()
    {
        $parsedCvs = ParsedCv::latest()->paginate(20);

        $stats = [
            'total_cvs' => ParsedCv::count(),
            'today_cvs' => ParsedCv::whereDate('created_at', today())->count(),
            'this_week_cvs' => ParsedCv::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'avg_processing_time' => 0,
        ];

        return view('resume', compact('parsedCvs', 'stats'));
    }

    /**
     * Single file upload & parse
     */
    public function upload(Request $request)
    {
        $request->validate([
            'resume' => 'required',
            'resume.*' => 'mimes:pdf,doc,docx,png,jpg,jpeg|max:2048',
        ]);

        $results = [];

        foreach ($request->file('resume') as $file) {
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('resumes');

            Log::info('Starting CV parse', [
                'file' => $fileName,
                'size' => $file->getSize(),
                'mime' => $file->getMimeType()
            ]);

            try {
                $response = Http::timeout(120)
                    ->attach('file', file_get_contents($file->getRealPath()), $fileName)
                    ->post(self::N8N_WEBHOOK_URL);

                Log::info('n8n Response Details', [
                    'file' => $fileName,
                    'status_code' => $response->status(),
                    'headers' => $response->headers(),
                    'body_size' => strlen($response->body()),
                    'body_preview' => substr($response->body(), 0, 500),
                    'full_body' => $response->body()
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    if (json_last_error() === JSON_ERROR_NONE && !empty($data)) {
                        $parsedCv = $this->storeParsedData($data, $fileName, $filePath);
                        $results[] = [
                            'file' => $fileName,
                            'data' => $data,
                            'cv_id' => $parsedCv->id,
                        ];
                    } else {
                        Storage::delete($filePath);
                        $results[] = [
                            'file' => $fileName,
                            'error' => 'Invalid JSON from parser'
                        ];
                    }
                } else {
                    Storage::delete($filePath);
                    $results[] = [
                        'file' => $fileName,
                        'error' => "API Error {$response->status()}"
                    ];
                }
            } catch (\Exception $e) {
                Storage::delete($filePath);
                $results[] = [
                    'file' => $fileName,
                    'error' => $e->getMessage()
                ];
            }
        }

        return view('resume.result', ['results' => $results]);
    }

    /**
     * Multiple file upload & parse
     */
    // public function uploadMultiple(Request $request)
    // {
    //     $request->validate([
    //         'resumes' => 'required',
    //         'resumes.*' => 'mimes:pdf,doc,docx,png,jpg,jpeg|max:2048'
    //     ]);

    //     $results = [];
    //     $errors = [];
    //     $debugInfo = [];

    //     try {
    //         // Store locally & prepare the HTTP request
    //         $http = Http::timeout(300); // Allow long uploads
    //         foreach ($request->file('resumes') as $file) {
    //             $fileName = $file->getClientOriginalName();
    //             $filePath = $file->store('resumes');

    //             $http->attach(
    //                 'files[]',
    //                 file_get_contents($file->getRealPath()),
    //                 $fileName
    //             );

    //             // Keep track for debugging
    //             $debugInfo[$fileName] = ['stored_path' => $filePath];
    //         }

    //         // Send all files in one POST request to n8n
    //         $response = $http->post(self::N8N_WEBHOOK_URL);

    //         if ($response->successful()) {
    //             $data = $response->json();

    //             if (json_last_error() === JSON_ERROR_NONE && !empty($data)) {
    //                 foreach ($data as $index => $cvData) {
    //                     $fileName = $request->file('resumes')[$index]->getClientOriginalName();
    //                     $filePath = $debugInfo[$fileName]['stored_path'];

    //                     $parsedCv = $this->storeParsedData($cvData, $fileName, $filePath);
    //                     $results[] = $parsedCv;
    //                 }
    //             } else {
    //                 $errors[] = [
    //                     'error' => 'Invalid JSON response: ' . json_last_error_msg()
    //                 ];
    //             }
    //         } else {
    //             $errors[] = [
    //                 'error' => "HTTP {$response->status()}: {$response->reason()}"
    //             ];
    //         }
    //     } catch (Exception $e) {
    //         $errors[] = ['error' => $e->getMessage()];
    //     }

    //     return view('resume', [
    //         'results' => $results,
    //         'errors' => $errors,
    //         'debug_info' => $debugInfo
    //     ]);
    // }

    public function uploadMultiple(Request $request)
    {
        $request->validate([
            'resumes' => 'required',
            'resumes.*' => 'mimes:pdf,doc,docx,png,jpg,jpeg'
        ]);

        $results = [];
        $errors = [];
        $debugInfo = [];

        try {
            $userId = Auth::id(); 
            
            $http = Http::timeout(300)->asMultipart()
                ->attach('user_id', $userId);

            foreach ($request->file('resumes') as $file) {
                $fileName = $file->getClientOriginalName();
                $filePath = $file->store('resumes');

                $http->attach(
                    'files[]',
                    file_get_contents($file->getRealPath()),
                    $fileName
                );

                $debugInfo[$fileName] = ['stored_path' => $filePath];
            }

            $response = $http->post(self::N8N_WEBHOOK_URL);

            if ($response->successful()) {
                $data = $response->json();

                if (json_last_error() === JSON_ERROR_NONE && !empty($data)) {
                    foreach ($data as $index => $cvData) {
                        $fileName = $request->file('resumes')[$index]->getClientOriginalName();
                        $filePath = $debugInfo[$fileName]['stored_path'];

                        $parsedCv = $this->storeParsedData($cvData, $fileName, $filePath);
                        $results[] = $parsedCv;
                    }
                } else {
                    $errors[] = ['error' => 'Invalid JSON response: ' . json_last_error_msg()];
                }
            } else {
                $errors[] = ['error' => "HTTP {$response->status()}: {$response->reason()}"];
            }
        } catch (\Exception $e) {
            $errors[] = ['error' => $e->getMessage()];
        }

        return view('resume', [
            'results' => $results,
            'errors' => $errors,
            'debug_info' => $debugInfo
        ]);
    }

    //Protected method to store parsed CV data
    protected function storeParsedData($data, $fileName, $filePath = null)
    {
        Log::info("Storing parsed data for: {$fileName}", [
            'data_keys' => is_array($data) ? array_keys($data) : 'not_array',
            'data_type' => gettype($data)
        ]);

        // Handle different response structures
        $extractedData = $this->extractCvData($data);

        $parsedCv = ParsedCv::create([
            'candidate_name' => $extractedData['name'],
            'candidate_first_name' => $extractedData['first_name'],
            'candidate_last_name' => $extractedData['last_name'],
            'email' => $extractedData['email'],
            'phone_number' => $extractedData['phone'],
            'address_line_1' => $extractedData['address'],
            'area' => $extractedData['area'],
            'city' => $extractedData['city'],
            'partial_post_code' => $extractedData['postal_code'],
            'full_post_code' => $extractedData['postal_code'],
            'summary' => $extractedData['summary'],
            'skills' => json_encode($extractedData['skills']),
            'experience' => json_encode($extractedData['experience']),
            'education' => json_encode($extractedData['education']),
            'certifications' => json_encode($extractedData['certifications']),
            'current_organization' => $extractedData['current_organization'],
            'position_title' => $extractedData['position_title'],
            'total_experience' => $extractedData['total_experience'],
            'file_name' => $fileName,
            'file_path' => $filePath,
            'parsed_fields' => json_encode($data),
        ]);

        Log::info("Stored CV data", [
            'cv_id' => $parsedCv->id,
            'name' => $extractedData['name'],
            'email' => $extractedData['email'],
            'skills_count' => count($extractedData['skills'])
        ]);

        return $parsedCv;
    }

    /**
     * Extract CV data from different response formats
     */
    private function extractCvData($data)
    {
        // Initialize with defaults
        $extracted = [
            'name' => null,
            'first_name' => null,
            'last_name' => null,
            'email' => null,
            'phone' => null,
            'address' => null,
            'area' => null,
            'city' => null,
            'postal_code' => null,
            'summary' => null,
            'skills' => [],
            'experience' => [],
            'education' => [],
            'certifications' => [],
            'current_organization' => null,
            'position_title' => null,
            'total_experience' => null
        ];

        if (!is_array($data) && !is_object($data)) {
            Log::warning('Data is not array or object', ['data_type' => gettype($data)]);
            return $extracted;
        }

        // Convert object to array
        if (is_object($data)) {
            $data = json_decode(json_encode($data), true);
        }

        // Extract name information
        if (isset($data['name'])) {
            if (is_array($data['name'])) {
                $extracted['name'] = $data['name']['raw'] ?? $data['name']['full'] ?? null;
                $extracted['first_name'] = $data['name']['first'] ?? null;
                $extracted['last_name'] = $data['name']['last'] ?? null;
            } else {
                $extracted['name'] = $data['name'];
            }
        }

        // Try other name fields
        $extracted['name'] = $extracted['name'] ?? $data['full_name'] ?? $data['candidate_name'] ?? null;

        // Extract contact info
        $extracted['email'] = $data['emails'][0] ?? $data['email'] ?? null;
        $extracted['phone'] = $data['phoneNumbers'][0] ?? $data['phone'] ?? $data['phone_number'] ?? null;

        // Extract location
        if (isset($data['location'])) {
            $location = $data['location'];
            $extracted['address'] = ($location['streetNumber'] ?? '') . ' ' . ($location['street'] ?? '');
            $extracted['area'] = $location['formatted'] ?? null;
            $extracted['city'] = $location['city'] ?? null;
            $extracted['postal_code'] = $location['postalCode'] ?? null;
        }

        // Extract other fields
        $extracted['summary'] = $data['summary'] ?? $data['objective'] ?? null;

        // Extract skills
        if (isset($data['skills']) && is_array($data['skills'])) {
            $extracted['skills'] = array_map(function ($skill) {
                return is_array($skill) ? ($skill['name'] ?? $skill) : $skill;
            }, $data['skills']);
        }

        // Extract work experience
        if (isset($data['workExperience']) && is_array($data['workExperience'])) {
            $extracted['experience'] = $data['workExperience'];
            $extracted['current_organization'] = $data['workExperience'][0]['organization'] ?? null;
            $extracted['position_title'] = $data['workExperience'][0]['jobTitle'] ?? null;
        }

        // Extract education
        if (isset($data['education']) && is_array($data['education'])) {
            $extracted['education'] = $data['education'];
        }

        // Extract other info
        $extracted['certifications'] = $data['certifications'] ?? [];
        $extracted['total_experience'] = $data['totalYearsExperience'] ?? null;

        return $extracted;
    }

    /**
     * Show individual CV
     */
    public function show($id)
    {
        $parsedCv = ParsedCv::findOrFail($id);

        $skills = json_decode($parsedCv->skills, true) ?? [];
        $experience = json_decode($parsedCv->experience, true) ?? [];
        $education = json_decode($parsedCv->education, true) ?? [];
        $certifications = json_decode($parsedCv->certifications, true) ?? [];
        $languages = []; // Add if you have languages field
        $rawData = json_decode($parsedCv->parsed_fields, true) ?? [];

        return view('resume.result', compact(
            'parsedCv',
            'skills',
            'experience',
            'education',
            'certifications',
            'languages',
            'rawData'
        ));
    }

    /**
     * Delete CV
     */
    public function destroy($id)
    {
        $parsedCv = ParsedCv::findOrFail($id);

        // Delete file if exists
        if ($parsedCv->file_path && Storage::exists($parsedCv->file_path)) {
            Storage::delete($parsedCv->file_path);
        }

        $parsedCv->delete();

        return redirect()->route('resume.index')->with('success', 'CV deleted successfully.');
    }

    /**
     * Bulk delete CVs
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back()->withErrors(['msg' => 'No CVs selected for deletion.']);
        }

        $parsedCvs = ParsedCv::whereIn('id', $ids)->get();

        foreach ($parsedCvs as $cv) {
            if ($cv->file_path && Storage::exists($cv->file_path)) {
                Storage::delete($cv->file_path);
            }
        }

        ParsedCv::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' CV(s) deleted successfully.');
    }

    /**
     * Export CVs
     */
    public function export(Request $request)
    {
        $parsedCvs = ParsedCv::all();

        $filename = 'parsed_cvs_' . date('Y-m-d_H-i-s') . '.json';

        return response()->json($parsedCvs->toArray())
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Test n8n webhook - for debugging
     */
    public function testWebhook(Request $request)
    {
        if (!$request->hasFile('test_file')) {
            return response()->json(['error' => 'No file provided for testing']);
        }

        $file = $request->file('test_file');
        $fileName = $file->getClientOriginalName();

        Log::info('Testing webhook with file: ' . $fileName);

        try {
            $response = Http::timeout(120)
                ->attach('file', file_get_contents($file->getRealPath()), $fileName)
                ->post(self::N8N_WEBHOOK_URL);

            $result = [
                'webhook_url' => self::N8N_WEBHOOK_URL,
                'file_name' => $fileName,
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType(),
                'response' => [
                    'status_code' => $response->status(),
                    'headers' => $response->headers(),
                    'body_size' => strlen($response->body()),
                    'body_preview' => substr($response->body(), 0, 500),
                    'full_body' => $response->body(),
                    'successful' => $response->successful()
                ]
            ];

            if ($response->successful()) {
                try {
                    $jsonData = $response->json();
                    $result['response']['json_data'] = $jsonData;
                    $result['response']['json_keys'] = array_keys($jsonData);
                } catch (Exception $e) {
                    $result['response']['json_error'] = $e->getMessage();
                }
            }

            return response()->json($result, 200, [], JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Exception occurred',
                'message' => $e->getMessage(),
                'webhook_url' => self::N8N_WEBHOOK_URL,
                'file_name' => $fileName
            ]);
        }
    }

    //List View for parsed CVs
    public function list()
    {
        // $parsedCvs = ParsedCv::latest()->paginate(20);

        return view('resume.list');
    }
}
