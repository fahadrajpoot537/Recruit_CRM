<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    // Show create form (only for Recruiter)
    public function addcompany()
    {
        return view('company.add');
    }

    // Store new company
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'contact' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'contractpname' => 'nullable|string',
            'company_description' => 'nullable|string',
            'head_office' => 'nullable|string',
            'no_of_employes' => 'nullable|string',
            'no_of_offices' => 'nullable|string',
            'industry' => 'nullable|string',
            'facebook' => 'nullable|string',
            'linkedln' => 'nullable|string',
            'instagram' => 'nullable|string',
            'twitter' => 'nullable|string',
            'type' => 'required|in:resources,recruiter',
        ]);

        $company = Company::create($request->only([
            'name', 'contact', 'email', 'postal_code', 'address', 'city', 'state', 'country',
            'contractpname', 'company_description', 'head_office', 'no_of_employes',
            'no_of_offices', 'industry', 'facebook', 'linkedln', 'instagram', 'twitter', 'type',
        ]));

        $company->creators()->attach(Auth::id());

        return redirect()->route('companies.index')->with('success', 'Company created successfully!');
    }

    // Show all companies created by auth user
    public function index()
    {
        $companies = Auth::user()->createdCompanies()->latest()->get();

        return view('company.index', compact('companies'));
    }

    // Show specific company (only if belongs to auth user)
    public function show(Company $company)
    {
        if (!$company->creators->contains(Auth::id())) {
            abort(403, 'Unauthorized');
        }

        return view('company.show', compact('company'));
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
