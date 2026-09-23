<!DOCTYPE html>

<html lang="en">

<head>

  
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

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
            max-width: 1400px;
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
            border: none;
            cursor: pointer;
        }

        .dashboard-btn {
            background: #6f42c1;
        }

        .create-btn {
            background: #007bff;
        }

        .export-btn {
            background: #198754;
        }

        .bulk-delete-btn {
            background: #dc3545;
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

        .error-box {
            background: #ffe6e6;
            color: #b00020;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #ffb3b3;
        }

        .search-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .search-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .search-input,
        .filter-select,
        .date-input {
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .search-input {
            flex: 1;
            min-width: 250px;
        }

        .filter-select {
            min-width: 180px;
        }

        .date-input {
            min-width: 160px;
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

        .filter-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 15px;
            align-items: center;
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
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
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

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .action-btn {
            display: inline-block;
            padding: 7px 10px;
            border-radius: 6px;
            text-decoration: none;
            color: white;
            font-size: 12px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .view-btn {
            background: #6f42c1;
        }

        .edit-btn {
            background: #fd7e14;
        }

        .delete-btn {
            background: #dc3545;
        }

        .call-btn {
            background: #28a745;
        }

        .whatsapp-btn {
            background: #25D366;
        }

        .copy-btn {
            background: #6c757d;
        }

        .share-btn {
            background: #17a2b8;
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

        .checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .bulk-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .sort-link {
            color: white;
            text-decoration: none;
        }

        .pagination-wrapper {
            margin-top: 25px;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            gap: 6px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            display: inline-block;
        }

        .pagination a,
        .pagination span {
            display: block;
            min-width: 38px;
            text-align: center;
            padding: 9px 12px;
            border-radius: 6px;
            text-decoration: none;
            border: 1px solid #ddd;
            background: white;
            color: #333;
        }

        .pagination .active span {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        .pagination .disabled span {
            color: #aaa;
            background: #f5f5f5;
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
                padding: 6px 8px;
                font-size: 11px;
            }

        }
    </style>


</head>

<body>

    <div class="container">

     
        <h2>📱 Phone User Management</h2>


        {{-- Success Message --}}

        @if(session('success'))

        <div class="success">

            {{ session('success') }}

        </div>

        @endif


        {{-- Validation Errors --}}

        @if($errors->any())

        <div class="error-box">

            <strong>Please fix the following:</strong>

            <ul>

                @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

        @endif


        {{-- Top Buttons --}}

        <div class="top-bar">

            <div>

                <a
                    href="{{ route('users.dashboard') }}"
                    class="button dashboard-btn">

                    📊 Dashboard

                </a>

                <a
                    href="{{ route('users.create') }}"
                    class="button create-btn">

                    + Create User

                </a>

            </div>


            <a
                href="{{ route('users.export', request()->query()) }}"
                class="button export-btn">

                📥 Export CSV

            </a>

        </div>


        {{-- Search / Filters --}}

        <div class="search-card">

            <form
                action="{{ route('users.index') }}"
                method="GET">


                <div class="search-form">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="search-input"
                        placeholder="Search name, email or phone number...">


                    <select
                        name="filter"
                        class="filter-select">

                        <option value="">
                            All Users
                        </option>

                        <option
                            value="today"
                            {{ request('filter') === 'today' ? 'selected' : '' }}>

                            Registered Today

                        </option>

                        <option
                            value="recent"
                            {{ request('filter') === 'recent' ? 'selected' : '' }}>

                            Last 7 Days

                        </option>

                        <option
                            value="month"
                            {{ request('filter') === 'month' ? 'selected' : '' }}>

                            This Month

                        </option>

                    </select>


                    <button
                        type="submit"
                        class="search-btn">

                        🔎 Search

                    </button>


                    <a
                        href="{{ route('users.index') }}"
                        class="reset-btn">

                        Reset

                    </a>

                </div>


                {{-- Date Range --}}

                <div class="filter-row">

                    <strong>
                        Date Range:
                    </strong>

                    <input
                        type="date"
                        name="start_date"
                        value="{{ request('start_date') }}"
                        class="date-input">


                    <span>
                        to
                    </span>


                    <input
                        type="date"
                        name="end_date"
                        value="{{ request('end_date') }}"
                        class="date-input">

                </div>

            </form>


            <div class="result-info">

                Showing

                <strong>
                    {{ $users->firstItem() ?? 0 }}
                </strong>

                to

                <strong>
                    {{ $users->lastItem() ?? 0 }}
                </strong>

                of

                <strong>
                    {{ $users->total() }}
                </strong>

                user(s)

            </div>

        </div>


        {{-- Bulk Delete Form --}}

        <form
            id="bulkDeleteForm"
            action="{{ route('users.bulk-delete') }}"
            method="POST">

            @csrf

            @method('DELETE')


            <div class="bulk-bar">

                <button
                    type="submit"
                    class="button bulk-delete-btn"
                    onclick="return confirmBulkDelete()">

                    🗑️ Delete Selected

                </button>

                <span id="selectedCount">
                    0 selected
                </span>

            </div>


            @if($users->count() > 0)

            <table>

                <thead>

                    <tr>

                        <th>

                            <input
                                type="checkbox"
                                id="selectAll"
                                class="checkbox">

                        </th>

                        <th>
                            ID
                        </th>

                        <th>
                            Name
                        </th>

                        <th>
                            Email
                        </th>

                        <th>
                            Phone Details
                        </th>

                        <th>
                            Created At
                        </th>

                        <th>
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($users as $user)

                    <tr>

                        <td>

                            <input
                                type="checkbox"
                                name="user_ids[]"
                                value="{{ $user->id }}"
                                class="user-checkbox checkbox">

                        </td>


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


                        <td>

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
                                try {
                                    $intl = phone($user->phone)->formatInternational();
                                    $nat = phone($user->phone)->formatNational();
                                } catch (\Throwable $e) {
                                    $intl = $user->phone;
                                    $nat = $user->phone;
                                }
                            @endphp

                            <div class="phone-main">
                                {{ $user->phone }}
                            </div>

                            <div class="phone-detail">

                                International:

                                {{ $intl }}

                            </div>

                            <div class="phone-detail">

                                National:

                                {{ $nat }}

                            </div>

                            <span class="badge">
                                {{ $cBadge }}
                            </span>

                            <div class="copy-message">
                                ✓ Phone number copied!
                            </div>

                        </td>


                        <td>

                            {{ $user->created_at->format('d M Y, h:i A') }}

                        </td>


                        <td>

                            <div class="action-buttons">

                                {{-- View --}}

                                <a
                                    href="{{ route('users.show', $user) }}"
                                    class="action-btn view-btn">

                                    👁️ View

                                </a>


                                {{-- Edit --}}

                                <a
                                    href="{{ route('users.edit', $user) }}"
                                    class="action-btn edit-btn">

                                    ✏️ Edit

                                </a>


                                {{-- Delete --}}

                                <form
                                    action="{{ route('users.destroy', $user) }}"
                                    method="POST"
                                    style="display:inline;">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="action-btn delete-btn"
                                        onclick="return confirm('Are you sure you want to delete {{ addslashes($user->name) }}?')">

                                        🗑️ Delete

                                    </button>

                                </form>


                                {{-- Call --}}

                                <a
                                    href="tel:{{ $user->phone }}"
                                    class="action-btn call-btn">

                                    📞 Call

                                </a>


                                {{-- WhatsApp --}}

                                <a
                                    href="https://wa.me/{{ ltrim($user->phone, '+') }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="action-btn whatsapp-btn">

                                    💬 WhatsApp

                                </a>


                                {{-- Send OTP --}}

                                <form
                                    action="{{ route('users.send-otp', $user) }}"
                                    method="POST"
                                    style="display:inline;">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="action-btn"
                                        style="background: #17a2b8;">

                                        📲 Send OTP

                                    </button>

                                </form>


                                {{-- Copy --}}

                                <button
                                    type="button"
                                    class="action-btn copy-btn"
                                    onclick="copyPhone('{{ $user->phone }}', this)">

                                    📋 Copy

                                </button>


                                {{-- Share --}}

                                <button
                                    type="button"
                                    class="action-btn share-btn"
                                    onclick="sharePhone('{{ addslashes($user->name) }}', '{{ $user->phone }}')">

                                    📤 Share

                                </button>

                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>


            {{-- Number Only Pagination --}}

            <div class="pagination-wrapper">

                @if($users->hasPages())

                <ul class="pagination">

                    {{-- Previous number only --}}

                    @if($users->onFirstPage())

                    <li class="disabled">
                        <span>‹</span>
                    </li>

                    @else

                    <li>

                        <a href="{{ $users->previousPageUrl() }}">
                            ‹
                        </a>

                    </li>

                    @endif


                    @foreach($users->getUrlRange(
                    max(1, $users->currentPage() - 2),
                    min($users->lastPage(), $users->currentPage() + 2)
                    ) as $page => $url)

                    @if($page == $users->currentPage())

                    <li class="active">
                        <span>
                            {{ $page }}
                        </span>
                    </li>

                    @else

                    <li>

                        <a href="{{ $url }}">
                            {{ $page }}
                        </a>

                    </li>

                    @endif

                    @endforeach


                    {{-- Next --}}

                    @if($users->hasMorePages())

                    <li>

                        <a href="{{ $users->nextPageUrl() }}">
                            ›
                        </a>

                    </li>

                    @else

                    <li class="disabled">
                        <span>›</span>
                    </li>

                    @endif

                </ul>

                @endif

            </div>


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

        </form>
       

    </div>

    <script>
        /*
    |--------------------------------------------------------------------------
    | Select All
    |--------------------------------------------------------------------------
    */

        const selectAll =
            document.getElementById('selectAll');

        const userCheckboxes =
            document.querySelectorAll('.user-checkbox');

        const selectedCount =
            document.getElementById('selectedCount');


        if (selectAll) {

            selectAll.addEventListener(
                'change',
                function() {

                    userCheckboxes.forEach(
                        function(checkbox) {

                            checkbox.checked =
                                selectAll.checked;

                        }
                    );

                    updateSelectedCount();

                }
            );

        }


        userCheckboxes.forEach(
            function(checkbox) {

                checkbox.addEventListener(
                    'change',
                    updateSelectedCount
                );

            }
        );


        function updateSelectedCount() {
            const checked =
                document.querySelectorAll(
                    '.user-checkbox:checked'
                ).length;

            selectedCount.textContent =
                checked + ' selected';
        }


        /*
        |--------------------------------------------------------------------------
        | Bulk Delete Confirmation
        |--------------------------------------------------------------------------
        */

        function confirmBulkDelete() {
            const checked =
                document.querySelectorAll(
                    '.user-checkbox:checked'
                ).length;

            if (checked === 0) {

                alert(
                    'Please select at least one user.'
                );

                return false;
            }

            return confirm(
                'Are you sure you want to delete ' +
                checked +
                ' selected user(s)?'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Copy Phone
        |--------------------------------------------------------------------------
        */

        function copyPhone(phone, button) {
            if (navigator.clipboard) {

                navigator.clipboard.writeText(phone)
                    .then(function() {

                        showCopyMessage(button);

                    })
                    .catch(function() {

                        fallbackCopy(
                            phone,
                            button
                        );

                    });

            } else {

                fallbackCopy(
                    phone,
                    button
                );

            }
        }


        function fallbackCopy(phone, button) {
            const textArea =
                document.createElement('textarea');

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

                alert(
                    'Unable to copy phone number.'
                );

            }

            document.body.removeChild(textArea);
        }


        function showCopyMessage(button) {
            const row =
                button.closest('tr');

            const message =
                row.querySelector(
                    '.copy-message'
                );

            message.style.display =
                'block';

            setTimeout(function() {

                message.style.display =
                    'none';

            }, 2000);
        }


        /*
        |--------------------------------------------------------------------------
        | Share Phone
        |--------------------------------------------------------------------------
        */

        function sharePhone(name, phone) {
            if (navigator.share) {

                navigator.share({

                    title: 'Phone Number',

                    text: name +
                        ' - ' +
                        phone

                }).catch(function() {

                    console.log(
                        'Share cancelled'
                    );

                });

            } else {

                alert(
                    'Phone sharing is not supported by this browser. ' +
                    'Please use Copy instead.'
                );

            }
        }
    </script>

</body>

</html>