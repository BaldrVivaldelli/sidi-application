<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBApy66cKD8zUbMDPNmtVhlooeqJMq1img"></script>
    <title>{{ config('app.name', 'SIDI - Sistema Integral de Informacion') }}</title>
</head>
<body>
    <div id="app" >

    </div>
    <script src="{{asset('/js/app.js')}}"></script>
</body>
