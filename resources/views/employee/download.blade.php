<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Excel Operations</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
        }

        input[type="file"] {
            padding: 10px;
            margin-bottom: 15px;
        }

        a {
            text-decoration: none;
            color: #333;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form method="GET" action="{{ route('excel.downloadData') }}">
        @csrf
        <a href="/excel.xlsx" download><button type="submit">Download Excel</button></a>
    </form>

    <form method="GET" action="{{ route('excel.download') }}">
        @csrf
        <a href="/excel.xlsx" download><button type="submit">Download Excel without Data</button></a>
    </form>

    <form method="POST" action="{{ route('excel.upload') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" id="myfile" name="myfile">
        <button type="submit">Import Data</button>
    </form>
</body>
</html>