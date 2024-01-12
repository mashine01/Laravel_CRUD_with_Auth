<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/edit.css">
    <title>Document</title>
</head>
<body>
    <h2>Update employee</h2>
    @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    <form class="form-container" method="POST" action ="{{route('employee.update', ['employee'=>$employee])}}">
        @csrf
        @method("PUT") 
        <div class="form-group">
            <label class="form-label">Full Name</label><br>
            <input class="form-input" type="text" name="fullname" value={{$employee->fullname}}>
        </div>
        <div class="form-group">
            <label class="form-label">E-Mail</label><br>
            <input class="form-input" type="text" name="email" value={{$employee->email}}>
        </div>
        <div class="form-group">
            <label class="form-label">Phone Number</label><br>
            <input class="form-input" type="text" name="phone" value={{$employee->phone}}>
        </div>
        <input class="form-submit" type="submit" value="Update">
    </form>
</body>
</html>
