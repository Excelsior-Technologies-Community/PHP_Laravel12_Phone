<!DOCTYPE html>
<html>
<head>
    <title>Phone Management Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #222;
        }

        .subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 30px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .button {
            display: inline-block;
            padding: 10px 16px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .users-btn {
            background: #007bff;
        }

        .create-btn {
            background: #28a745;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            text-align: center;
        }

        .card-icon {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .card-title {
            color: #777;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .card-number {
            font-size: 30px;
            font-weight: bold;
            color: #222;
        }

        .info-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        .info-card h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        .phone-feature {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .feature {
            padding: 18px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fafafa;
        }

        .feature strong {
            display: block;
            margin-bottom: 7px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        th {
            background: #007bff;
            color: white;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .phone {
            font-weight: bold;
        }

        .badge {
            background: #e7f1ff;
            color: #0069d9;
            padding: 5px 9px;
            border-radius: 15px;
            font-size: 12px;
        }

        .empty {
            text-align: center;
            color: #777;
            padding: 20px;
        }

        @media (max-width: 900px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .phone-feature {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>📱 Phone Management Dashboard</h1>

    <div class="subtitle">
        Indian Phone Number Validation & User Management
    </div>

    <div class="top-bar">

        <a href="{{ route('users.index') }}"
           class="button users-btn">
            👥 View All Users
        </a>

        <a href="{{ route('users.create') }}"
           class="button create-btn">
            + Create User
        </a>

    </div>

    {{-- Statistics --}}
    <div class="stats">

        <div class="card">

            <div class="card-icon">
                👥
            </div>

            <div class="card-title">
                Total Users
            </div>

            <div class="card-number">
                {{ $totalUsers }}
            </div>

        </div>

        <div class="card">

            <div class="card-icon">
                📅
            </div>

            <div class="card-title">
                Registered Today
            </div>

            <div class="card-number">
                {{ $todayUsers }}
            </div>

        </div>

        <div class="card">

            <div class="card-icon">
                📆
            </div>

            <div class="card-title">
                This Month
            </div>

            <div class="card-number">
                {{ $monthUsers }}
            </div>

        </div>

        <div class="card">

            <div class="card-icon">
                📱
            </div>

            <div class="card-title">
                Last 7 Days
            </div>

            <div class="card-number">
                {{ $recentUsers }}
            </div>

        </div>

    </div>

    {{-- Phone Features --}}
    <div class="info-card">

        <h2>📞 Phone Number Features</h2>

        <div class="phone-feature">

            <div class="feature">

                <strong>🇮🇳 Indian Validation</strong>

                Every registered phone number is validated
                using the Indian phone validation rule.

            </div>

            <div class="feature">

                <strong>🌍 E.164 Storage</strong>

                Phone numbers are stored in international
                E.164 format such as +919876543210.

            </div>

            <div class="feature">

                <strong>📱 Multiple Formats</strong>

                Phone numbers can be displayed in
                international and national formats.

            </div>

        </div>

    </div>

    {{-- Country-wise Phone Distribution Analytics --}}
    <div class="info-card">
        <h2>📊 Country-wise Phone Distribution Analytics</h2>
        <div style="display: flex; gap: 20px; align-items: center; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 280px; max-width: 380px; margin: auto;">
                <canvas id="countryChart"></canvas>
            </div>
            <div style="flex: 1; min-width: 280px;">
                <table>
                    <thead>
                        <tr>
                            <th>Country</th>
                            <th>Users Count</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($countryAnalytics as $item)
                            <tr>
                                <td style="text-align: left; font-weight: bold;">
                                    {{ $item['flag'] }} {{ $item['country'] }} ({{ $item['code'] }})
                                </td>
                                <td>{{ $item['count'] }}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="flex: 1; background: #eee; border-radius: 4px; height: 10px; overflow: hidden;">
                                            <div style="width: {{ $item['percentage'] }}%; background: #007bff; height: 100%;"></div>
                                        </div>
                                        <span>{{ $item['percentage'] }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Latest Users --}}
    <div class="info-card">

        <h2>🆕 Latest Registered Users</h2>

        @if($latestUsers->count() > 0)

            <table>

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Registered</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($latestUsers as $user)

                        <tr>

                            <td>
                                {{ $user->id }}
                            </td>

                            <td>
                                <strong>{{ $user->name }}</strong>
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>

                                <div class="phone">
                                    {{ $user->phone }}
                                </div>

                                @php
                                    $cCode = 'IN';
                                    try {
                                        $cCode = phone($user->phone)->getCountry() ?? 'IN';
                                    } catch (\Throwable $e) {
                                        $cCode = 'IN';
                                    }
                                    $flagMap = [
                                        'IN' => '🇮🇳 India',
                                        'US' => '🇺🇸 USA',
                                        'GB' => '🇬🇧 UK',
                                        'AE' => '🇦🇪 UAE',
                                        'CA' => '🇨🇦 Canada',
                                        'AU' => '🇦🇺 Australia',
                                        'DE' => '🇩🇪 Germany',
                                        'FR' => '🇫🇷 France',
                                        'JP' => '🇯🇵 Japan',
                                        'SG' => '🇸🇬 Singapore',
                                    ];
                                    $cBadge = $flagMap[$cCode] ?? '🌐 Global';
                                @endphp

                                <span class="badge">
                                    {{ $cBadge }}
                                </span>

                            </td>

                            <td>
                                {{ $user->created_at->format('d M Y, h:i A') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <div class="empty">
                No users registered yet.
            </div>

        @endif

    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const analytics = @json($countryAnalytics);
        const labels = analytics.map(a => a.flag + ' ' + a.country);
        const data = analytics.map(a => a.count);
        const colors = ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#17a2b8', '#fd7e14', '#e83e8c', '#20c997', '#6c757d'];

        const ctx = document.getElementById('countryChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors.slice(0, labels.length)
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    });
</script>

</body>
</html>