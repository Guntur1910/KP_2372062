<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kain Tenun Sumba</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sage: #7A8C6E;
            --sage-dark: #5C6E52;
            --cream: #F5F0E8;
            --cream-dark: #EDE6D6;
            --text-dark: #2C2C2C;
            --text-muted: #6B6B6B;
            --white: #FFFFFF;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Lato', sans-serif;
            background: var(--cream-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: var(--cream);
            border-radius: 12px;
            overflow: hidden;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
        }

        .card-header {
            background: var(--sage);
            padding: 20px 32px;
            text-align: center;
        }

        .card-header h5 {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 600;
            color: var(--white);
            letter-spacing: 0.3px;
        }

        .card-body {
            padding: 32px;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 400;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: none;
            border-radius: 10px;
            background: var(--cream-dark);
            font-size: 14px;
            font-family: 'Lato', sans-serif;
            color: var(--text-dark);
            outline: none;
            transition: box-shadow 0.2s;
        }

        .form-group input:focus {
            box-shadow: 0 0 0 2px var(--sage-dark);
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: var(--sage);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-family: 'Lato', sans-serif;
            font-weight: 400;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 4px;
        }

        .btn-submit:hover { background: var(--sage-dark); }

        .divider {
            border: none;
            border-top: 1px solid var(--cream-dark);
            margin: 24px 0 20px;
        }

        .card-footer-text {
            text-align: center;
            font-size: 14px;
            color: var(--text-dark);
        }

        .card-footer-text a {
            color: var(--sage-dark);
            text-decoration: none;
            font-weight: 700;
        }

        .card-footer-text a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h5>Login</h5>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert-danger">{{ $errors->first() }}</div>
            @endif
            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Username / Email</label>
                    <input type="text" name="login" value="{{ old('login') }}" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn-submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>