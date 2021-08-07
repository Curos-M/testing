<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;

class AuthController extends Controller
{
  public function index(Request $request)
	{
		if (Auth::check()){
			return redirect('/');
		}
		
		return view('authentication.login');
	}

	public function postLogin(Request $request)
	{
		// Redirects to home if the user is already logged into the application.
		if (Auth::check()){
			return redirect('/');
		}
		
		$request->validate([
			'username' => 'required|max:100',
			'password' => 'required|max:100'
		]);

		$ingat = $request->remember ? true : false;
		$masuk = $request->only('username', 'password');
		if (!Auth::attempt($masuk, $ingat)){
			$request->session()->flash('errorLogin', 'Username atau Password Salah');
			return redirect()->back()
				->withInput($request->except('password'));
		};
		// $request->session()->put('username', Auth::user()->getUserName());
		// $request->session()->put('userid', Auth::user()->getAuthIdentifier());
		return redirect()->intended(); 
	}
		
	public function logout(Request $request)
	{
		$request->session()->flush();
		Auth::logout();
		return redirect('/');
	}
}
