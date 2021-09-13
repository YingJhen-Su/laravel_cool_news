@extends('/layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('header')
@include('layouts.header')
@endsection


@section('content')
@yield('content-part')
@endsection

@section('tags')
@include('layouts.tags')
@endsection