@extends('layouts.app')
@section('page_title', '404 Page Not Found')


@section('content')

    <div class="error-page pt-5">
        <h2 class="headline text-warning"> 404</h2>
        <div class="error-content">
            <h2><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h2>
            <p class="pt-3">
                We could not find the page you were looking for.
                Meanwhile, you may <a href="dashboard">return to dashboard</a> or enter correct input.
            </p>
        </div>
    </div>

@endsection