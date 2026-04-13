<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $profiles = session('profiles', []);

    return view('index', compact('profiles'));
});

Route::post('/add-profile', function (Request $request) {
    $validated = $request->validate([
        'full_name' => ['required', 'string', 'max:255'],
        'age' => ['required', 'integer', 'min:1', 'max:150'],
        'program' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'gender' => ['required', 'in:Male,Female'],
        'hobbies' => ['required', 'array', 'min:1'],
        'hobbies.*' => ['string', 'max:100'],
        'biography' => ['required', 'string'],
    ]);

    $profiles = session('profiles', []);
    $profiles[] = $validated;

    session(['profiles' => $profiles]);

    return redirect('/');
});

Route::post('/clear-profiles', function () {
    session()->forget('profiles');

    return redirect('/');
});
