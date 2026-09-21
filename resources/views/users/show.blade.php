<!DOCTYPE html>

<html lang="en">

<head>


    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>User Details</title>

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
            max-width: 700px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.10);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        .value {
            text-align: right;
            color: #222;
        }

        .phone {
            font-size: 18px;
            font-weight: bold;
        }

        .badge {
            display: inline-block;
            margin-top: 8px;
            background: #e7f1ff;
            color: #0069d9;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        .button {
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .back {
            background: #6c757d;
        }

        .edit {
            background: #fd7e14;
        }

        .call {
            background: #28a745;
        }

        .whatsapp {
            background: #25D366;
        }

        @media(max-width:600px) {

            body {
                padding: 15px;
            }

            .row {
                flex-direction: column;
            }

            .value {
                text-align: left;
            }

        }
    </style>

</head>

<body>

    <div class="container">


        <div class="card">

            <h2>
                👤 User Details
            </h2>


            <div class="row">

                <div class="label">
                    ID
                </div>

                <div class="value">
                    {{ $user->id }}
                </div>

            </div>


            <div class="row">

                <div class="label">
                    Name
                </div>

                <div class="value">
                    {{ $user->name }}
                </div>

            </div>


            <div class="row">

                <div class="label">
                    Email
                </div>

                <div class="value">
                    {{ $user->email }}
                </div>

            </div>


            <div class="row">

                <div class="label">
                    Phone
                </div>

                <div class="value">

                    <div class="phone">
                        {{ $user->phone }}
                    </div>

                    <div>
                        International:

                        {{ phone($user->phone, 'IN')->formatInternational() }}
                    </div>

                    <div>
                        National:

                        {{ phone($user->phone, 'IN')->formatNational() }}
                    </div>

                    <span class="badge">
                        🇮🇳 India
                    </span>

                </div>

            </div>


            <div class="row">

                <div class="label">
                    Registered
                </div>

                <div class="value">

                    {{ $user->created_at->format('d M Y, h:i A') }}

                </div>

            </div>


            <div class="row">

                <div class="label">
                    Last Updated
                </div>

                <div class="value">

                    {{ $user->updated_at->format('d M Y, h:i A') }}

                </div>

            </div>


            <div class="actions">

                <a
                    href="{{ route('users.index') }}"
                    class="button back">

                    ← Back

                </a>


                <a
                    href="{{ route('users.edit', $user) }}"
                    class="button edit">

                    ✏️ Edit

                </a>


                <a
                    href="tel:{{ $user->phone }}"
                    class="button call">

                    📞 Call

                </a>


                <a
                    href="https://wa.me/{{ ltrim($user->phone, '+') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="button whatsapp">

                    💬 WhatsApp

                </a>

            </div>

        </div>


    </div>

</body>

</html>