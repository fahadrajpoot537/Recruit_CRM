<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyEmployee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class CompanyUserController extends Controller
{
    //index
    public function index(CompanyEmployee $companyEmployee)
    {
        $id = $request->id;
        $company_users = CompanyEmployee::where('company_id', $id)->get();
        dd($company_users);
        return view('company_user.index', compact('company_users'));
    }
    //create
    public function create(Request $request)
    {
        $id = $request->id;
        $company = Company::findOrFail($id);
        // dd($company);
        return view('company_user.add', compact('company'));
    }
    //store


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'company_id' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        try {
            // Create the user
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);
// dd($user);
            // Assign role
            $user->assignRole($request->role);

            // Create company employee record
            CompanyEmployee::create([
                'company_user_id' => $user->id,
                'company_id'      => $request->company_id,
            ]);

            return redirect()
                ->route('companies.show', $request->company_id)
                ->with('success', 'Company Employee created successfully!');
        } catch (Exception $e) {
            // Log the error for debugging
            // Log::error('Error creating company employee: ' . $e->getMessage());
            // dd($e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    //edit
    public function edit(Request $request)
    {

        $id = $request->id;
        $user = User::with('companies')->findOrFail(auth()->user()->id);
        $companies = $user->companies;
        $company_user = CompanyEmployee::with('user.role')->findOrFail($id);
        // dd($company_user->user->name);
        return view('company_user.edit', compact('company_user', 'companies'));
    }

    //update
   public function update(Request $request, $id)
{
    $company_user = CompanyEmployee::findOrFail($id);
    $user = $company_user->user;

    // Validate with the actual user ID for unique email exception
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required',
        'company_id' => 'required',
    ]);

    $company_user->update([
        'company_id' => $request->company_id,
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    $user->syncRoles([$request->role]);

    return redirect()
        ->route('companies.show', $request->company_id)
        ->with('success', 'Company Employee updated successfully!');
}
//delete
public function destroy(Request $request, $id)
{
    // dd($id);

    $company_user = CompanyEmployee::find($id);
    if (!$company_user) {

        return redirect()->back()
            ->with('error', 'Company Employee not found!');
    }
    $company_user->delete();

    return redirect()
        ->route('companies.show', $company_user->company_id)
        ->with('success', 'Company Employee deleted successfully!');
}
public function updateStatus($id)
{
    $companyUser = CompanyEmployee::findOrFail($id);
    $user = $companyUser->user;
    $user->status = !$user->status;
    $user->save();

    return redirect()->back()->with('success', 'User status updated successfully.');
}

}
