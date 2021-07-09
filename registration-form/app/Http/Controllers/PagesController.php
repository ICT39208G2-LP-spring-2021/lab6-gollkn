<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class PagesController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function register()
    {
        return view('pages.registration-page');
    }

    public function addUser(Request $request)
    {
        $token = uniqid();
        $this->validate($request, [
            'FirstName' => 'required',
            'LastName' => 'required',
            'PersonalNumber' => 'required|unique:users,PersonalNumber',
            'Email' => 'required|email|unique:users,Email',
            'Password' => 'required'
        ]);


        User::create([
            'FirstName' => $request->FirstName,
            'LastName' => $request->LastName,
            'PersonalNumber' => $request->PersonalNumber,
            'Email' => $request->Email,
            'Password' => Hash::make($request->Password),
            'StatusId' => '0',
            'remember_token' => $token
        ]);
        session(['token' => $token]);
        session(['email' => $request->Email]);

        MailController::sendVerificationEmail($request->Email, $request->_token);
        $request->session()->flash('notification', 'Registration successful, verification email has been sent');
        session(['resend-attempts' => 4]);
        return redirect()->route('register');
    }
    
    public function login(){
        return view('pages.login');
    }

    // public function loginAuth(Request $request){
    //     $this -> validate($request, [
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     Auth::attempt($request->only('email', 'password'));

    //     return redirect()->route('homepage');
    // }
}
