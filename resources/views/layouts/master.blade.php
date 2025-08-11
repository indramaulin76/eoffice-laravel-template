@extends('layouts.app')

@section('content')
    <div class="d-flex" style="background-color: #F8F9FA">
        <!-- sidebar start -->
        @include('components.sidebar')
        <!-- sidebar end -->

        <!-- main start -->
        @yield('container')
        <!-- main end -->
    </div>
@endsection
