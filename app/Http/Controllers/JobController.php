<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyEmployee;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    //index
    public function index(Request $request)
    {
        try {
            $id = $request->input('id');
            if ($id) {
                $jobs = Job::with(['company', 'targetCompany', 'owner', 'createdBy', 'questions', 'contacts', 'collaborators', 'primaryContact'])->find($id);
                return response()->json(
                    ['jobs' => $jobs]
                );
            } else {
                $jobs = Job::with(['company', 'targetCompany', 'owner', 'createdBy', 'questions', 'contacts', 'collaborators', 'primaryContact'])->get();
            }
            // Prepare datasets required to render the create form on the index page
            $user = Auth::user();
            if (!$user) {
                throw new \Exception('User not authenticated');
            }

            $user = User::with(['companies', 'company.creator'])->find($user->id);
            if (!$user) {
                throw new \Exception('User not found');
            }

            $users = User::all();
            $target_companies = Company::all();

            $companies = collect();
            if ($user->hasRole('Recruiter Company')) {
                $companies = $user->companies ?? collect();
            } else {
                if ($user->company && $user->company->created_by) {
                    $creator = User::with(['companies'])->find($user->company->created_by);
                    $companies = $creator->companies ?? collect();
                }
            }

            return view('jobs.index', compact('jobs', 'companies', 'target_companies', 'users'));
        } catch (\Exception $e) {

            // Return a view with error message or redirect with error
            return back()->with('error', 'An error occurred while loading the page.');
        }
    }
    public function create()
    {
        try {
            // Get authenticated user with eager loading
            $user = Auth::user();
            if (!$user) {
                throw new \Exception('User not authenticated');
            }

            // Load user with relationships
            $user = User::with(['companies', 'company.creator'])->find($user->id);
            // dd($user);
            if (!$user) {
                throw new \Exception('User not found');
            }

            // Get all users (consider pagination for large datasets)
            $users = User::all();
            $target_companies = Company::all();

            // Initialize companies
            $companies = collect(); // Default to empty collection

            if ($user->hasRole('Recruiter Company')) {
                $companies = $user->companies ?? collect();
            } else {
                // Check if company and creator exist before accessing
                if ($user->company && $user->company->created_by) {

                    $creator = User::with(['companies'])->find($user->company->created_by);
                    //   dd($creator);
                    $companies = $creator->companies ?? collect();
                }
            }

            return view('jobs.add', compact('companies', 'target_companies', 'users'));
        } catch (\Exception $e) {
            // Log the error for debugging
            // \Log::error('Error in jobs index: ' . $e->getMessage());
            dd($e->getMessage());

            // Return a view with error message or redirect with error
            return back()->with('error', 'An error occurred while loading the page.');
        }
    }
    //store
    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            $data = $request->validate([
                'job_title' => 'required',
                'no_of_openings' => 'required',
                'company_id' => 'required',
                'target_company_id' => 'nullable',
                'job_description' => 'required',
                'location_type' => 'required',
                'job_type' => 'required',
                'job_category' => 'nullable',
                'min_experience' => 'required',
                'max_experience' => 'required',
                'salary_type' => 'nullable',
                'currency' => 'required',
                'min_salary' => 'required',
                'max_salary' => 'required',
                'educational_qualification' => 'nullable',
                'educational_specialization' => 'nullable',
                'locality' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'postal_code' => 'required',
                'full_address' => 'required',
                // 'owner_id' => 'required',
                'job_collaborator' => 'nullable|array',
                'note_for_candidates' => 'nullable',
                'questions' => 'nullable|array',
                'attachments' => 'nullable',
                'skills' => 'nullable',
                'primary_contact_id' => 'required|exists:contacts,id',
                'secondary_contacts' => 'nullable|array',
                'secondary_contacts.*' => 'nullable|exists:contacts,id',

            ]);
            // dd($data);
            if ($user->hasRole('Recruiter Company')) {
                $data['owner_id'] = auth()->user()->id;
            } else {
                // Check if company and creator exist before accessing
                if ($user->company && $user->company->created_by) {
                    $data['owner_id'] = $user->company->created_by;
                }
            }
            $data['created_by'] = auth()->user()->id;
            $job = Job::create($data);
            if (!empty($data['job_collaborator'])) {
                $collaboratorsData = array_map(function ($id) {
                    return ['user_id' => $id];
                }, $data['job_collaborator']);
                //   dd($collaboratorsData);
                $job->collaborators()->createMany($collaboratorsData);
            }
            if (!empty($data['questions'])) {
                $questionsData = array_map(function ($q) {
                    return ['question' => $q];
                }, $data['questions']);
                // dd($questionsData);
                $job->questions()->createMany($questionsData);
            }
            if (!empty($data['secondary_contacts'])) {
                $contactsData = array_map(function ($contact_id) {
                    return ['contact_id' => $contact_id];
                }, $data['secondary_contacts']);
                // dd($contactsData);
                $job->contacts()->createMany($contactsData);
            }

            // For AJAX requests, return JSON so the page doesn't reload
            if ($request->ajax()) {
                $job->load(['company', 'targetCompany', 'owner', 'createdBy']);
                return response()->json([
                    'message' => 'Job created successfully.',
                    'job' => $job,
                ]);
            }

            return redirect()->route('jobs.index')->with('success', 'Job created successfully.');
        } catch (\Exception $e) {

            // Return a view with error message or redirect with error
            return back()->with('error', 'An error occurred while loading the page. ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $job = Job::findOrFail($id);
            return response()->json([
                'job' => $job,
                'collaborator_ids' => $job->collaborators->pluck('user_id'),
                'contacts' => $job->contacts->pluck('contact_id'),
                'questions' => $job->questions->pluck('question')
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Job not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
      
            $user = Auth::user();
            $job = Job::findOrFail($id);

            $data = $request->validate([
                'job_title' => 'required',
                'no_of_openings' => 'required',
                'company_id' => 'required',
                'target_company_id' => 'nullable',
                'job_description' => 'required',
                'location_type' => 'required',
                'job_type' => 'required',
                'job_category' => 'nullable',
                'min_experience' => 'required',
                'max_experience' => 'required',
                'salary_type' => 'required',
                'currency' => 'required',
                'min_salary' => 'required',
                'max_salary' => 'required',
                'educational_qualification' => 'nullable',
                'educational_specialization' => 'nullable',
                'locality' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'postal_code' => 'required',
                'full_address' => 'required',
                'collaborator' => 'nullable|array',
                'note_for_candidates' => 'nullable',
                'attachments' => 'nullable',
                'questions' => 'nullable|array',
                'sills' => 'nullable',
                'primary_contact_id' => 'required|exists:contacts,id',
                'secondary_contacts' => 'nullable|array',
                'secondary_contacts.*' => 'nullable|exists:contacts,id',
            ]);

            // \Log::info('Validation passed, updating job with data: ' . json_encode($data));
            $job->update($data);

            // Handle collaborators - sync without duplicates
            if (!empty($data['collaborator'])) {
                // Get existing collaborator IDs
                $existingCollaborators = $job->collaborators->pluck('user_id')->toArray();

                // Filter out collaborators that already exist
                $newCollaborators = array_diff($data['collaborator'], $existingCollaborators);

                if (!empty($newCollaborators)) {
                    $collaboratorsData = array_map(function ($id) {
                        return ['user_id' => $id];
                    }, $newCollaborators);

                    $job->collaborators()->createMany($collaboratorsData);
                }
            }

            // Handle questions - delete existing and create new ones to avoid duplicates
            if (!empty($data['questions'])) {
                // Delete all existing questions first
                $job->questions()->delete();

                // Create new questions from the submitted data
                $questionsData = array_map(function ($q) {
                    return ['question' => $q]; // Make sure this matches your column name
                }, array_unique($data['questions'])); // Use array_unique to prevent duplicates

                $job->questions()->createMany($questionsData);
            }
            //secondary_contacts
            if (!empty($data['secondary_contacts'])) {
                $contactsData = array_map(function ($contact_id) {
                    return ['contact_id' => $contact_id];
                }, $data['secondary_contacts']);
                $job->contacts()->createMany($contactsData);
            }
            // For AJAX requests, return JSON so the page doesn't reload
            // For AJAX requests, return JSON
            $job->load(['company', 'targetCompany', 'owner', 'createdBy', 'collaborators', 'questions']);
            return response()->json([
                'message' => 'Job updated successfully.',
                'job' => $job,
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('error', 'An error occurred while updating the job.');
        }
    }

    public function destroy($id)
    {
        try {
            \Log::info('Delete request received for job ID: ' . $id);

            $job = Job::findOrFail($id);
            $jobTitle = $job->job_title; // Store for logging

            // Delete the job
            $job->delete();

            \Log::info('Job deleted successfully: ' . $jobTitle);

            // For AJAX requests, return JSON
            if (request()->ajax()) {
                return response()->json([
                    'message' => 'Job deleted successfully.',
                    'deleted_id' => $id
                ]);
            }

            return redirect()->route('jobs.index')->with('success', 'Job deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting job ID ' . $id . ': ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json(['error' => 'Failed to delete job: ' . $e->getMessage()], 500);
            }

            return back()->with('error', 'An error occurred while deleting the job.');
        }
    }
    //job details
    public function details($id)
    {
        try {
            // \Log::info('Delete request received for job ID: ' . $id);

            $job = Job::with(['company', 'targetCompany', 'owner', 'createdBy', 'collaborators', 'questions', 'contacts', 'primaryContact', 'secondaryContacts', 'notes'])->findOrFail($id);
            // dd($job);
            return view('jobs.show', compact('job'));
        } catch (\Exception $e) {
            // \Log::error('Error deleting job ID ' . $id . ': ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json(['error' => 'Failed to delete job: ' . $e->getMessage()], 500);
            }

            return back()->with('error', 'An error occurred while deleting the job.');
        }
    }
    public function bulkDestroy(Request $request)
    {
        try {
            $request->validate([
                'job_ids' => 'required|array',
                'job_ids.*' => 'integer|exists:crm_jobs,id'
            ]);

            $jobIds = $request->input('job_ids');
            \Log::info('Bulk delete request received for job IDs: ' . implode(', ', $jobIds));

            $deletedCount = 0;
            $deletedTitles = [];

            foreach ($jobIds as $jobId) {
                $job = Job::find($jobId);
                if ($job) {
                    $deletedTitles[] = $job->job_title;
                    $job->delete();
                    $deletedCount++;
                }
            }

            // \Log::info("Bulk delete completed. Deleted {$deletedCount} jobs: " . implode(', ', $deletedTitles));

            // For AJAX requests, return JSON
            if ($request->ajax()) {
                return response()->json([
                    'message' => "Successfully deleted {$deletedCount} job(s).",
                    'deleted_count' => $deletedCount,
                    'deleted_ids' => $jobIds
                ]);
            }

            return redirect()->route('jobs.index')->with('success', "Successfully deleted {$deletedCount} job(s).");
        } catch (\Exception $e) {
            // \Log::error('Error in bulk delete: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['error' => 'Failed to delete jobs: ' . $e->getMessage()], 500);
            }

            return back()->with('error', 'An error occurred while deleting the jobs.');
        }
    }
}
