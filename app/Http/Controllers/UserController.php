<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Propaganistas\LaravelPhone\Rules\Phone;

class UserController extends Controller
{
    /**
     * Display user list with search, filters, sorting and pagination.
     */
    public function index(Request $request)
    {
        $query = User::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                )
                    ->orWhere(
                        'email',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'phone',
                        'like',
                        '%' . $search . '%'
                    );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Registration Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filter === 'today') {

            $query->whereDate(
                'created_at',
                today()
            );

        } elseif ($request->filter === 'month') {

            $query->whereMonth(
                'created_at',
                now()->month
            )
                ->whereYear(
                    'created_at',
                    now()->year
                );

        } elseif ($request->filter === 'recent') {

            $query->where(
                'created_at',
                '>=',
                now()->subDays(7)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Date Range Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('start_date')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->start_date
            );
        }

        if ($request->filled('end_date')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->end_date
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        |
        | Default:
        | ID ASC
        |
        | Result:
        | 1, 2, 3, 4, 5...
        |
        */

        $allowedSorts = [
            'id',
            'name',
            'email',
            'phone',
            'created_at',
        ];

        $sort = $request->get(
            'sort',
            'id'
        );

        if (!in_array(
            $sort,
            $allowedSorts
        )) {
            $sort = 'id';
        }

        $direction = $request->get(
            'direction',
            'asc'
        );

        if (!in_array(
            $direction,
            ['asc', 'desc']
        )) {
            $direction = 'asc';
        }

        $query->orderBy(
            $sort,
            $direction
        );

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $users = $query
            ->paginate(5)
            ->withQueryString();

        return view(
            'users.index',
            compact('users')
        );
    }


    /**
     * Phone management dashboard.
     */
    public function dashboard()
    {
        $totalUsers = User::count();

        $todayUsers = User::whereDate(
            'created_at',
            today()
        )->count();

        $monthUsers = User::whereMonth(
            'created_at',
            now()->month
        )
            ->whereYear(
                'created_at',
                now()->year
            )
            ->count();

        $recentUsers = User::where(
            'created_at',
            '>=',
            now()->subDays(7)
        )->count();

        $latestUsers = User::latest()
            ->take(5)
            ->get();

        $users = User::all();
        $countryCounts = [];
        $flagMap = [
            'IN' => ['flag' => '🇮🇳', 'name' => 'India'],
            'US' => ['flag' => '🇺🇸', 'name' => 'United States'],
            'GB' => ['flag' => '🇬🇧', 'name' => 'United Kingdom'],
            'AE' => ['flag' => '🇦🇪', 'name' => 'UAE'],
            'CA' => ['flag' => '🇨🇦', 'name' => 'Canada'],
            'AU' => ['flag' => '🇦🇺', 'name' => 'Australia'],
            'DE' => ['flag' => '🇩🇪', 'name' => 'Germany'],
            'FR' => ['flag' => '🇫🇷', 'name' => 'France'],
            'JP' => ['flag' => '🇯🇵', 'name' => 'Japan'],
            'SG' => ['flag' => '🇸🇬', 'name' => 'Singapore'],
        ];

        foreach ($users as $u) {
            $code = 'OTHER';
            try {
                $detected = phone($u->phone)->getCountry();
                if ($detected && isset($flagMap[$detected])) {
                    $code = $detected;
                }
            } catch (\Throwable $e) {
                $code = 'OTHER';
            }
            $countryCounts[$code] = ($countryCounts[$code] ?? 0) + 1;
        }

        $countryAnalytics = [];
        $totalCount = count($users);
        foreach ($countryCounts as $code => $count) {
            $info = $flagMap[$code] ?? ['flag' => '🌐', 'name' => 'Other / Global'];
            $percentage = $totalCount > 0 ? round(($count / $totalCount) * 100, 1) : 0;
            $countryAnalytics[] = [
                'code' => $code,
                'country' => $info['name'],
                'flag' => $info['flag'],
                'count' => $count,
                'percentage' => $percentage,
            ];
        }

        return view(
            'users.dashboard',
            compact(
                'totalUsers',
                'todayUsers',
                'monthUsers',
                'recentUsers',
                'latestUsers',
                'countryAnalytics'
            )
        );
    }


    /**
     * Show create form.
     */
    public function create()
    {
        return view(
            'users.create'
        );
    }


    /**
     * Store new user.
     */
    public function store(Request $request)
    {
        $countryCode = strtoupper($request->input('country_code', 'IN'));
        $supported = ['IN', 'US', 'GB', 'AE', 'CA', 'AU', 'DE', 'FR', 'JP', 'SG'];
        if (!in_array($countryCode, $supported)) {
            $countryCode = 'IN';
        }

        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    'unique:users,email',
                ],

                'country_code' => [
                    'nullable',
                    'string',
                    'in:' . implode(',', $supported),
                ],

                'phone' => [
                    'required',
                    'unique:users,phone',
                    (new Phone)->country([$countryCode, 'AUTO']),
                ],

                'password' => [
                    'required',
                    'string',
                    'min:6',
                ],
            ],
            [
                'phone.phone' =>
                    "Please enter a valid phone number for the selected country ({$countryCode}).",
            ]
        );

        User::create([
            'name' => $request->name,

            'email' => $request->email,

            'phone' => phone(
                $request->phone,
                $countryCode
            )->formatE164(),

            'password' => bcrypt(
                $request->password
            ),
        ]);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User created successfully!'
            );
    }


    /**
     * Show user details.
     */
    public function show(User $user)
    {
        return view(
            'users.show',
            compact('user')
        );
    }


    /**
     * Show edit form.
     */
    public function edit(User $user)
    {
        return view(
            'users.edit',
            compact('user')
        );
    }


    /**
     * Update user.
     */
    public function update(
        Request $request,
        User $user
    ) {
        $countryCode = strtoupper($request->input('country_code', 'IN'));
        $supported = ['IN', 'US', 'GB', 'AE', 'CA', 'AU', 'DE', 'FR', 'JP', 'SG'];
        if (!in_array($countryCode, $supported)) {
            $countryCode = 'IN';
        }

        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    'unique:users,email,' . $user->id,
                ],

                'country_code' => [
                    'nullable',
                    'string',
                    'in:' . implode(',', $supported),
                ],

                'phone' => [
                    'required',
                    'unique:users,phone,' . $user->id,
                    (new Phone)->country([$countryCode, 'AUTO']),
                ],

                'password' => [
                    'nullable',
                    'string',
                    'min:6',
                ],
            ],
            [
                'phone.phone' =>
                    "Please enter a valid phone number for the selected country ({$countryCode}).",
            ]
        );

        $user->name = $request->name;

        $user->email = $request->email;

        $user->phone = phone(
            $request->phone,
            $countryCode
        )->formatE164();

        /*
        |--------------------------------------------------------------------------
        | Update password only when entered
        |--------------------------------------------------------------------------
        */

        if ($request->filled('password')) {

            $user->password = bcrypt(
                $request->password
            );
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User updated successfully!'
            );
    }


    /**
     * Send Mock SMS OTP to User.
     */
    public function sendOtp(User $user)
    {
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        return redirect()
            ->back()
            ->with(
                'success',
                "📲 Mock SMS OTP sent to {$user->name} ({$user->phone}): [ {$otp} ]"
            );
    }


    /**
     * Delete one user.
     */
    public function destroy(User $user)
    {
        $userName = $user->name;

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                "User {$userName} deleted successfully!"
            );
    }


    /**
     * Bulk delete users.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'user_ids' => [
                'required',
                'array',
            ],

            'user_ids.*' => [
                'integer',
                'exists:users,id',
            ],
        ]);

        $count = User::whereIn(
            'id',
            $request->user_ids
        )->delete();

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                "{$count} user(s) deleted successfully!"
            );
    }


    /**
     * Export users to CSV.
     */
    public function export(Request $request)
    {
        $query = User::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                )
                    ->orWhere(
                        'email',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'phone',
                        'like',
                        '%' . $search . '%'
                    );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Registration Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filter === 'today') {

            $query->whereDate(
                'created_at',
                today()
            );

        } elseif ($request->filter === 'month') {

            $query->whereMonth(
                'created_at',
                now()->month
            )
                ->whereYear(
                    'created_at',
                    now()->year
                );

        } elseif ($request->filter === 'recent') {

            $query->where(
                'created_at',
                '>=',
                now()->subDays(7)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Date Range Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('start_date')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->start_date
            );
        }

        if ($request->filled('end_date')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->end_date
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        |
        | Default:
        | ID ASC
        |
        */

        $allowedSorts = [
            'id',
            'name',
            'email',
            'phone',
            'created_at',
        ];

        $sort = $request->get(
            'sort',
            'id'
        );

        if (!in_array(
            $sort,
            $allowedSorts
        )) {
            $sort = 'id';
        }

        $direction = $request->get(
            'direction',
            'asc'
        );

        if (!in_array(
            $direction,
            ['asc', 'desc']
        )) {
            $direction = 'asc';
        }

        $users = $query
            ->orderBy(
                $sort,
                $direction
            )
            ->get();

        /*
        |--------------------------------------------------------------------------
        | CSV Filename
        |--------------------------------------------------------------------------
        */

        $fileName =
            'users-' .
            now()->format(
                'Y-m-d-H-i-s'
            ) .
            '.csv';

        /*
        |--------------------------------------------------------------------------
        | CSV Download
        |--------------------------------------------------------------------------
        */

        return response()->streamDownload(
            function () use ($users) {

                $handle = fopen(
                    'php://output',
                    'w'
                );

                /*
                |--------------------------------------------------------------------------
                | CSV Header
                |--------------------------------------------------------------------------
                */

                fputcsv(
                    $handle,
                    [
                        'ID',
                        'Name',
                        'Email',
                        'Phone',
                        'International Phone',
                        'National Phone',
                        'Created At',
                    ]
                );

                /*
                |--------------------------------------------------------------------------
                | CSV Rows
                |--------------------------------------------------------------------------
                */

                foreach ($users as $user) {

                    fputcsv(
                        $handle,
                        [
                            $user->id,

                            $user->name,

                            $user->email,

                            $user->phone,

                            phone(
                                $user->phone,
                                'IN'
                            )->formatInternational(),

                            phone(
                                $user->phone,
                                'IN'
                            )->formatNational(),

                            optional(
                                $user->created_at
                            )->format(
                                'Y-m-d H:i:s'
                            ),
                        ]
                    );
                }

                fclose($handle);
            },
            $fileName,
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',
            ]
        );
    }
}