<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nine - Livechat</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('images/user.jpg') }}" />

    <link rel="stylesheet" href="{{ asset('template/assets/vendors/sweetalert2/dist/sweetalert2.min.css') }}">
</head>

<style>
    body {
        font-size: 12px;
        font-family: "Open Sans", sans-serif;
        margin: 0;
        padding: 0;
    }

    .time {
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

    .chat li .chat-body p {
        margin: 5px 0 10px 0;
    }

    /* .chat li.left .chat-body:before {
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
    } */

    .chat li {
        width: 280px;
        margin: 10px 0;
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
        font-weight: 600;
        font-size: 20px;
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
        <ul class="chat" id="chat-container">
            <li class="left speech-wrapper clearfix">
                <div class="chat-body clearfix"
                    style="background-color: {{ $event->bubble_color_code_message_background }}">
                    <div class="header">
                        <strong class="primary-font" style="color: {{ $event->bubble_color_code_message_name }}">John
                            Doe</strong>
                    </div>
                    <p class="message" style="color: {{ $event->bubble_color_code_message_text }}">Lorem ipsum dolor sit
                        amet,
                        consectetur adipiscing elit.</p>
                    <div style="text-align: end">
                        <p class="time pull-right text-muted"
                            style="color: {{ $event->bubble_color_code_message_time }}">10:00</p>
                    </div>
                </div>
            </li>
            <li class="left speech-wrapper clearfix">
                <div class="chat-body clearfix"
                    style="background-color: {{ $event->bubble_color_code_message_background }}">
                    <div class="header">
                        <strong class="primary-font"
                            style="color: {{ $event->bubble_color_code_message_name }}">Sarah</strong>
                    </div>
                    <p class="message" style="color: {{ $event->bubble_color_code_message_text }}">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales
                        at.
                    </p>
                    <div style="text-align: end">
                        <p class="time pull-right text-muted"
                            style="color: {{ $event->bubble_color_code_message_time }}"></i>12:45</p>
                    </div>
                </div>
            </li>
            <li class="left speech-wrapper clearfix">
                <div class="chat-body clearfix"
                    style="background-color: {{ $event->bubble_color_code_message_background }}">
                    <div class="header">
                        <strong class="primary-font" style="color: {{ $event->bubble_color_code_message_name }}">John
                            Doe</strong>
                    </div>
                    <p class="message" style="color: {{ $event->bubble_color_code_message_text }}">Lorem ipsum dolor
                        sit amet,
                        consectetur adipiscing elit.</p>
                    <div style="text-align: end">
                        <p class="time pull-right text-muted"
                            style="color: {{ $event->bubble_color_code_message_time }}">08:00</p>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

            // const bubbleArrowStyle = `
        //     .chat li.left .chat-body:before {
        //         background: ${bubbleColor};
        //         border-top: 1px solid ${bubbleColor};
        //         border-left: 1px solid ${bubbleColor};
        //     }
        // `;
            const messageNameStyle = `
                .primary-font {
                    color: ${nameColor};
                }
            `;
            const messageTimeStyle = `
                .time {
                    color: ${timeColor};
                }
            `;
            const messageTextStyle = `
                .message {
                    color: ${textColor};
                }
            `;

            const style = document.createElement('style');
            style.innerHTML = messageNameStyle + messageTimeStyle + messageTextStyle;
            document.head.appendChild(style);
        });


        // Function to scroll chat container to the bottom
        function scrollToBottom() {
            window.scrollTo(0, document.body.scrollHeight);
        }

        setTimeout(() => {
            scrollToBottom();
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                showCloseButton: true,
                allowEscapeKey: false,
                type: 'info',
                title: "You are seeing demo page.",
                customClass: {
                    popup: 'custom-swal-popup',
                    title: 'custom-swal-title',
                    icon: 'custom-swal-icon',
                }
            })
        }, 100);
    </script>
</body>

</html>
