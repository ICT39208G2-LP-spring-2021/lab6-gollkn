@extends('layouts.app')

@section('content')
    <p>You have {{session('resend-attempts')}} attempts remaining</p>
    <form action=" {{ route('resendB') }}" method="get">
        <input type="submit" value="Submit">
    </form>
    @if (session()->has('verification-notification'))
        {{ session('verification-notification') }}
    @endif


@endsection
