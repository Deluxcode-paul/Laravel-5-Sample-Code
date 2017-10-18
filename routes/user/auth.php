<?php

Route::group(['namespace' => 'Frontend\User\Auth'], function () {
    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::get('/logout', 'LoginController@logout');
    // Registration Routes...
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register');
    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('forgot_password');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('send_forgot_password_email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('reset_password');
    Route::get('verify/email/{confirmation}', 'EmailConfirmation')->name('email_confirmation');
});
