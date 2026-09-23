<!DOCTYPE html>

<html lang="en">

<head>

   
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Edit User</title>

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

        .card {
            background: white;
            max-width: 500px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.10);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 11px;
            margin-bottom: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        input:focus {
            border-color: #007bff;
            outline: none;
        }

        .error-border {
            border-color: red !important;
        }

        .field-error {
            color: red;
            font-size: 13px;
            margin-bottom: 12px;
        }

        .help {
            color: #777;
            font-size: 12px;
            margin-bottom: 15px;
        }

        .update-btn {
            width: 100%;
            padding: 12px;
            border: none;
            background: #007bff;
            color: white;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        .update-btn:hover {
            background: #0069d9;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: #333;
            text-decoration: none;
        }

        .current-phone {
            background: #f1f8ff;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 18px;
        }
    </style>


</head>

<body>

    <div class="card">

       
        <h2>
            ✏️ Edit User
        </h2>


        <div class="current-phone">

            Current Phone:

            <strong>
                {{ $user->phone }}
            </strong>

        </div>


        <form
            action="{{ route('users.update', $user) }}"
            method="POST">

            @csrf

            @method('PUT')


            <label>
                Name
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name', $user->name) }}"
                class="@error('name') error-border @enderror"
                placeholder="Enter name">

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
                value="{{ old('email', $user->email) }}"
                class="@error('email') error-border @enderror"
                placeholder="Enter email">

            @error('email')

            <div class="field-error">
                {{ $message }}
            </div>

            @enderror


            @php
                try {
                    $detectedCountry = phone($user->phone)->getCountry() ?? 'IN';
                } catch (\Throwable $e) {
                    $detectedCountry = 'IN';
                }
            @endphp

            <label>
                Country & Phone Number
            </label>

            <div style="display: flex; gap: 10px; margin-bottom: 6px;">
                <select name="country_code" style="padding: 10px; border: 1px solid #ccc; border-radius: 6px; width: 150px; background: white; font-weight: bold;">
                    <option value="IN" {{ old('country_code', $detectedCountry) === 'IN' ? 'selected' : '' }}>🇮🇳 +91 (IN)</option>
                    <option value="US" {{ old('country_code', $detectedCountry) === 'US' ? 'selected' : '' }}>🇺🇸 +1 (US)</option>
                    <option value="GB" {{ old('country_code', $detectedCountry) === 'GB' ? 'selected' : '' }}>🇬🇧 +44 (UK)</option>
                    <option value="AE" {{ old('country_code', $detectedCountry) === 'AE' ? 'selected' : '' }}>🇦🇪 +971 (UAE)</option>
                    <option value="CA" {{ old('country_code', $detectedCountry) === 'CA' ? 'selected' : '' }}>🇨🇦 +1 (CA)</option>
                    <option value="AU" {{ old('country_code', $detectedCountry) === 'AU' ? 'selected' : '' }}>🇦🇺 +61 (AU)</option>
                    <option value="DE" {{ old('country_code', $detectedCountry) === 'DE' ? 'selected' : '' }}>🇩🇪 +49 (DE)</option>
                    <option value="FR" {{ old('country_code', $detectedCountry) === 'FR' ? 'selected' : '' }}>🇫🇷 +33 (FR)</option>
                    <option value="JP" {{ old('country_code', $detectedCountry) === 'JP' ? 'selected' : '' }}>🇯🇵 +81 (JP)</option>
                    <option value="SG" {{ old('country_code', $detectedCountry) === 'SG' ? 'selected' : '' }}>🇸🇬 +65 (SG)</option>
                </select>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone', $user->phone) }}"
                    class="@error('phone') error-border @enderror"
                    placeholder="9876543210"
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
                New Password
            </label>

            <input
                type="password"
                name="password"
                class="@error('password') error-border @enderror"
                placeholder="Leave blank to keep current password">

            @error('password')

            <div class="field-error">
                {{ $message }}
            </div>

            @enderror


            <button
                type="submit"
                class="update-btn">

                💾 Update User

            </button>

        </form>


        <a
            href="{{ route('users.index') }}"
            class="back-link">

            ← Back to Users

        </a>
        

    </div>

</body>

</html>