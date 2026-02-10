<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background: #ffffff;
            padding: 30px;
            width: 350px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
        }

        input:focus {
            border-color: #4CAF50;
        }

        .error-border {
            border: 1px solid red !important;
        }

        .field-error {
            color: red;
            font-size: 13px;
            margin-bottom: 10px;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background: #4CAF50;
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: #45a049;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #333;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="card">

    <h2>Create User</h2>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        {{-- Name --}}
        <input type="text"
               name="name"
               value="{{ old('name') }}"
               placeholder="Name"
               class="@error('name') error-border @enderror">

        @error('name')
            <div class="field-error">{{ $message }}</div>
        @enderror


        {{-- Email --}}
        <input type="email"
               name="email"
               value="{{ old('email') }}"
               placeholder="Email"
               class="@error('email') error-border @enderror">

        @error('email')
            <div class="field-error">{{ $message }}</div>
        @enderror


        {{-- Phone --}}
        <input type="text"
               name="phone"
               value="{{ old('phone') }}"
               placeholder="Phone (9876543210)"
               class="@error('phone') error-border @enderror">

        @error('phone')
            <div class="field-error">{{ $message }}</div>
        @enderror


        {{-- Password --}}
        <input type="password"
               name="password"
               placeholder="Password"
               class="@error('password') error-border @enderror">

        @error('password')
            <div class="field-error">{{ $message }}</div>
        @enderror


        <button type="submit">Submit</button>
    </form>

    <a href="{{ route('users.index') }}" class="back-link">← Back to List</a>

</div>

</body>
</html>
