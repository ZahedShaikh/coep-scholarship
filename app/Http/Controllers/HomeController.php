<?php

namespace App\Http\Controllers;

use Auth;
use App\registeruser;
use Illuminate\Http\Request;

class HomeController extends Controller {

    public function __construct() {
        $this->middleware(['auth', 'verified']);
    }

    public function index() {
        $user = Auth::user();
        return view('home', compact('user'));
    }

}
