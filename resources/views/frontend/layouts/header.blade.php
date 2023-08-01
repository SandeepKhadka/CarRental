<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    @vite(['resources/css/frontend.css', 'resources/js/frontend.js'])
    @yield('styles')
    <style>
        .menu-toggle {
            display: none;
            position: relative;
            z-index: 999;
            cursor: pointer;
            background-color: transparent;
            border: none;
            padding: 0;
            margin: 0;
            width: 40px;
            height: 40px;
        }

        .menu-toggle span {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 28px;
            height: 2px;
            background-color: #333;
            transform: translate(-50%, -50%);
        }

        .menu-toggle span:first-child {
            transform: translate(-50%, -50%) rotate(-45deg);
        }

        .menu-toggle span:last-child {
            transform: translate(-50%, -50%) rotate(45deg);
        }

        .menu-toggle span:not(:first-child):not(:last-child) {
            transform: translate(-50%, -50%) scaleX(0);
            transition: transform 0.2s ease-in-out;
        }

        .menu-toggle.active span:not(:first-child):not(:last-child) {
            transform: translate(-50%, -50%) scaleX(1);
        }

        @media screen and (max-width: 767px) {
            .menu-toggle {
                display: block;
            }

            nav {
                display: none;
                position: absolute;
                top: 50px;
                left: 0;
                width: 100%;
                background-color: #fff;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                z-index: 998;
            }

            nav.active {
                display: block;
            }

            .secondary-nav li {
                display: block;
                margin: 15px 0;
                text-align: center;
            }

            .secondary-nav li a {
                display: block;
                font-size: 16px;
                line-height: 1.5;
            }
        }
    </style>
    <style>
        @media (max-width: 991px) {
            .form-searchbox {
                display: flex;
                margin-top: 10px;
                align-items: center;
            }

            .select-box-position {
                margin-left: 1rem;
            }
        }
    </style>
    <style>
        .product-list {
            display: flex;
            flex-wrap: wrap;
        }

        .product {
            width: 50%;
            /* for large screens */
        }

        @media screen and (max-width: 768px) {

            /* for small screens */
            .product {
                width: 100%;
            }

            .product:nth-child(odd) {
                order: 1;
            }

            .product:nth-child(even) {
                order: 2;
            }
        }
    </style>

</head>

<body>
       
