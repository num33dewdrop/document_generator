<?php

use App\Http\Routes\Route;
//外部サービスからのアクセス

// Google
// ログイン
Route::get('/user/login/redirect', 'GoogleController@login')->name('user-redirect.store');