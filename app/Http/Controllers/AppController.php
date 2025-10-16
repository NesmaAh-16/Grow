<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{

    public function index (){
        return view('index');
    }
    //public function logo (){
    //    return view('index');
    //}
    //public function showLogin() {
    //    return view('login');
   // }

    /*public function showRegister() {
        return view('register');
    }*/

    public function logout() {
        return view('logout');
    }
    //

}
