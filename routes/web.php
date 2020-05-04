<?php

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

/*  User Page   
 */
// Update Marks
Route::get('/marks', 'semesterController@edit')->name('marks');
Route::post('/marksupdate', 'semesterController@update')->name('marksupdate');
// Update Bank
Route::get('/banks', 'BankUserController@edit')->name('banks');
Route::post('/bankupdate', 'BankUserController@update')->name('bankupdate');
// Update user Info
Route::get('/updateuserinfo', 'userupdateController@edit')->name('updateuserinfo');
Route::post('/myuserupdate', 'userupdateController@update')->name('myuserupdate');
// Print user profile
Route::get('/profileprint', 'ProfilePrintController@show')->name('profileprint');



/*  Admin Page
 */

//  newApplications
Route::get('/getNewApplications', 'Admin\newApplicationsController@index')->name('getNewApplications');
Route::get('/showApplicants', 'Admin\newApplicationsController@show')->name('showApplicants');
Route::get('/assignScholarships/', 'Admin\newApplicationsController@accept')->name('assignScholarships');
Route::get('/rejectAllNewApplications', 'Admin\newApplicationsController@reject')->name('rejectAllNewApplications');

//  Send Sacntion amount to Account department for monry transfer
Route::get('/getSanctionAmount', 'Admin\sanctionAmountController@index')->name('getSanctionAmount');
Route::get('/showSanctionAmount', 'Admin\sanctionAmountController@show')->name('showSanctionAmount');
Route::get('/sendSanctionAmount', 'Admin\sanctionAmountController@send')->name('sendSanctionAmount');
Route::get('/sanctionAllApplications', 'Admin\sanctionAmountController@sanction')->name('sanctionAllApplications');


//  Here Accountant will credit all amount to stduents account
Route::get('/getAmountToBeCredit', 'Accountant\accountantController@index')->name('getAmountToBeCredit');
Route::get('/showAmountToBeCredit', 'Accountant\accountantController@show')->name('showAmountToBeCredit');
Route::get('/creditAmountToBank', 'Accountant\accountantController@send')->name('creditAmountToBank');
Route::get('/creditEveryoneAmountToBank', 'Accountant\accountantController@sanction')->name('creditEveryoneAmountToBank');

//  Here Accountant will credit all amount to stduents account
Route::get('/getAllStudentsDetails', 'displayAllStudentsDetails@index')->name('getAllStudentsDetails');
Route::get('/showAllStudentsDetails', 'displayAllStudentsDetails@show')->name('showAllStudentsDetails');

Route::get('/charts', 'Charts@index')->name('charts');


// MultiAuth Routes
//https://www.webslesson.info/2018/04/live-search-in-laravel-using-ajax.html
Route::group(['prefix' => 'admin'], function () {
  Route::get('/', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Admin\Auth\LoginController@login');
  Route::post('/logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');

  Route::get('/register', 'Admin\Auth\RegisterController@showRegistrationForm')->name('admin.register');
  Route::post('/register', 'Admin\Auth\RegisterController@register');

  Route::post('/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.request');
  Route::post('/password/reset', 'Admin\Auth\ResetPasswordController@reset')->name('admin.password.email');
  Route::get('/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.reset');
  Route::get('/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'accountant'], function () {
  Route::get('/login', 'Accountant\Auth\LoginController@showLoginForm')->name('accountant.login');
  Route::post('/login', 'Accountant\Auth\LoginController@login');
  Route::post('/logout', 'Accountant\Auth\LoginController@logout')->name('accountant.logout');

  Route::get('/register', 'Accountant\Auth\RegisterController@showRegistrationForm')->name('accountant.register');
  Route::post('/register', 'Accountant\Auth\RegisterController@register');

  Route::post('/password/email', 'Accountant\Auth\ForgotPasswordController@sendResetLinkEmail')->name('accountant.password.request');
  Route::post('/password/reset', 'Accountant\Auth\ResetPasswordController@reset')->name('accountant.password.email');
  Route::get('/password/reset', 'Accountant\Auth\ForgotPasswordController@showLinkRequestForm')->name('accountant.password.reset');
  Route::get('/password/reset/{token}', 'Accountant\Auth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'vendor'], function () {
  Route::get('/login', 'Vendor\Auth\LoginController@showLoginForm')->name('vendor.login');
  Route::post('/login', 'Vendor\Auth\LoginController@login');
  Route::post('/logout', 'Vendor\Auth\LoginController@logout')->name('vendor.logout');

  Route::get('/register', 'Vendor\Auth\RegisterController@showRegistrationForm')->name('vendor.register');
  Route::post('/register', 'Vendor\Auth\RegisterController@register');

  Route::post('/password/email', 'Vendor\Auth\ForgotPasswordController@sendResetLinkEmail')->name('vendor.password.request');
  Route::post('/password/reset', 'Vendor\Auth\ResetPasswordController@reset')->name('vendor.password.email');
  Route::get('/password/reset', 'Vendor\Auth\ForgotPasswordController@showLinkRequestForm')->name('vendor.password.reset');
  Route::get('/password/reset/{token}', 'Vendor\Auth\ResetPasswordController@showResetForm');
});
