<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nine - Livechat</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('template/assets/vendors/sweetalert2/dist/sweetalert2.min.css') }}">

    <link rel="shortcut icon" href="{{ asset('images/user.jpg') }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.1/echo.iife.min.js"></script>

</head>

<style>
    body {
        font-size: 12px;
        font-family: "Open Sans", sans-serif;
        margin: 0;
        padding: 0;
    }

    small,
    .small {
        font-size: 12px
    }

    .chat-message {
        padding-top: 40px;
        padding-left: 20px;
        padding-right: 40px;
    }

    .chat {
        list-style: none;
        margin: 0;
        padding: 0;
        /* padding-inline-start: 0; */
    }

    .chat li img {
        width: 45px;
        height: 45px;
        border-radius: 50em;
        -moz-border-radius: 50em;
        -webkit-border-radius: 50em;
    }

    img {
        max-width: 100%;
    }

    .chat-body {
        padding-bottom: 20px;
    }

    .chat li .chat-body {
        position: relative;
        font-size: 11px;
        padding: 10px;
        border-radius: 15px;
    }

    .chat li .chat-body .header {
        padding-bottom: 5px;
        border-bottom: 1px solid #f1f5fc;
    }

    .chat li .chat-body p {
        margin: 10px 0;
    }

    .chat li.left .chat-body:before {
        z-index: -1;
        position: absolute;
        top: 20px;
        left: -5px;
        display: inline-block;
        width: 16px;
        height: 16px;
        content: "";
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        -ms-transform: rotate(-45deg);
        -o-transform: rotate(-45deg);
    }

    .chat li {
        width: 280px;
        margin: 30px 0;
    }

    .chat-body p {
        color: #777;
    }

    .chat-box {
        position: fixed;
        bottom: 0;
        left: 444px;
        right: 0;

        padding: 15px;
        border-top: 1px solid #eee;
        transition: all 0.5s ease;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -ms-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
    }

    a:hover,
    a:active,
    a:focus {
        text-decoration: none;
        outline: 0;
    }

    .primary-font {
        font-size: 20px;
        font-weight: 900;
    }

    .message {
        font-size: 20px;
        font-weight: 600;
        white-space: wrap;
        word-break: break-all;
    }

    @media (max-width: 600px) {
        .chat-message {
            padding-top: 20px;
            padding-left: 20px;
            padding-right: 20px;
        }

        .chat li {
            width: 100%;
        }
    }
</style>

<body
    style="{{ $event->videotron_flag_background === 'image'
        ? 'background: url(' . asset('uploads/' . $event->videotron_background_image) . ');background-size:cover'
        : 'background: ' . $event->videotron_color_code }};">

    <div class="chat-message">
        <ul class="chat" id="chat-container"></ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Sweetalert -->
    <script src="{{ asset('template/assets/vendors/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Set background based on event properties
            @if ($event->videotron_flag_background === 'image')
                document.body.style.background =
                    "url('{{ asset('uploads/' . $event->videotron_background_image) }}')";
                document.body.style.backgroundSize = "cover";
            @else
                document.body.style.background = "{{ $event->videotron_color_code }}";
            @endif

            // Apply styling for bubbles
            const bubbleColor = "{{ $event->bubble_color_code_message_background }}";
            const nameColor = "{{ $event->bubble_color_code_message_name }}";
            const timeColor = "{{ $event->bubble_color_code_message_time }}";
            const textColor = "{{ $event->bubble_color_code_message_text }}";

            const bubbleArrowStyle = `
                .chat li.left .chat-body:before {
                    background: ${bubbleColor};
                    border-top: 1px solid ${bubbleColor};
                    border-left: 1px solid ${bubbleColor};
                }
            `;
            const messageNameStyle = `
                .primary-font {
                    color: ${nameColor};
                }
            `;
            const messageTimeStyle = `
                small {
                    color: ${timeColor};
                }
            `;
            const messageTextStyle = `
                .message {
                    color: ${textColor};
                }
            `;

            const style = document.createElement('style');
            style.innerHTML = bubbleArrowStyle + messageNameStyle + messageTimeStyle + messageTextStyle;
            document.head.appendChild(style);

            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                forceTLS: true
            });

            var channel = pusher.subscribe('chat');

            channel.bind('message.sent', function(data) {
                renderMessage(data.message);
                scrollToBottom();
            });

            var channel = pusher.subscribe('chatDelete');

            channel.bind('message.delete', function(data) {
                getMessagesSender();
                scrollToBottom();
            });

            // Function to fetch messages
            function getMessagesSender() {
                $.ajax({
                    url: "{{ route('events.get-chat-videotron', $event->id) }}",
                    method: "GET",
                    success: function(response) {
                        if (response.messages && response.messages.length > 0) {
                            $('#chat-container').empty();
                            response.messages.forEach(function(message) {
                                renderMessage(message);
                            });
                            scrollToBottom();

                            const speechWrappers = document.querySelectorAll('.speech-wrapper');

                            speechWrappers.forEach(wrapper => {
                                wrapper.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    const messageId = e.currentTarget.getAttribute(
                                        'data-message-id');
                                    showDeleteConfirmation(messageId);
                                });
                            });
                        }
                    },
                    error: function() {
                        console.error("Failed to fetch messages");
                    }
                });
            }

            // Function to render a message
            function renderMessage(message) {
                const messageHtml = `
                    <li class="left speech-wrapper clearfix" data-message-id="${message.id}">
                        <div class="chat-body clearfix"
                        style="background-color: ${bubbleColor}">
                            <div class="header">
                                <strong class="primary-font"
                                style="color: ${nameColor}">${message.sender_name.toUpperCase()}</strong>
                                <small class="pull-right text-muted"
                                style="color: ${timeColor}">${formatTime(message.created_at)}</small>
                            </div>
                            <p class="message" style="color: ${textColor}">${message.content}</p>
                        </div>
                    </li>
                `;
                document.getElementById('chat-container').innerHTML += messageHtml;
            }

            // Function to scroll chat container to the bottom
            function scrollToBottom() {
                window.scrollTo(0, document.body.scrollHeight);
            }

            // Function to format time to H:i
            function formatTime(dateTimeString) {
                const date = new Date(dateTimeString);
                return date.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            // Fetch and display messages on load
            getMessagesSender();
            scrollToBottom();

            function showDeleteConfirmation(messageId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to delete this message?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        deleteMessage(messageId);
                    }
                });
            }

            function deleteMessage(messageId) {
                $.ajax({
                    url: "{{ url('/events/livechat/delete-chat') }}/" + "{{ $event->id }}" + "/" +
                        messageId,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "DELETE",
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                showCloseButton: true,
                                allowEscapeKey: false,
                                type: 'success',
                                timer: 5000,
                                title: "Deleted",
                                customClass: {
                                    popup: 'custom-swal-popup',
                                    title: 'custom-swal-title',
                                    icon: 'custom-swal-icon',
                                }
                            });
                            getMessagesSender();
                            scrollToBottom();
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                showCloseButton: true,
                                allowEscapeKey: false,
                                type: 'error',
                                timer: 5000,
                                title: "Failed to delete the message.",
                                customClass: {
                                    popup: 'custom-swal-popup',
                                    title: 'custom-swal-title',
                                    icon: 'custom-swal-icon',
                                }
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            showCloseButton: true,
                            allowEscapeKey: false,
                            type: 'error',
                            timer: 5000,
                            title: "Failed to delete the message.",
                            customClass: {
                                popup: 'custom-swal-popup',
                                title: 'custom-swal-title',
                                icon: 'custom-swal-icon',
                            }
                        });
                    }
                });
            }

        });
    </script>
</body>

</html>
