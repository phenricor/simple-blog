<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Blog')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Inter font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    @include('feed::links')

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('layout.css') }}" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <!-- Jquery UI
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css"> 
    <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


</head>

<body style="font-family: 'Roboto', sans-serif;">
    <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm mb-xl-5 py-xl-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <div class="d-flex align-items-end">
                    <img class="me-3" src="{{ asset('favicon.ico') }}" alt="">
                    <p class="h3">{{env('APP_NAME')}}</p>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/categories">Categories</a>
                    </li>
                    @foreach($pages as $page)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pages.show', $page->slug) }}">{{ $page->title }}</a>
                    </li>
                    @endforeach
                    @if (Auth::check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Admin</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('posts.create') }}#">New Post</a>
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}#">Dashboard</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a>
                        </div>
                    </li>
                    @endif
                    <span class="nav-item">
                        <form action="{{ route('posts.search') }}">
                            <div class="form-inline">
                                <input type="text" class="form-control" id="search" name="search" placeholder="Search">
                            </div>
                              <!--<button type="submit" class="btn btn-primary">Submit</button>-->
                        </form>
                    </span>
                </ul>
            </div>

        </div>
    </nav>

    <!-- Main Content -->
    <main class="container" style="max-width: @yield('max-width', '700px')">

        <!-- Alert component -->
        <x-alert></x-alert>

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white text-black py-3 mt-4">
        <div class="d-flex justify-content-center my-4" style="gap:6px">
            @foreach ($settings->where('value', '<>', null) as $setting)
                <span>
                    <a href="{{$setting->value}}" style="color:black; text-decoration:none">
                        @switch ($setting->key)
                        @case('github_link')
                        <i class="fa-brands fa-github fa-2xl"></i>
                        @break
                        @case('facebook_link')
                        <i class="fa-brands fa-facebook fa-2xl"></i>
                        @break
                        @case('linkedin_link')
                        <i class="fa-brands fa-linkedin fa-2xl"></i>
                        @break
                        @case('email_link')
                        <i class="fa-solid fa-envelope fa-2xl"></i>
                        @break
                        @case('telegram_link')
                        <i class="fa-brands fa-telegram fa-2xl"></i>
                        @break
                        @case('x_link')
                        <i class="fa-brands fa-square-x-twitter fa-2xl"></i>
                        @break
                        @case('instagram_link')
                        <i class="fa-brands fa-instagram fa-2xl"></i>
                        @break
                        @endswitch
                    </a>
                </span>
                @endforeach
        </div>
        <div class="container text-center">
            <p>&copy; 2024</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>