<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>
<header class="fixed-top mb-3">
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container d-flex justify-content-lg-around">
                <div class="w-25">
                    @if(Auth()->check())
                        <a class="navbar-brand" href="{{route('home')}}">
                            {{Auth::user()->name}}
                        </a>
                    @endif
                </div>

                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">

                        @if(auth()->check())
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{route('home')}}">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="{{route('books')}}">Books</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="#contact">Contact Us</a>
                            </li>
{{--@dd(auth()->user()->books->count()==$plan->limit)--}}
                        @if(Auth::user()->subscriptions->isNotEmpty())
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="{{route('create')}}">Create Your Book</a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{route('subscriptions')}}">Subscriptions</a>
                            </li>

                        @else
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="{{route('books')}}">Books</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{route('home')}}">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{route('logout')}}">login</a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('register')}}">Register</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            @if(Auth()->check())
            <div>
                <li class="nav-item d-inline color ">
                    <a class="nav-link" href="{{route('logout')}}">loguth</a>
                </li>
            </div>
                @endif
        </nav>
    </div>
</header>
@yield("content")
<footer class="bg-brown py-5 mt-5">
    <div class="container">
        <div class="text-center">
            <p class="color-milk m-0 fs-8"> © 2023 by Amanda Peterson. Proudly created with Wix.com</p>
        </div>
    </div>
</footer>
<!-- JavaScript Bundle with Popper -->
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>
</body>
</html>
