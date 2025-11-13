<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ \App\Models\Setting::get('app_name', 'Learning Portal') }}</title>
        <link rel="icon" type="image/png" href="{{ asset(\App\Models\Setting::get('app_logo', 'images/tlp-logo.png')) }}">

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
        @php
            $images = App\Models\LoginImage::all();
            $video_path = \App\Models\Setting::get('lockscreen_video_path');
            $showLockscreen = !session()->has('errors');
        @endphp

        @if ($video_path && $showLockscreen)
            <div class="lockscreen-overlay" id="lockscreen">
                <video autoplay muted loop playsinline id="lockscreenVideo">
                    <source src="{{ asset($video_path) }}" type="video/mp4">
                </video>

                <div class="lockscreen-content text-bottom">
                    <h4 class="fw-bold text-white">Click anywhere to continue</h4>
                </div>
            </div>

            <button id="relockBtn" class="btn btn-dark rounded-circle position-fixed" style="top: 20px; right: 20px; width: 45px; height: 45px; z-index: 5000; opacity: 0.7;">
                <i class="bi bi-lock-fill"></i>
            </button>
        @endif

        <div class="login-container">
            <div class="image-side">
                @if($images->count() > 0)
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-pause="false">
                        @if($images->count() > 1)
                            <div class="carousel-indicators">
                                @foreach ($images as $index => $image)
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                                @endforeach
                            </div>
                        @endif

                        <div class="carousel-inner">
                            @foreach ($images as $index => $image)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}" data-bs-interval="10000">
                                    <img src="{{ Storage::url($image->image_path) }}" class="d-block w-100" style="height: 100vh; object-fit: cover; object-position: center;" alt="Image Not Found">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{$image->image_label ?? ''}}</h5>
                                        <p>{{$image->image_placeholder ?? ''}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev" style="justify-content: start !important;">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next" style="justify-content: end !important;">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                @else
                    <img src="{{ asset('images/default-login-image.jpg') }}" class="d-block w-100" style="height: 100vh; object-fit: cover; object-position: center;" alt="Default Login Image">
                @endif
            </div>

            <div class="form-side p-4">
                <div></div>
                <div class="w-100">
                    <div class="d-flex justify-content-center">
                        <a href="/">
                            <img src="{{ asset('images/tlp-logo.png') }}" class="img-fluid" style="width: 125px; height: 125px;" alt="Logo">
                        </a>
                    </div>
                    {{ $slot }}
                </div>
                <div class="text-center">
                    <p class="text-muted mb-2" style="font-size: 10.5px; font-weight: bold">“This System is Secured and Safe.”</p>
                    <p class="text-muted mb-0" style="font-size: 10.5px; font-weight: bold">Use a strong password that includes a combination of alphabets (including capital letters) and numbers.</p>
                </div>
            </div>
        </div>

        @include('layouts.script')
        @stack('scripts')
    </body>
</html>
