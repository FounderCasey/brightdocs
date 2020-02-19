@extends('layouts.static')

@section('content')
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title m-b-md">
            Sign Up
        </div>
        <form action="/createTenant" method="post">
          @csrf
            <input type="text" name="name" id="name" placeholder="Your Name" value="{{ old('name') }}">
            <input type="email" name="email" id="email" placeholder="Your Email" value="{{ old('email') }}">
            <input type="password" name="password" id="password" placeholder="Your Password" value="{{ old('password') }}">
            <input type="text" name="company" id="company" placeholder="Your Company" value="{{ old('company') }}">
            <button type="submit">{{ __('Sign Up') }}</button>
        </form>
    </div>
</div>
@endsection