<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    
    {{-- <link href="{{ secure_asset('css/logo.css') }}" rel="stylesheet"> --}}
    {{-- <link href="https://fonts.cdnfonts.com/css/billabong" rel="stylesheet"> --}}

    <!-- Scripts -->
    @vite(['resources/sass/app.scss'])
    {{-- <link rel="stylesheet" href="/manamigram/public/build/assets/app-484dfcb9.css"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}
    <style>
        p{
            word-wrap:break-word;
        }
        .navbar-brand{
            font-family: 'Billabong', sans-serif;
            font-size: 24px;
        }
    </style>
</head>
<body>
    
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-dark shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand text-white" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                            <li class="nav-item">
                                <a href="{{ route('post.create') }}" class="nav-link text-white">Create a post</a>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @yield('content')
                </div>
            </div>
        </main>

        <footer class="footer mt-auto py-3 bg-dark fixed-bottom">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col">
                        <a href="{{ route('index') }}" class="btn btn-primary w-100">
                            <i class="fa-solid fa-house text-white"></i>
                        </a>
                    </div>
                    {{-- <div class="col">
                        <i class="fa-solid fa-magnifying-glass text-white"></i>
                    </div> --}}
                    <div class="col">
                        {{-- @if(Auth::user()->picture) --}}
                        @guest
                            @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="btn btn-success w-100">Login</a>
                            @endif
                        @else
                            <a href="{{ route('profile.show', Auth::user()->id) }}" class="btn btn-success w-100">
                                @if(false)
                                        <img src="{{ asset('storage/photos/'.Auth::user()->picture) }}" alt="{{ Auth::user()->picture }}" class="d-block mx-auto dashboard-photo" style="width:3.5rem; height:3.5rem; object-fit:cover;">
                                @else
                                    <i class="fa-regular fa-user text-white d-block text-center dashboard-icon" style="font-size: 1.5rem;"></i>
                                @endif
                            </a>
                        @endguest
                    </div>
                </div>
              {{-- <span class="text-muted">aaa</span> --}}
            </div>

        </footer>
        
    </div>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> --}}
    @vite(['resources/js/app.js'])
    
    {{-- <script type="module" src="{{ secure_asset('/resources/js/app.js') }}"></script> --}}
    <script type="module">
    $(()=>{

        //preview media
    // $("#media").change(function(){
    //     // alert("sss");
    //     console.log(event.target.files[0]);
    //     var file = event.target.files[0];
    //     var reader = new FileReader();
    //     var preview = document.getElementById("preview");
    //     var previewMedia = document.getElementById("previewMedia");
    //     var label= document.getElementById("mediaLabel");

    //     if(previewMedia != null) {
    //         preview.removeChild(previewMedia);
    //     }
    //     reader.onload = function() {
    //         var img = document.createElement("img");
    //         img.setAttribute("src", reader.result);
    //         console.log(reader.result);
    //         img.setAttribute("id", "previewMedia");
    //         preview.appendChild(img);
    //         label.textContent='Preview Media';
    //     }

    //     reader.readAsDataURL(file);
    // });

    // $('#media').on({
    //     change:function(){
    //         console.log(event.target.files[0]);
    //         var file = event.target.files[0];
    //         var reader = new FileReader();
            
    //         if($('#previewMedia') != null){
    //             $('#previewMedia').remove();
    //         }

    //         reader.onload = function() {
    //             if(reader.result.match(/.*?\.mp4/i)){
    //                 createPreviewVideo(reader.result);
    //                 // console.log('aa');
    //             }else{
    //                 createPreviewImage(reader.result);
    //                 console.log(reader.result);
    //             }
    //             // var img = document.createElement("img");
    //             // img.setAttribute("src", reader.result);
    //             // img.setAttribute("id", "previewMedia");
    //             // preview.appendChild(img);
    //             // label.textContent='Preview Media';
    //         }
    
    //         reader.readAsDataURL(file);
    //     }
    // });

    // function createPreviewVideo(file_name)
    // {
    //     $('#preview').append('<video id="previewMedia"><source type="video/mp4"></video>');
    //     $('#previewMedia').children('source').attr('src',file_name);
    // }

    // function createPreviewImage(file_name)
    // {
    //     $('#preview').append('<img>');
    //     $('#preview').children('img').attr('id','previewMedia');
    //     $('#previewMedia').attr('src',file_name);
    // }

});
</script>
@yield('script')

</body>
</html>
