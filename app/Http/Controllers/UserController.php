<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
  protected $guarded;
    //Manage Users
    public function manage()
    {
        $companies = User::role('Recruiter Company')->get(); // Only users with this role
        return view('admin.users.manage', compact('companies'));
    }

    public function details($id)
    {
        $user = User::with('createdCompanies')->findOrFail($id);

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'status' => $user->status,
            'companies' => $user->createdCompanies->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'contact' => $company->contact ?? 'N/A',
                    'email' => $company->email ?? 'N/A',
                    'postal_code' => $company->postal_code ?? 'N/A',
                    'address' => $company->address ?? 'N/A',
                    'city' => $company->city ?? 'N/A',
                    'state' => $company->state ?? 'N/A',
                    'country' => $company->country ?? 'N/A',
                    'contractpname' => $company->contractpname ?? 'N/A',
                    'company_description' => $company->company_description ?? 'N/A',
                    'head_office' => $company->head_office ?? 'N/A',
                    'no_of_employes' => $company->no_of_employes ?? 'N/A',
                    'no_of_offices' => $company->no_of_offices ?? 'N/A',
                    'industry' => $company->industry ?? 'N/A',
                    'facebook' => $company->facebook ?? 'N/A',
                    'linkedln' => $company->linkedln ?? 'N/A',
                    'instagram' => $company->instagram ?? 'N/A',
                    'twitter' => $company->twitter ?? 'N/A',
                ];
            }),
        ]);

    }


    //Update Status From AJAX
    public function updateStatus(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $user->status = $request->status;
            $user->save();

            return response()->json(['message' => 'Status updated successfully.']);
        }

        return response()->json(['message' => 'User not found.'], 404);
    }

    //Create View
    public function create()
    {
        $companies = Company::all();
        return view('admin.users.create', compact('companies'));
    }

    //Store Data
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        // Assign default role "Recruiter"
        $user->assignRole('Recruiter Company');

        return redirect()->route('admin.companies.manage')->with('success', 'User created successfully!');
    }
}
