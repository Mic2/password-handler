<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/password-wrapper.css" />
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <title>PASSWORD HANDLER - Powered by Laravel</title>
    </head>
    <body>
           <!--
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            -->
            
        <div class="container-fluid">
            <div class="container-inner-wrapper">
                <div class="title m-b-md">
                    PASSWORD HANDLER - Powered by Laravel
                </div>
                <!-- Add new password -->
                <div id="password-add-wrapper" class="outer-box" >
                    <div class="password-form-wrapper" >
                        <form class="form-inline ajax-form" action="/store-password">
                            @csrf
                            <input type="text" name="password-assosiation-alias" class="form-control" placeholder="Username" />
                            <input type="password" name="password" class="form-control" placeholder="Password" />
                            <input type="submit" name="save-password" class="btn btn-primary" value="Save" />
                        </form>
                    </div>
                </div>

                <!-- Search password -->
                <div id="password-search-wrapper" class="outer-box" >
                    <form class="form-inline ajax-form">
                        @csrf
                        <input type="text" name="search-password" class="form-control" placeholder="Search" />
                        <input type="submit" name="search-password-submit" class="btn btn-primary" value="Search" />
                    </form>
                </div>

                <!-- Password list -->
                <h2>Saved passwords list</h2>
                <div id="password-list-wrapper" class="outer-box" >
                    <form class="form-inline ajax-form">
                        @csrf
                        <input type="text" name="password-assosiation-alias" class="form-control" placeholder="Username" readonly />
                        <input type="password" name="password" class="form-control" placeholder="Password" readonly />
                        <input type="submit" name="save-password" class="btn btn-primary" value="Edit" />
                    </form>
                </div>
            </div>
        </div>
    </body>

    <script src="/js/ui-form-ajax-handler.js"></script>
</html>
