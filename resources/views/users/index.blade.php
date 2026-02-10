<!DOCTYPE html>
<html>
<head>
    <title>User List</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 40px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .success {
            background: #e6ffed;
            padding: 10px;
            border-radius: 6px;
            color: green;
            margin-bottom: 20px;
            text-align: center;
        }

        .create-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 8px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .create-btn:hover {
            background: #0069d9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        tr:hover {
            background: #e9ecef;
        }
    </style>
</head>
<body>

<h2>User List</h2>

@if(session('success'))
    <div class="success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('users.create') }}" class="create-btn">+ Create User</a>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone (E.164)</th>
        <th>Created At</th>
    </tr>

    @foreach($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->phone }}</td>
        <td>{{ $user->created_at }}</td>
    </tr>
    @endforeach

</table>

</body>
</html>
