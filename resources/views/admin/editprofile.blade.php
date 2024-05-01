<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Custom styles for the toggle switch */
        .toggle-switch input[type="checkbox"] {
            display: none;
        }

        .toggle-switch label {
            cursor: pointer;
            text-indent: -9999px;
            width: 50px;
            height: 25px;
            background: #ccc;
            display: block;
            border-radius: 25px;
            position: relative;
        }

        .toggle-switch label:after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 21px;
            height: 21px;
            background: #fff;
            border-radius: 21px;
            transition: 0.3s;
        }

        .toggle-switch input[type="checkbox"]:checked + label {
            background: #66bb6a;
        }

        .toggle-switch input[type="checkbox"]:checked + label:after {
            left: calc(100% - 2px);
            transform: translateX(-100%);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Profile</h1>
        <form method="POST" action="{{ route('edit.profile.user')}}">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" value=" {{$user->name}}" >
            </div>
          
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="{{$user->email}}">
            </div>
            <div class="form-group">
              <label for="address">Address:</label>
              <input type="text" name="address" id="address" class="form-control"  value="{{$user->address}}">
            </div>
            <div class="form-group">
              <label for="Phone_number">Phone Number</label>
              <input type="tel" name="phone_number" id="phone_number" class="form-control" maxlength="10" value="{{$user->phone_number}}">
            </div><br>
            <div class="toggle-switch">
                <input type="checkbox" id="toggle-address" name="toggle-address">
                <label for="toggle-address">Toggle</label>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Edit Profile</button>
            <a href="{{ route('admin-dashboard') }}" class="btn btn-primary">Back</a>
        </form>
    </div>

    <script>
        
        document.getElementById('toggle-address').addEventListener('change', function() {
            var addressInput = document.getElementById('address');
            addressInput.disabled = !this.checked;
            if (this.checked) {
                addressInput.focus();
            }
        });
    </script>
</body>
</html>
