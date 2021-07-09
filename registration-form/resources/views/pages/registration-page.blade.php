@extends('layouts.app')

@section('content')
    <form action="{{ route('register') }}" method="post">
        @csrf
        <label for="FirstName">First Name:</label>
        <input type="text" name="FirstName" id="FirstName"><br>
        @error('FirstName')
            {{ $message }}<br>
        @enderror

        <label for="LastName">Last Name:</label>
        <input type="text" name="LastName" id="LastName"><br>
        @error('LastName')
            {{ $message }}<br>
        @enderror

        <label for="PersonalNumber">Perosnal Number:</label>
        <input type="text" name="PersonalNumber" id="PersonalNumber"><br>
        @error('PersonalNumber')
            {{ $message }}<br>
        @enderror

        <label for="Email">Email:</label>
        <input type="text" name="Email" id="Email"><br>
        @error('Email')
            {{ $message }}<br>
        @enderror

        <label for="Password">Password:</label>
        <input type="password" name="Password" id="Password"><br>
        @error('Password')
            {{ $message }}<br>
        @enderror

        <input type="submit">
    </form>
    @if (session()->has('notification'))
        {{ session('notification') }}
        @if (session('notification') == 'Registration successful, verification email has been sent')
            <a href="{{ route('resend') }}">Click here to resend the activation link</a>
        @endif
    @endif

@endsection
