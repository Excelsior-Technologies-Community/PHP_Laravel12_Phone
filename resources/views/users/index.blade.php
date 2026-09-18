<!DOCTYPE html>
<html>
<head>
    <title>User List - Phone Management</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #222;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .button {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        .dashboard-btn {
            background: #6f42c1;
        }

        .dashboard-btn:hover {
            background: #59359a;
        }

        .create-btn {
            background: #007bff;
        }

        .create-btn:hover {
            background: #0069d9;
        }

        .success {
            background: #e6ffed;
            padding: 12px;
            border-radius: 6px;
            color: #16803c;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #b7ebc6;
        }

        .search-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        .search-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .search-input {
            flex: 1;
            min-width: 250px;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .filter-select {
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 6px;
            min-width: 180px;
        }

        .search-btn {
            padding: 11px 18px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .reset-btn {
            padding: 11px 18px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .result-info {
            margin-top: 15px;
            color: #555;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-radius: 10px;
            overflow: hidden;
        }

        th,
        td {
            padding: 13px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        tr:hover {
            background: #e9ecef;
        }

        .phone-main {
            font-weight: bold;
            color: #222;
        }

        .phone-detail {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 15px;
            background: #e7f1ff;
            color: #0069d9;
            font-size: 12px;
            font-weight: bold;
            margin-top: 5px;
        }

        /* Phone Quick Actions */

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-btn {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            color: white;
            font-size: 12px;
            font-weight: bold;
            transition: 0.2s;
            border: none;
            cursor: pointer;
        }

        .call-btn {
            background: #28a745;
        }

        .call-btn:hover {
            background: #218838;
        }

        .whatsapp-btn {
            background: #25D366;
        }

        .whatsapp-btn:hover {
            background: #1da851;
        }

        /* Copy Phone */

        .copy-btn {
            background: #6c757d;
        }

        .copy-btn:hover {
            background: #5a6268;
        }

        /* Share Phone */

        .share-btn {
            background: #17a2b8;
        }

        .share-btn:hover {
            background: #138496;
        }

        .copy-message {
            display: none;
            margin-top: 6px;
            color: #28a745;
            font-size: 11px;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 10px;
            color: #777;
        }

        @media (max-width: 900px) {

            body {
                padding: 15px;
            }

            table {
                font-size: 12px;
            }

            th,
            td {
                padding: 8px;
            }

            .action-btn {
                padding: 7px 9px;
                font-size: 11px;
            }

        }
    </style>
</head>

<body>

<div class="container">

    <h2>📱 Phone User Management</h2>

    @if(session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif


    <div class="top-bar">

        <a href="{{ route('users.dashboard') }}"
           class="button dashboard-btn">
            📊 Dashboard
        </a>

        <a href="{{ route('users.create') }}"
           class="button create-btn">
            + Create User
        </a>

    </div>


    {{-- Search and Filter --}}

    <div class="search-card">

        <form action="{{ route('users.index') }}"
              method="GET"
              class="search-form">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                class="search-input"
                placeholder="Search name, email or phone number..."
            >

            <select name="filter" class="filter-select">

                <option value="">
                    All Users
                </option>

                <option value="today"
                    {{ request('filter') === 'today' ? 'selected' : '' }}>
                    Registered Today
                </option>

                <option value="recent"
                    {{ request('filter') === 'recent' ? 'selected' : '' }}>
                    Last 7 Days
                </option>

                <option value="month"
                    {{ request('filter') === 'month' ? 'selected' : '' }}>
                    This Month
                </option>

            </select>

            <button type="submit" class="search-btn">
                🔎 Search
            </button>

            <a href="{{ route('users.index') }}"
               class="reset-btn">
                Reset
            </a>

        </form>


        <div class="result-info">

            Showing
            <strong>{{ $users->count() }}</strong>
            user(s)

        </div>

    </div>


    @if($users->count() > 0)

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Details</th>
                    <th>Created At</th>
                    <th>Quick Actions</th>
                </tr>

            </thead>


            <tbody>

                @foreach($users as $user)

                    <tr>

                        <td>
                            {{ $user->id }}
                        </td>


                        <td>
                            <strong>
                                {{ $user->name }}
                            </strong>
                        </td>


                        <td>
                            {{ $user->email }}
                        </td>


                        {{-- Phone Details --}}

                        <td>

                            <div class="phone-main">
                                {{ $user->phone }}
                            </div>


                            <div class="phone-detail">

                                International:

                                {{ phone($user->phone, 'IN')->formatInternational() }}

                            </div>


                            <div class="phone-detail">

                                National:

                                {{ phone($user->phone, 'IN')->formatNational() }}

                            </div>


                            <span class="badge">
                                🇮🇳 India
                            </span>


                            {{-- Copy Message --}}

                            <div class="copy-message">
                                ✓ Phone number copied!
                            </div>

                        </td>


                        <td>

                            {{ $user->created_at->format('d M Y, h:i A') }}

                        </td>


                        {{-- Phone Quick Actions --}}

                        <td>

                            <div class="action-buttons">


                                {{-- Call --}}

                                <a
                                    href="tel:{{ $user->phone }}"
                                    class="action-btn call-btn"
                                    title="Call {{ $user->name }}"
                                >
                                    📞 Call
                                </a>


                                {{-- WhatsApp --}}

                                <a
                                    href="https://wa.me/{{ ltrim($user->phone, '+') }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="action-btn whatsapp-btn"
                                    title="Message {{ $user->name }} on WhatsApp"
                                >
                                    💬 WhatsApp
                                </a>


                                {{-- Copy Phone Number --}}

                                <button
                                    type="button"
                                    class="action-btn copy-btn"
                                    onclick="copyPhone('{{ $user->phone }}', this)"
                                    title="Copy phone number"
                                >
                                    📋 Copy
                                </button>


                                {{-- Share Phone Number --}}

                                <button
                                    type="button"
                                    class="action-btn share-btn"
                                    onclick="sharePhone('{{ $user->name }}', '{{ $user->phone }}')"
                                    title="Share phone number"
                                >
                                    📤 Share
                                </button>


                            </div>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>


    @else

        <div class="empty">

            <h3>
                No users found
            </h3>

            <p>
                No users match your current search or filter.
            </p>

        </div>

    @endif

</div>


{{-- Phone Copy & Share JavaScript --}}

<script>

    /*
     * Copy Phone Number
     */
    function copyPhone(phone, button) {

        if (navigator.clipboard) {

            navigator.clipboard.writeText(phone)
                .then(function () {

                    showCopyMessage(button);

                })
                .catch(function () {

                    fallbackCopy(phone, button);

                });

        } else {

            fallbackCopy(phone, button);

        }

    }


    /*
     * Fallback Copy Method
     */
    function fallbackCopy(phone, button) {

        const textArea = document.createElement('textarea');

        textArea.value = phone;

        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';

        document.body.appendChild(textArea);

        textArea.focus();
        textArea.select();

        try {

            document.execCommand('copy');

            showCopyMessage(button);

        } catch (error) {

            alert('Unable to copy the phone number.');

        }

        document.body.removeChild(textArea);

    }


    /*
     * Show Copy Confirmation
     */
    function showCopyMessage(button) {

        const row = button.closest('tr');

        const message = row.querySelector('.copy-message');

        message.style.display = 'block';

        setTimeout(function () {

            message.style.display = 'none';

        }, 2000);

    }


    /*
     * Share Phone Number
     */
    function sharePhone(name, phone) {

        if (navigator.share) {

            navigator.share({

                title: 'Phone Number',

                text: name + ' - ' + phone

            }).catch(function (error) {

                console.log('Share cancelled:', error);

            });

        } else {

            alert(
                'Phone sharing is not supported by this browser. ' +
                'Please use the Copy button instead.'
            );

        }

    }

</script>


</body>
</html>