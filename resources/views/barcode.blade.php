@extends('layouts.app')

@section('content')

<!-- Two factor barcode -->
<h2>Scan this with your google authenticator app</h2>
<img src="{{ $barcode }}" />  

@endsection
