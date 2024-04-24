<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">  <div class="card shadow-sm">  <div class="card-header">
                <h1 class="card-title text-center">Forget Password</h1>
            </div>
            <div class="card-body">
                @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('forgot.password.post') }}">
                    @csrf
                    <div class="form-group mb-3">  <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address">
                    </div>
                    <button type="submit" class="btn btn-primary d-block mx-auto">Submit</button>  </form>
            </div>
        </div>
    </div>
</body>
</html>
