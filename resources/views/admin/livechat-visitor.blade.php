@php
    use Illuminate\Support\Facades\Session;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, height=device-height,  initial-scale=1.0, user-scalable=no;user-scalable=0;" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nine - Livechat</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('images/user.jpg') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/sweetalert2/dist/sweetalert2.min.css') }}">

    <script src="{{ asset('template/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.1/echo.iife.min.js"></script>
</head>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: "Poppins", sans-serif;

        --chat-background: rgb(10 14 14 / 62%);
        --chat-panel-background: #131719;
        --chat-send-button-background: #aa9160;
        --chat-text-color: #a3a3a3;

        --chat-bubble-background: #ffffff;
        --chat-bubble-name: #141212;
        --chat-bubble-message: #2b2b2b;
        --chat-bubble-time: #323232;
    }

    #chat {
        max-width: 600px;
        margin: 25px auto;
        box-sizing: border-box;
        padding: 1em;
        border-radius: 12px;
        position: relative;
        overflow: hidden;
        height: 90vh;
    }

    #chat .chat__conversation-title {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }

    .rounded-img {
        width: 50px;
    }

    .rounded-img img {
        border-radius: 50%;
        width: 100%;
    }

    #chat .chat__conversation-title h4 {
        margin: 0;
        color: #bfbdbd;
    }

    #chat .chat__conversation-title .divider {
        display: block;
        height: 30px;
        width: 1px;
        background-color: #717171;
    }

    #chat .btn-icon {
        position: relative;
        cursor: pointer;
    }

    #chat .btn-icon svg {
        stroke: #fff;
        fill: #fff;
        width: 50%;
        height: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    #chat .chat__conversation-panel {
        background: var(--chat-panel-background);
        border-radius: 12px;
        padding: 0 1em;
        height: 40px;
        border: 1px solid grey;
        position: absolute;
        bottom: 70px;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        box-sizing: border-box;
    }

    #chat .chat__conversation-panel__container {
        display: flex;
        flex-direction: row;
        align-items: center;
        height: 100%;
    }

    #chat .chat__conversation-panel__container .panel-item:not(:last-child) {
        margin: 0 1em 0 0;
    }

    #chat .chat__conversation-panel__button {
        background: grey;
        height: 20px;
        width: 30px;
        border: 0;
        padding: 0;
        outline: none;
        cursor: pointer;
    }

    #chat .chat__conversation-panel .send-message-button {
        background: var(--chat-send-button-background);
        height: 30px;
        min-width: 30px;
        border-radius: 50%;
        transition: 0.3s ease;
    }

    #chat .chat__conversation-panel .send-message-button:active {
        transform: scale(0.97);
    }

    #chat .chat__conversation-panel .send-message-button svg {
        margin: 1px -1px;
    }

    #chat .chat__conversation-panel__input {
        width: 100%;
        height: 100%;
        outline: none;
        position: relative;
        color: var(--chat-text-color);
        font-size: 13px;
        background: transparent;
        border: 0;
        resize: none;
    }

    #chat .information {
        margin-top: 10px;
        justify-content: center;
        text-align: center;
    }

    #chat .information>p {
        margin-bottom: 0;
        font-size: 10px;
        color: #717171;
    }

    .chat__conversation-wrapper {
        height: 70vh;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    .chat__conversation-wrapper::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #bdbdbd;
    }

    .chat__conversation-wrapper::-webkit-scrollbar {
        width: 6px;
        background-color: #f5f5f5;
    }

    .chat__conversation-wrapper::-webkit-scrollbar-thumb {
        background-color: #000000;
    }

    .chat__conversation-sender_container {
        position: absolute;
        top: -30px;
    }

    .chat__conversation-sender_container .chat__conversation-sender {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        height: 100%;
        gap: 1rem;
    }

    .chat__conversation-sender p {
        margin: 0;
        font-size: 10px;
        color: #a9a9a9;
    }

    .chat__conversation-sender a {
        margin-bottom: 0;
        font-size: 10px;
        color: #a9a9a9;
        background-color: #2f2f2f;
        padding: 5px;
        border-radius: 5px;
    }

    small,
    .small {
        color: #272727;
        font-size: 85%;
    }

    .chat-message {
        padding-top: 40px;
    }

    .chat {
        list-style: none;
        margin: 0;
        padding: 0;
        /* padding-inline-start: 0; */
    }

    .chat-body {
        padding-bottom: 20px;
    }

    .chat li.right .chat-body {
        /* margin-left: 70px; */
        background-color: #fff;
    }

    .chat li .chat-body {
        position: relative;
        font-size: 11px;
        padding: 10px;
        border: 1px solid #f1f5fc;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
    }

    .chat li .chat-body .header {
        padding-bottom: 5px;
        border-bottom: 1px solid #f1f5fc;
    }

    .chat li .chat-body p {
        margin: 10px 0;
    }

    .chat li.right .chat-body:before {
        position: absolute;
        top: 10px;
        right: -8px;
        display: inline-block;
        background: #fff;
        width: 16px;
        height: 16px;
        border-top: 1px solid #f1f5fc;
        border-right: 1px solid #f1f5fc;
        content: "";
        transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
    }

    .chat li {
        width: 400px;
        margin: 15px 0;
        margin-left: auto;
        margin-right: 20px;
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

    .primary-font {
        color: #272727;
    }

    @media only screen and (max-width: 600px) {
        #chat {
            max-width: 360px;
        }

        .chat li {
            width: 300px;
        }

        #chat .chat__conversation-panel__input {
            font-size: 10px;
        }

        #chat .chat__conversation-panel {
            bottom: 50px;
        }

        #chat .chat__conversation-panel .send-message-button {
            height: 25px;
            min-width: 25px;
        }

        #chat .btn-icon svg {
            width: 35%;
        }
    }

    @media only screen and (max-width: 426px) {
        .rounded-img {
            width: 30px;
        }

        #chat .chat__conversation-title h4 {
            font-size: 12px;
        }

        .chat li {
            width: 200px;
        }
    }

    @media only screen and (max-width: 376px) {
        #chat {
            max-width: 300px;
        }
    }
</style>

<style>
    .custom-swal-popup {
        height: auto !important;
        padding: 5px !important;
    }

    .custom-swal-title {
        font-size: 12px !important;
    }

    .swal2-popup {
        background-color: #333 !important;
        color: #fff !important;
    }

    .swal2-input {
        background-color: #555 !important;
        color: #fff !important;
    }

    .swal2-title {
        color: #fff !important;
    }

    .swal2-popup.swal2-toast {
        box-shadow: unset
    }
</style>

<body>
    <div id="chat">
        <!-- Title -->
        <div class="chat__conversation-title">
            <div class="rounded-img">
                <img src="{{ asset('images/user.jpg') }}" alt="" />
            </div>
            <div class="divider"></div>
            <h4>Livechat App</h4>
        </div>
        <!-- Title -->

        <!-- Wrapper -->
        <div class="chat__conversation-wrapper">
            <div class="chat-message">
                <ul class="chat" id="chat-container">
                </ul>
            </div>
        </div>
        <!-- Wrapper -->

        <!-- Panel Send -->
        <div class="chat__conversation-panel">
            <div class="chat__conversation-sender_container">
                <div class="chat__conversation-sender">
                    <p>Hello, <strong><span
                                id="senderName">{{ Session::has('senderName') ? Session::get('senderName') : 'Name Sender' }}</span></strong>
                    </p>
                    <a onclick="changeName(event, this)" href="javascript:void(0)">Change Name Sender Here</a>
                </div>
            </div>
            <form onsubmit="sendMessage(event, this)" action="{{ route('events.send-chat', $event->id) }}"
                method="POST" class="chat__conversation-panel__container" autocomplete="off">
                @csrf
                <input type="hidden" name="sender_name"
                    value="{{ Session::has('senderName') ? Session::get('senderName') : '' }}">
                <input class="chat__conversation-panel__input panel-item" placeholder="Write your message here..."
                    name="content" />
                <button type="submit" class="chat__conversation-panel__button panel-item btn-icon send-message-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" aria-hidden="true">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </form>
        </div>
        <!-- Panel Send -->
    </div>

    <!-- Sweetalert -->
    <script src="{{ asset('template/assets/vendors/sweetalert2/dist/sweetalert2.min.js') }}"></script>

    <script>
        // Check if sender_name is empty
        const senderNameInput = document.querySelector('input[name="sender_name"]');
        const contentInput = document.querySelector('input[name="content"]');

        if (senderNameInput.value.trim() === '') {
            showAlert('Sender name must be filled.');
        }

        // Function to send a message
        function sendMessage(event, form) {
            event.preventDefault();

            if (!validateForm()) {
                return;
            }

            const formData = new FormData(form);
            fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 429) {
                            throw new Error('Too Many Requests');
                        } else if (response.status === 422) {
                            return response.json().then(data => {
                                throw new Error(JSON.stringify(data.errors));
                            });
                        }

                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    getMessagesSender();
                    form.reset();
                })
                .catch(error => {
                    form.reset();
                    if (error.message === 'Too Many Requests') {
                        showAlert(
                            'You have reached the maximum number of messages. Please wait 5 minutes and try again.');
                    } else {
                        try {
                            const errors = JSON.parse(error.message);
                            for (const field in errors) {
                                errors[field].forEach(errorMessage => {
                                    showAlert(errorMessage);
                                });
                            }
                        } catch (e) {
                            console.error('Error:', error);
                        }
                    }
                });
        }

        // Function to change sender's name
        function changeName(event, element) {
            event.preventDefault();

            Swal.fire({
                title: 'Enter your name',
                input: 'text',
                inputPlaceholder: 'Enter your name',
                showCancelButton: true,
                inputValidator: (value) => {
                    return !value && 'You need to write something!';
                }
            }).then((result) => {
                if (result.value) {
                    const name = result.value;
                    senderNameInput.value = name;
                    document.getElementById('senderName').textContent = name;
                }
            });
        }

        // Function to fetch messages
        function getMessagesSender() {
            $.ajax({
                url: "{{ route('events.get-chat-visitor', $event->id) }}",
                method: "GET",
                success: function(response) {
                    if (response.messages && response.messages.length > 0) {
                        document.getElementById('chat-container').innerHTML = '';
                        response.messages.forEach(function(message) {
                            renderMessage(message);
                        });
                        scrollToBottom();
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
                    <li class="right speech-wrapper clearfix">
                        <div class="chat-body clearfix">
                            <div class="header">
                                <strong class="primary-font">${message.sender_name}</strong>
                                <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> ${formatTime(message.created_at)}</small>
                            </div>
                            <p>${message.content}</p>
                        </div>
                    </li>
                `;
            document.getElementById('chat-container').innerHTML += messageHtml;
        }

        // Function to scroll chat container to the bottom
        function scrollToBottom() {
            const chatContainer = document.getElementById('chat-container');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        // Function to format time to H:i
        function formatTime(dateTimeString) {
            const date = new Date(dateTimeString);
            return date.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Function to show alert
        function showAlert(message) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                showCloseButton: true,
                allowEscapeKey: false,
                type: 'error',
                timer: 5000,
                title: message,
                customClass: {
                    popup: 'custom-swal-popup',
                    title: 'custom-swal-title',
                    icon: 'custom-swal-icon',
                }
            });
        }

        function validateForm() {
            let isValid = true;

            const senderName = $('input[name="sender_name"]').val().trim();
            const content = $('input[name="content"]').val().trim();

            if (senderName === '') {
                showAlert('Sender name must be filled.');
                isValid = false;
            } else if (senderName.length > 20) {
                showAlert('Sender name must not exceed 20 characters.');
                isValid = false;
            }

            if (content === '') {
                showAlert('Message must not be empty.');
                isValid = false;
            } else if (content.length > 100) {
                showAlert('Message must not exceed 100 characters.');
                isValid = false;
            }

            return isValid;
        }

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true
        });

        var channel = pusher.subscribe('chatDelete-' + '{{ $event->id }}');

        channel.bind('message.delete', function(data) {
            getMessagesSender();
            scrollToBottom();
        });

        // Function to set chat background
        function setChatBackground() {
            @if ($event->visitor_flag_background === 'image')
                document.body.style.background =
                    "url('{{ asset('uploads/' . $event->visitor_background_image) }}')";
                document.body.style.backgroundSize = "cover";
                document.body.style.backgroundPosition = "center";

                const visitorBackground = document.createElement('style');
                visitorBackground.innerHTML = `
                        #chat {
                            background: linear-gradient(0deg, rgb(0 0 0), rgb(0 0 0 / 31%)),
                            url('{{ asset('uploads/' . $event->visitor_background_image) }}');
                            background-size: cover;
                        }
                    `;
                document.head.appendChild(visitorBackground);
            @else
                document.body.style.background = "{{ $event->videotron_color_code }}";
                const visitorBackground = document.createElement('style');
                visitorBackground.innerHTML = `
                        #chat {
                            background: #535353;
                        }
                    `;
                document.head.appendChild(visitorBackground);
            @endif
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Initialize chat background
            setChatBackground();

            // Fetch and display messages
            getMessagesSender();

            scrollToBottom();
        });
    </script>
</body>

</html>
