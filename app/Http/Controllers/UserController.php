<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function manage()
    {
        $companies = User::all();
        return view('admin.users.manage', compact('companies'));
    }

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

    public function create()
    {
        $companies = Company::all();
        return view('admin.users.create', compact('companies'));
    }

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
