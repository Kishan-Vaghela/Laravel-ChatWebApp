<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Friend List</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .table .btn-request-sent {
            background-color: red;
            border-color: red;
            color: #fff;
        }
    </style>
</head>

<body>
    @include('header.navbar')

    <div class="container">
        <div class="header-container">
            <h1 class="display-4 mt-5">Friend List</h1>
            <div class="form-group col-md-4">
                <input id="searchInput" class="form-control me-2" type="search" name="search" placeholder="Search"
                    aria-label="Search">
                <button id="searchBtn" class="btn btn-outline-success" type="button">Search</button>
                
            </div>
        </div>
        <div class="table-responsive">
            <table class="table mt-4 table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Sr. No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Friend Request</th>
                    </tr>
                </thead>
                <tbody id="searchResults">
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($exitisingfriends as $friend)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $friend->name }}</td>
                            <td>{{ $friend->email }}</td>
                            <td>

                                @if ($friend->sentFriendRequests->isEmpty())
                                    <input type="hidden" name="receiver_email" value="{{ $friend->email }}">
                                    <button type="button" class="btn btn-success"
                                        onclick="sendFriendRequest('{{ $friend->email }}', this)">Send Request</button>
                                @else
                                    <button type="button" class="btn btn-danger">Request Sent</button>
                                @endif

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $("#searchBtn").click(function() {
            search(); 
        });
    });

    function sendFriendRequest(email, button) {
        const csrfToken = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            url: "/friendrequest",
            method: "POST",
            data: {
                receiver_email: email
            },
            success: function(response) {
                console.log(response);

                $(button).text('Request Sent').prop('disabled', true).addClass('btn-request-sent');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function search() {
        const searchValue = $('#searchInput').val();
        const csrfToken = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            url: '/search',
            method: "POST",
            data: {
                search: searchValue
            },
            success: function(data) {
                $('#searchResults').empty(); 
             
                data.forEach(function(friend) {
                    let buttonHtml = '';
                    if (friend.requestSent) {
                        buttonHtml = '<button type="button" class="btn btn-danger">Request Sent</button>';
                    } else {
                        buttonHtml = '<button type="button" class="btn btn-success" onclick="sendFriendRequest(\'' + friend.email + '\', this)">Send Request</button>';
                    }
                    $('#searchResults').append(
                        '<tr>' +
                        '<td>' + friend.id + '</td>' +
                        '<td>' + friend.name + '</td>' +
                        '<td>' + friend.email + '</td>' +
                        '<td>' + buttonHtml + '</td>' +
                        '</tr>'
                    );
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>

    
</body>

</html>
