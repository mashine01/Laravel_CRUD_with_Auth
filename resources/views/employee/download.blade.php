<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Excel Operations</title>
    <link rel="stylesheet" href="/css/excel.css">
</head>
<body>
    <a href="{{ route('employee.index') }}" class="back-button">Back</a>
    <div class="buttons-container">
        <form method="GET" action="{{ route('excel.download') }}">
            @csrf
            <h3>Download File</h3>
            <div class="radio-label">
                <input type="radio" name="downloadType" value="withData">With Data
            </div>
            <div class="radio-label">
                <input type="radio" name="downloadType" value="withoutData">Without Data
            </div>
            <button type="submit">Export Data</button>
        </form>
        <form method="POST" action="{{ route('excel.upload') }}" enctype="multipart/form-data">
            @csrf
            <h3>Upload File</h3>
            <input type="file" id="myfile" name="myfile"><br>
            <button type="submit">Import Data</button>
        </form>
        @error('myfile')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</body>
</html>
