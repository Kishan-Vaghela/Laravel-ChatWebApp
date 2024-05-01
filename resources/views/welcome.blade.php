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
            
            background-size: cover;
            color: #fff;
            font-family: 'Arial', sans-serif;
            padding: 20px;
        }

        .container {
            align-content: center
            max-width: 800px;
            margin: 10% auto;
            text-align:center;
            padding: 40px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
        }

        h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .btn {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1.2em;
            border: 2px solid #fff;
            background-color: transparent;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn:hover {
            background-color: #fff;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome to Home Page</h1>
        <div class="row">
            <div class="col">
                <h2>Login Access</h2> 
                <a href="{{ route('login') }}" class="btn btn-primary">LOGIN NOW</a>
            </div>
        </div>
    </div>
</body>

</html>
