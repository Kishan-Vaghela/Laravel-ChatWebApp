<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Friend Requests</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @include('header.navbar')
    <div class="container">
        <h1 class="mt-5 mb-4">Friend Requests</h1>

        @if ($friendRequest->isEmpty())
            <h5>
                <p class="mt-5 mb-4">No friend Requests
            </h5>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Friend Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($friendRequest as $request)
                        <tr>
                            <td>{{ $request->sender_email }}</td>

                            <td>
                                @if ($request->status === 'accepted')
                                    <span>You are already friends</span>
                                @else
                                    <button type="button" class="btn btn-success"
                                        onclick="accept('{{ $request->email }}', this)">Accept</button>
                                    <button type="button" class="btn btn-danger"
                                        onclick="reject('{{ $request->email }}', this)">Reject</button>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function reject(value, button) {
            const csrfToken = $('meta[name="csrf-token"]').attr("content");

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                url: "/friendrequestreject",
                method: "POST",
                data: {
                    receiver_email: value
                },
                success: function(response) {
                    console.log(response);

                    $(button).closest('tr').remove();


                    if ($('table tbody tr').length === 0) {
                        $('table').replaceWith('<p>No friend requests</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function accept(value, button) {
            const csrfToken = $('meta[name="csrf-token"]').attr("content");

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                url: "/friendrequestaccept",
                method: "POST",
                data: {
                    receiver_email: value
                },
                success: function(response) {
                    console.log(response);
                    if (response.message === 'You are friends!') {
                        $(button).text('Friend request accepted!');
                        $(button).prop('disabled', true);


                        $(button).closest('tr').find('.btn-danger').remove();

                        setTimeout(function() {
                            $(button).closest('tr').remove();

                            if ($('table tbody tr').length === 0) {
                                $('table').replaceWith('<p>No friend requests</p>');
                            }
                        }, 5000);
                    } else {
                        alert('Friend request accepted successfully');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', error);
                }
            });
        }
    </script>
</body>

</html>
