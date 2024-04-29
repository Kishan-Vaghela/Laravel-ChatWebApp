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
        /* Reset default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .chat {
            background-color: #fff;
            border-radius: 8px;
            padding: 10px;
            max-height: 400px;
            overflow-y: scroll;
        }

        .chat-message {
            margin: 5px 0;
            padding: 8px 12px;
            border-radius: 10px;
            max-width: 70%;
        }

        .sent {
            background-color: #dcf8c6;
            align-self: flex-start;
            margin-left: 20px;
        }

        .received {
            background-color: #e5e5ea;
            align-self: flex-end;
            margin-right: 20px;
        }

        .input-group {
            margin-top: 20px;
        }

        .chat-input {
            border-radius: 20px;
        }

        .send-btn {
            border-radius: 20px;
            margin-left: 10px;
        }

        @media screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .chat-message {
                max-width: 60%;
            }
        }
    </style>
</head>

<body>
    @include('header.navbar')
    <br>
    <div class="container">
        <div class="chat" id="chat-messages">
            @foreach ($messages as $message)
                <div class="chat-message {{ $message->sender_email === Auth::user()->email ? 'sent' : 'received' }}">
                    {{ $message->message }}
                </div>
            @endforeach
        </div>
        <form id="chat-form" action="javascript:void(0);" method="POST">
            @csrf
            <div class="input-group">
                <input type="hidden" name="receiver_email" value="{{ request()->query('receiver_email') }}">
                <input type="text" class="form-control chat-input" id="message" name="message"
                    placeholder="Type your message...">
                <button id="send-button" type="submit" class="btn btn-primary send-btn">Send</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function fetchMessages() {
                var receiverEmail = $('input[name="receiver_email"]').val();
                $.ajax({
                    url: '/fetch-messages',
                    method: 'POST',
                    data: {
                        receiver_email: receiverEmail,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        $('#chat-messages').empty();
                        if (response.status === 'success' && Array.isArray(response.message)) {
                            response.message.forEach(function(message) {
                                let messageElement = $('<div class="chat-message"></div>');
                                if ('{{ Auth::user()->email }}' === message.sender_email) {
                                    messageElement.addClass('sent');
                                } else {
                                    messageElement.addClass('received');
                                }
                                messageElement.text(message.message);
                                $('#chat-messages').append(messageElement);
                            });
                            $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }

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
                        console.log(response.message);
                        if (response && response.message) {
                            $('#chat-messages').append('<div class="chat-message sent">' +
                                response.message.message + '</div>');
                            $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
                            $('#message').val('');
                        } else {
                            alert("Failed to send message. Please try again later.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            setInterval(fetchMessages, 2000);
        });
    </script>
</body>

</html>
