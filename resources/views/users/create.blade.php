<!DOCTYPE html>

<html lang="en">

<head>

  
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Create User</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .card {
            background: #ffffff;
            padding: 30px;
            width: 400px;
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 6px;
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

        .help {
            color: #777;
            font-size: 12px;
            margin-bottom: 12px;
        }

        button {
            width: 100%;
            padding: 11px;
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
    </style>
 

</head>

<body>

    <div class="card">

        <h2>
            📱 Create User
        </h2>


        <form
            action="{{ route('users.store') }}"
            method="POST">

            @csrf


            <label>
                Name
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Name"
                class="@error('name') error-border @enderror">

            @error('name')

            <div class="field-error">
                {{ $message }}
            </div>

            @enderror


            <label>
                Email
            </label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Email"
                class="@error('email') error-border @enderror">

            @error('email')

            <div class="field-error">
                {{ $message }}
            </div>

            @enderror


            <label>
                Country & Phone Number
            </label>

            <div style="display: flex; gap: 10px; margin-bottom: 6px;">
                <select name="country_code" style="padding: 10px; border: 1px solid #ccc; border-radius: 6px; width: 150px; background: white; font-weight: bold;">
                    <option value="IN" {{ old('country_code', 'IN') === 'IN' ? 'selected' : '' }}>🇮🇳 +91 (IN)</option>
                    <option value="US" {{ old('country_code') === 'US' ? 'selected' : '' }}>🇺🇸 +1 (US)</option>
                    <option value="GB" {{ old('country_code') === 'GB' ? 'selected' : '' }}>🇬🇧 +44 (UK)</option>
                    <option value="AE" {{ old('country_code') === 'AE' ? 'selected' : '' }}>🇦🇪 +971 (UAE)</option>
                    <option value="CA" {{ old('country_code') === 'CA' ? 'selected' : '' }}>🇨🇦 +1 (CA)</option>
                    <option value="AU" {{ old('country_code') === 'AU' ? 'selected' : '' }}>🇦🇺 +61 (AU)</option>
                    <option value="DE" {{ old('country_code') === 'DE' ? 'selected' : '' }}>🇩🇪 +49 (DE)</option>
                    <option value="FR" {{ old('country_code') === 'FR' ? 'selected' : '' }}>🇫🇷 +33 (FR)</option>
                    <option value="JP" {{ old('country_code') === 'JP' ? 'selected' : '' }}>🇯🇵 +81 (JP)</option>
                    <option value="SG" {{ old('country_code') === 'SG' ? 'selected' : '' }}>🇸🇬 +65 (SG)</option>
                </select>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="9876543210"
                    class="@error('phone') error-border @enderror"
                    style="flex: 1; margin-bottom: 0;">
            </div>

            <div class="help">
                Select your country and enter a valid phone number.
            </div>

            @error('phone')

            <div class="field-error">
                {{ $message }}
            </div>

            @enderror


            <label>
                Password
            </label>

            <input
                type="password"
                name="password"
                placeholder="Password"
                class="@error('password') error-border @enderror">

            @error('password')

            <div class="field-error">
                {{ $message }}
            </div>

            @enderror


            <button type="submit">

                + Create User

            </button>

        </form>


        <a
            href="{{ route('users.index') }}"
            class="back-link">

            ← Back to List

        </a>
   

    </div>

</body>

</html>