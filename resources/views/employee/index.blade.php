<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    <title>Employee Table</title>
</head>
<body>
    <div class="header">
        <div class="top-header">
            <div class="left-content">
            </div>
            <div class="center-content">
                <p>Welcome, {{ Auth::user()->email }}</p>
            </div>
            <div class="right-content">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif 
        </div>

        <div class="bottom-header">
            <h2>Manage Employees</h2>
        </div>
    </div>

    <div class="actions">
        <div class="left-button">
            <a href="{{route('employee.create')}}">
                <button>+ Add New</button>
            </a>
        </div>
        <div class="right-button">
            <a href="{{route("employee.download")}}">
                <button><i class="fa fa-file-excel-o"></i> Modify using Excel</button>
            </a>
        </div>
    </div>

    <div>
        <table class="crud" border="1">
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>E-Mail</th>
                <th>Phone</th>
                <th>Created At</th>
                <th>Updated On</th>
                <th>Actions</th>
            </tr>
            @foreach($employees as $employee)
            <tr>
                <td>{{$employee->id}}</td>
                <td>{{$employee->fullname}}</td>
                <td>{{$employee->email}}</td>
                <td>{{$employee->phone}}</td>
                <td>{{$employee->created_at}}</td>
                <td>{{$employee->updated_at}}</td>
                <td>
                    <form method="GET" action="{{ route('employee.edit', ['employee' => $employee]) }}">
                        @csrf
                        @method("GET")
                        <button type="submit">Edit</button>
                    </form>
                    <form method="POST" action ="{{route('employee.destroy', ['employee'=>$employee])}}">
                        @csrf
                        @method("DELETE")
                        <button type="submit">Delete</button>
                    </form>
                    
                </td>
            </tr>
            @endforeach
        </table>
    </div>

</body>
</html>
