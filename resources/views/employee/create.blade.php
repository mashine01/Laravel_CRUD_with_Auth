<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/create.css">
    <title>Add new employee</title>
</head>
<body>
    <h2>Register a new employee</h2>
    @if($errors->any())
    <div class="error">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form class="form-container" method="POST" action="{{ route('employee.store') }}">
        @csrf
        @method("POST")
        <div class="form-group">
            <label class="form-label">Full Name</label><br>
            <input class="form-input" type="text" name="fullname">
            {{-- @error('fullname')
            <div class="error">{{ $message }}</div>
            @enderror --}}
        </div>
        <div class="form-group">
            <label class="form-label">E-Mail</label><br>
            <input class="form-input" type="text" name="email">
        </div>
        <div class="form-group">
            <label class="form-label">Phone Number</label><br>
            <input class="form-input" type="text" name="phone">
        </div>
        <input class="form-submit" type="submit" value="Add">
    </form>
</body>
</html>
