@extends('layouts.app')

@section('content')
    <div class="d-flex" style="background-color: #F8F9FA">
        <!-- sidebar start -->
        @include('components.sidebar')
        <!-- sidebar end -->

        <!-- main start -->
        <div class="me-4 mb-4 px-5 py-5 ms-4 shadow mt-3" style="background-color: white; width: 85%; border-radius: 10px;">
            @yield('container')
        </div>
        <!-- main end -->
    </div>
@endsection

@section('scripts')
@yield('scripts')
@endsection
