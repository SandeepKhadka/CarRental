<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-switch-button/css/bootstrap-switch-button.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/goodgoods.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}"> --}}
    {{-- @notifyCss --}}
    @yield('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
   
