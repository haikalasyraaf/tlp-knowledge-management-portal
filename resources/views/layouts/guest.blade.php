<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.3.2/af-2.7.0/b-3.2.4/b-colvis-3.2.4/b-html5-3.2.4/cr-2.1.1/cc-1.0.7/date-1.5.6/fc-5.0.4/fh-4.0.3/kt-2.12.1/r-3.0.5/rg-1.5.2/rr-1.5.0/sc-2.4.3/sb-1.8.3/sp-2.3.4/sl-3.0.1/sr-1.4.1/datatables.min.css" rel="stylesheet" integrity="sha384-sROE1s64prpf3uLl9B1Lb+fit5yrSPUMfINf2T0ihprXiMBLH6Hgz6jhkEWYt+2B" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        @include('layouts.style')
    </head>
    <body class="bg-light">
        <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center" style="background: linear-gradient(to right, #2c3b71, #0aaead);">
            <div class="w-100" style="max-width: 420px;">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-center mb-3">
                            <a href="/">
                                <img src="{{ asset('images/tlp-logo.png') }}" class="img-fluid" style="width: 80px; height: 80px;" alt="Image">
                            </a>
                        </div>
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.script')
        @stack('scripts')
    </body>
</html>
