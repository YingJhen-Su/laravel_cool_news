@extends('/layouts.app')

@section('nav')
@include('layouts.admin.nav')
@endsection

@section('header')
@include('layouts.header')
@endsection


@section('content')
@yield('content-part')
@endsection
