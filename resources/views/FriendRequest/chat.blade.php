<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Base styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Chat container */
        .chat {
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            padding: 10px;
            height: 400px;
            overflow-y: auto;
        }

        /* Chat message styling */
        .chat-message {
            padding: 8px 12px;
            margin-bottom: 8px;
            border-radius: 10px;
            word-wrap: break-word;
        }

        .chat-message.sent {
            background-color: #DCF8C6;
            align-self: flex-end;
        }

        .chat-message.received {
            background-color: #ECE5DD;
        }

        /* Chat input and send button */
        .chat-input {
            width: calc(100% - 60px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            box-sizing: border-box;
        }

        .send-btn {
            width: 50px;
            padding: 10px;
            margin-left: 10px;
            border: none;
            border-radius: 50%;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Include your header/navbar here -->
    <div class="container">
        <div class="chat" id="chat-messages">
            @foreach ($messages as $message)
                <div class="message">
                    {{ $message->message }}
                </div>
            @endforeach
        </div>
        <form id="chat-form">
            @csrf
            <div class="input-group">
                <input type="hidden" name="receiver_email" value="{{ request()->query('receiver_email') }}">
                <input type="text" class="form-control chat-input" id="message" name="message"
                    placeholder="Type your message...">
                <button type="submit" class="btn btn-primary send-btn">Send</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var user_email = "{{ Auth::user()->email }}";

            function fetchMessages() {
                $.ajax({
                    url: '/fetch-messages',
                    method: 'GET',
                    success: function(response) {
                        $('#chat-messages').empty();

                        if (response && response.messages) {
                            response.messages.forEach(function(message) {
                                var messageClass = (message.sender_email === user_email ? 'sent' : 'received');
                                $('#chat-messages').append('<div class="chat-message ' + messageClass + '">' + message.message + '</div>');
                            });

                            $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
                        } else {
                            alert("Failed to fetch messages. Please try again later.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            // Fetch messages on page load
            fetchMessages();

            $('#chat-form').submit(function(e) {
                e.preventDefault();
                var message = $('#message').val();
                var receiverEmail = $('input[name="receiver_email"]').val();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '/send-message',
                    method: 'POST',
                    data: {
                        message: message,
                        receiver_email: receiverEmail,
                        _token: csrfToken
                    },
                    success: function(response) {
                        // If message sent successfully, fetch and display messages again
                        fetchMessages();
                        // Clear the message input field
                        $('#message').val('');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
</body>

</html>
