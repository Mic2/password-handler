@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <!-- Add new password -->
                    <div id="password-add-wrapper" class="outer-box" >
                        <div class="password-form-wrapper" >
                            <form class="form-inline ajax-form" action="/store-password">
                                @csrf
                                <input type="text" name="username" class="form-control" placeholder="Username" />
                                <input type="password" name="password" class="form-control" placeholder="Password" />
                                <input type="text" name="password-assosiation-alias" class="form-control" placeholder="App name" />
                                <input type="submit" name="save-password" class="btn btn-primary" value="Save" />
                            </form>
                        </div>
                    </div>
                    <p>Leave password empty if you want us to generate a strong password for you</p>

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
                        @foreach ($data as $stored_password_information) 
                            <form class="form-inline ajax-form" action="/get-password">
                                @csrf
                                <input type="text" name="username" class="form-control" placeholder="Username" value="{{ $stored_password_information->username }}" readonly />
                                <input type="password" name="password" class="form-control" placeholder="Password" value="{{ $stored_password_information->stored_password }}" readonly />
                                <input type="text" name="password-assosiation-alias" class="form-control" placeholder="App name" value="{{ $stored_password_information->password_assosiation_alias }}" readonly />
                                <input type="submit" name="copy-password" class="btn btn-primary" value="copy to clipboard" />
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
