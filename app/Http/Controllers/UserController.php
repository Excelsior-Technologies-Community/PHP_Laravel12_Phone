<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Propaganistas\LaravelPhone\Rules\Phone;

class UserController extends Controller
{
    // Display list of users ordered by latest first
    public function index()
    {
        $users = User::latest()->get(); // Fetch all users sorted by newest
        return view('users.index', compact('users')); // Return user list view
    }

    // Show the user creation form
    public function create()
    {
        return view('users.create'); // Load create user form view
    }

    // Store a newly created user in the database
    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'name'     => 'required|string|max:255', // Name is required and must be string
            'email'    => 'required|email|unique:users,email', // Email must be unique
            'phone'    => ['required', 'unique:users,phone', new Phone('IN')], // Validate Indian phone number
            'password' => 'required|min:6', // Password minimum length 6
        ], [
            'phone.phone' => 'Please enter a valid Indian phone number.', // Custom error message for phone validation
        ]);

        // Create and store user in database
        User::create([
            'name'     => $request->name, // Store name
            'email'    => $request->email, // Store email
            'phone'    => phone($request->phone, 'IN')->formatE164(), // Store phone in E.164 format (+91XXXXXXXXXX)
            'password' => bcrypt($request->password), // Encrypt password before saving
        ]);

        // Redirect back to user list with success message
        return redirect()->route('users.index')
                        ->with('success', 'User Created Successfully');
    }
}
