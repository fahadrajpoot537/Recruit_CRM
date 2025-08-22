<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyEmployee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    // Show create form (only for Recruiter)
    public function addcompany()
    {
        $creators = User::role('Recruiter Company')->get();
        return view('company.add', compact('creators'));
    }

    // Store new company
  public function store(Request $request)
{
    $validationRules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:companies,email',
        'contact' => 'required|string|max:255',
        'registration_number' => 'required|string|max:255',
        'postal_code' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:500',
        'city' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:255',
        'country' => 'nullable|string|max:255',
        'contractpname' => 'nullable|string|max:255',
        'company_description' => 'nullable|string|max:1000',
        'head_office' => 'nullable|string|max:255',
        'no_of_employes' => 'nullable|string|max:50',
        'no_of_offices' => 'nullable|string|max:50',
        'industry' => 'nullable|string|max:255',
        'facebook' => 'nullable|url|max:255',
        'linkedln' => 'nullable|url|max:255',
        'instagram' => 'nullable|url|max:255',
        'website' => 'nullable|url|max:255',
        'type' => 'required|in:resources,recruiter',
    ];

    if (Auth::user()->role == 'super-admin') {
        $validationRules['company_user_id'] = 'required|exists:users,id';
    }

    $validated = $request->validate($validationRules);

    $company = Company::create($validated);

    if (Auth::user()->role == 'super-admin') {
        $company->creators()->attach($validated['company_user_id']);
    } else {
        $company->creators()->attach(Auth::id());
    }

    return redirect()->route('companies.index')->with('success', 'Company created successfully!');
}

    // Show all companies created by auth user
    public function index()
    {
        $user=Auth::user();
        if ($user->hasRole('super-admin')) {
            $companies = Company::latest()->get();
        } else {
            $companies = Auth::user()->createdCompanies()->latest()->get();
        }


        return view('company.index', compact('companies'));
    }

    // Show specific company (only if belongs to auth user)
    public function show(Company $company)
    {
        if (!$company->creators->contains(Auth::id())) {
            abort(403, 'Unauthorized');
        }
        $company_users = $company->company_users()->with('user')->get();
        return view('company.show', compact('company', 'company_users'));
    }

    //Edit Company View
    public function edit(Company $company)
    {
        $company->load('creators');
        if (!$company->creators->contains(Auth::id())) {
            abort(403, 'Unauthorized');
        }

        return view('company.edit', compact('company'));
    }

    //Update Existing Company
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'contractpname' => $request->contractpname,
            'company_description' => $request->company_description,
            'head_office' => $request->head_office,
            'no_of_employes' => $request->no_of_employes,
            'no_of_offices' => $request->no_of_offices,
            'industry' => $request->industry,
            'facebook' => $request->facebook,
            'linkedln' => $request->linkedln,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'type' => $request->type,
        ]);

        return redirect()->route('companies.index')->with('success', 'Company updated successfully!');
    }
}
