<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Propaganistas\LaravelPhone\Rules\Phone;

class UserController extends Controller
{
    /**
     * Display the user list with search and filtering.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search by name, email or phone number
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        // Filter by registration period
        if ($request->filter === 'today') {
            $query->whereDate('created_at', today());
        }

        if ($request->filter === 'month') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        }

        if ($request->filter === 'recent') {
            $query->where('created_at', '>=', now()->subDays(7));
        }

        $users = $query->latest()->get();

        return view('users.index', compact('users'));
    }

    /**
     * Display the phone management dashboard.
     */
    public function dashboard()
    {
        $totalUsers = User::count();

        $todayUsers = User::whereDate('created_at', today())->count();

        $monthUsers = User::whereMonth('created_at', now()->month)
                           ->whereYear('created_at', now()->year)
                           ->count();

        $recentUsers = User::where('created_at', '>=', now()->subDays(7))->count();

        $latestUsers = User::latest()
                           ->take(5)
                           ->get();

        return view('users.dashboard', compact(
            'totalUsers',
            'todayUsers',
            'monthUsers',
            'recentUsers',
            'latestUsers'
        ));
    }

    /**
     * Show the user creation form.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => ['required', 'unique:users,phone', new Phone('IN')],
            'password' => 'required|min:6',
        ], [
            'phone.phone' => 'Please enter a valid Indian phone number.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => phone($request->phone, 'IN')->formatE164(),
            'password' => bcrypt($request->password),
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User Created Successfully');
    }
}