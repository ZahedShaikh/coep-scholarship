<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('accountant')->user();

    //dd($users);

    return view('accountant.home');
})->name('home');

