<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Accepted Friend Requests</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @include('header.navbar')
    <div class="container">
        <h1 class="mt-5 mb-4">Accepted Friend Requests</h1>

        @if ($acceptedFriendRequest->isEmpty())
            <p>No accepted friend requests</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Friend Name</th>
                        <th scope="col">Action</th>
                        <th scope="col">Unread</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($acceptedFriendRequest as $request)
                        <tr>
                            <td>{{ $request->receiver_email }}</td>
                            <td>
                                <button class="btn btn-success chat-btn"
                                    data-receiver="{{ $request->receiver_email }}">Chat</button>
                            </td>
                            
                            <td>
                                {{ $request->unread_messages_count }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.chat-btn').click(function() {
                var receiverEmail = $(this).data('receiver');
                window.location.href = '/chat?receiver_email=' + receiverEmail;
            });
        });
    </script>
</body>

</html>
