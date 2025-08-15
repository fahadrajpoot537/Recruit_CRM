<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contact;
use App\Models\ContactCompany;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    //
    public function index()
    {
        $contacts = Contact::get();
        $companies = Company::get();
        return view('contact.index', compact('contacts', 'companies'));
    }
    //create
    public function create()
    {
        $companies = Company::get();
        return view('contact.add', compact('companies'));
    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:contacts,email',
                'phone' => 'required|string|max:20',
                'facebook_profile_url' => 'nullable|url|max:255',
                'twitter_profile_url' => 'nullable|url|max:255',
                'linkedin_profile_url' => 'nullable|url|max:255',
                'xing_profile_url' => 'nullable|url|max:255',
                'stage' => 'required|string|in:Lead,Prospect,Customer,Partner',
                'locality' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
                'postal_code' => 'nullable|string|max:20',
                'full_address' => 'required|string',
                'company_ids' => 'required|array|min:1',
                'company_ids.*' => 'exists:companies,id'
            ]);

            $contact = Contact::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'title' => $validated['title'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'facebook_profile_url' => $validated['facebook_profile_url'],
                'twitter_profile_url' => $validated['twitter_profile_url'],
                'linkedin_profile_url' => $validated['linkedin_profile_url'],
                'xing_profile_url' => $validated['xing_profile_url'],
                'stage' => $validated['stage'],
                'locality' => $validated['locality'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'country' => $validated['country'],
                'postal_code' => $validated['postal_code'],
                'full_address' => $validated['full_address'],
                'created_by' => auth()->id()
            ]);

            $contact->companies()->sync($validated['company_ids']);
            $contact->load('companies');

            return response()->json([
                'success' => true,
                'message' => 'Contact created successfully',
                'contact' => $contact
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }
    //edit
    public function edit($id)
    {
        try {
            $contact = Contact::with('companies')->findOrFail($id);
            return response()->json([
                'success' => true,
                'contact' => $contact,
                'companies' => Company::all()
            ]);
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Contact not found'
                ], 404);
            }

            return redirect()->route('contact.index')->with('error', 'Contact not found');
        }
    }
    //update
    public function update(Request $request, $id)
    {
        try {
            // ✅ Validate input
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name'  => 'nullable|string|max:255',
                'title'      => 'nullable|string|max:255',
                'email'      => 'nullable|email|unique:contacts,email,' . $id . '|max:255',
                'phone'      => 'nullable|string|max:20',
                'facebook_url' => 'nullable|url|max:255',
                'twitter_url'  => 'nullable|url|max:255',
                'linkedin_url' => 'nullable|url|max:255',
                'xing_url'     => 'nullable|url|max:255',
                'stage'        => 'nullable|string|max:255',
                'locality'     => 'nullable|string|max:255',
                'city'         => 'nullable|string|max:255',
                'state'        => 'nullable|string|max:255',
                'country'      => 'nullable|string|max:255',
                'postal_code'  => 'nullable|string|max:20',
                'full_address' => 'nullable|string|max:500',
                'company_ids'  => 'nullable|array',
                'company_ids.*' => 'exists:companies,id'
            ]);

            // ✅ Find contact
            $contact = Contact::findOrFail($id);

            // ✅ Update contact data
            $contact->update($validatedData);

            // ✅ Sync companies without duplicates
            if (!empty($validatedData['company_ids'])) {
                $companyIds = array_unique($validatedData['company_ids']); // remove duplicates
                $contact->companies()->sync($companyIds);
            } else {
                $contact->companies()->detach(); // optional: remove all companies if none selected
            }
            $contact->load('companies');
            return response()->json([
                'message' => 'Contact updated successfully.',
                'contact' => $contact,
                'companies' => Company::all()
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }
    //delete
    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
            return response()->json([
                'message' => 'Contact deleted successfully.',
                'deleted_id' => $id
            ]);
            // return redirect()->back()->with('success', 'Contact deleted successfully');
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return response()->json(['error' => 'Failed to delete contact: ' . $e->getMessage()], 500);
        }
    }

    public function getContactsByCompany(Request $request)
    {
        $companyId = $request->input('company_id');

        // Validate company exists
        if (!Company::where('id', $companyId)->exists()) {
            return response()->json([
                'contacts' => []
            ]);
        }

        $contacts = Contact::whereHas('companies', function ($query) use ($companyId) {
            $query->where('companies.id', $companyId);
        })
            ->select('id', 'first_name','last_name')
            ->get();

        return response()->json([
            'contacts' => $contacts
        ]);
    }
}
