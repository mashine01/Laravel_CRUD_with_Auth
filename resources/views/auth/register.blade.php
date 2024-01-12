<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/css/register.css">
</head>
<body>
    <div class="registration-container">
        <form method="POST" action="{{ route('register') }}" class="registration-form">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">{{ __('Name') }}</label>
                <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                <div class="error-message">{{ $errors->first('name') }}</div>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">{{ __('Email') }}</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                <div class="error-message">{{ $errors->first('email') }}</div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">{{ __('Password')</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" />
                <div class="error-message">{{ $errors->first('password') }}</div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" />
                <div class="error-message">{{ $errors->first('password_confirmation') }}</div>
            </div>

            <a class="login-link" href="{{ route('login') }}">Already registered?</a><br>
            <button class="submit-button" type="submit">Register</button>
        </form>
    </div>
</body>
</html>

