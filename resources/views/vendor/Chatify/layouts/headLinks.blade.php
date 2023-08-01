<title>{{ config('chatify.name') }}</title>

{{-- Meta tags --}}
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="id" content="{{ $id }}">
<meta name="messenger-color" content="{{ $messengerColor }}">
<meta name="messenger-theme" content="{{ $dark_mode }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="url" content="{{ url('') . '/' . config('chatify.routes.prefix') }}" data-user="{{ Auth::user()->id }}">

{{-- scripts --}}
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/chatify/font.awesome.min.js') }}"></script>
<script src="{{ asset('js/chatify/autosize.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>

{{-- styles --}}
<link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css' />
<link href="{{ asset('css/chatify/style.css') }}" rel="stylesheet" />
<link href="{{ asset('css/chatify/' . $dark_mode . '.mode.css') }}" rel="stylesheet" />
<link href="{{ asset('css/app.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">


{{-- Setting messenger primary color to css --}}
<style>
    :root {
        --primary-color: {{ $messengerColor }};
    }

    .success-badge {
        display: inline-block;
        padding: 0.5em 1em;
        background-color: #26d04e;
        color: #fff;
        font-weight: bold;
        text-decoration: none;
        border-radius: 20px;
        /* border: 1px solid #28a745; */
    }

    .success-badge:hover {
        background-color: #4CAF50;
    }

    .success-badge:active {
        background-color: #3e8e41;
    }

    .success-badge:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.5);
    }

    .success-badge:disabled {
        background-color: #c8e6c9;
        border-color: #c8e6c9;
        color: #666;
    }

    .success-badge.light {
        background-color: #8bc34a;
        border-color: #8bc34a;
    }

    .success-badge.light:hover {
        background-color: #9ccc65;
    }

    .success-badge.light:active {
        background-color: #7cb342;
    }

    .success-badge.light:focus {
        box-shadow: 0 0 0 0.2rem rgba(139, 195, 74, 0.5);
    }

    .success-badge.white-text {
        color: #fff;
    }

    /* Styles for the popup modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        position: relative;
        max-width: 600px;
        width: 90%;
    }

    .close {
        color: #aaa;
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="email"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .input-group {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input-group-addon {
        position: absolute;
        left: 0;
        padding: 10px;
        font-size: 16px;
        background-color: #ccc;
        color: #fff;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }

    .form-group select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .submit-btn {
        background-color: #28a745;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        font-size: 16px;
        cursor: pointer;
    }

    .submit-btn:hover {
        background-color: #4CAF50;
    }

    .submit-btn:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.5);
    }

</style>
