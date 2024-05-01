<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        .btn {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome to the Home Page</h1>
        <div class="row">
            <div class="col">
                <h2>LOGIN</h2>
                {{-- <button class="btn btn-primary">Admin Login</button> --}}
                <a href="{{ route('login') }}">LOGIN</a>
            </div>
           
        </div>
    </div>
</body>

</html>
