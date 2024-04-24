<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Profile</h1>
        <form method="POST" action="{{ route('edit.profile.post')}}">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" value=" {{$loggedin->name}}">
            </div>
          
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="{{$loggedin->email}}">
            </div>
            <div class="form-group">
              <label for="address">Address:</label>
              <input type="address" name="address" id="address" class="form-control" value="{{$loggedin->address}}">
            </div>
            <div class="form-group">
              <label for="Phone_number">Phone Number</label>
              <input type="tel" name="phone_number" id="phone_number" class="form-control" maxlength="10"value="{{$loggedin->phone_number}}" >
              
            </div>
            
            <br>
            <button type="submit" class="btn btn-primary">Edit Profile</button>
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Back</a>

        </form>
    </div>
</body>
</html>
