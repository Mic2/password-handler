@extends('layouts.app')

@section('content')

@if($barcode !== null && !empty($barcode))
    <!-- Two factor barcode -->
    <h2>Scan this with your google authenticator app</h2>
    <img src="{{ $barcode }}" />  
    <form action="/two-factor-enable" method="post">
        @csrf
        <!-- MAKE THE USER ENTER THE CODE OF THE AUTHENTICATOR BEFORE ITS ENABLED ! -->
        <input type="text" name="code" />
        <input type="submit" name="enable" class="btn btn-primary" value="Enable" />
    </form>
    <small>Remember to scan the barcode! when pressing this button, theres no turning back!</small>
@else 
    <h2>Two factor is already enabled</h2>
@endif

@endsection
