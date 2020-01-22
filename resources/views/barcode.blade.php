@extends('layouts.app')

@section('content')

@if($barcode !== null && !empty($barcode))
<!-- Two factor barcode -->
<h2>Scan this with your google authenticator app</h2>
<img src="{{ $barcode }}" />  
<button action="/two-factor-enable">Enable two factor</button>
<small>Remember to scan the barcode! when pressing this button, theres no turning back!</small>

@else 
<h2>Two factor is already enabled</h2>
@endif



@endsection
