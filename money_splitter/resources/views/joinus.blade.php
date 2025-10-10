@extends('base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login_signup.css') }}">
@endsection

@section('content')

{{-- Flash / Messages --}}
@if(session('messages'))
<div class="container">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach(session('messages') as $message)
            <div class="alert @if(isset($message['tags'])) alert-{{ $message['tags'] }} @endif">{!! $message['message'] !!}</div>
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif

{{-- Validation Errors --}}
@if ($errors->any())
<div class="container">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif

{{-- Success Messages --}}
@if(session('success'))
<div class="container">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif

<div class="containers">
    <div class="forms-containers">
        <div class="signin-signup">
            {{-- Sign In Form --}}
            <form class="sign-in-form" action="{{ route('login.authenticate') }}" method="POST">
                @csrf
                <h2 class="title">Sign In</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" placeholder="Username" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <input type="submit" value="Login" class="btn solid" />
            </form>
        </div>
    </div>

    {{-- Left Panel --}}
    <div class="panels-containers">
        <div class="panel left-panel">
            <div class="content">
                <h3>New Here ?</h3>
                <p>Don't have an account on our website and want to enjoy the great time saving features? Just click the button below to signup</p>
                <a href="{{ url('/signup') }}" class="btn transparent">Sign Up</a>
            </div>
            <img src="{{ asset('images/login1.svg') }}" class="image" alt="">
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>

@endsection
