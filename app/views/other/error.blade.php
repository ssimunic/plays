@extends('layouts.master')
@section('content')
<h1>Error Code: {{ $code }}</h1>
<hr>
Something went wrong. Read <a href="/faq?errors">FAQ</a> ?
@stop