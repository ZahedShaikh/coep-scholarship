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
Route::get('/getNewApplications', 'newApplicationsController@index')->name('getNewApplications');
Route::get('/showApplicants', 'newApplicationsController@show')->name('showApplicants');
Route::get('/assignScholarships/', 'newApplicationsController@accept')->name('assignScholarships');
Route::get('/rejectAllNewApplications', 'newApplicationsController@reject')->name('rejectAllNewApplications');

//  Send Sacntion amount to Account department for monry transfer
Route::get('/getSanctionAmount', 'sanctionAmountController@index')->name('getSanctionAmount');
Route::get('/showSanctionAmount', 'sanctionAmountController@show')->name('showSanctionAmount');
Route::get('/sendSanctionAmount', 'sanctionAmountController@send')->name('sendSanctionAmount');
Route::get('/sanctionAllApplications', 'sanctionAmountController@sanction')->name('sanctionAllApplications');


//  Here Accountant will credit all amount to stduents account
Route::get('/getAmountToBeCredit', 'accountantController@index')->name('getAmountToBeCredit');
Route::get('/showAmountToBeCredit', 'accountantController@show')->name('showAmountToBeCredit');
Route::get('/creditAmountToBank', 'accountantController@send')->name('creditAmountToBank');
Route::get('/creditEveryoneAmountToBank', 'accountantController@sanction')->name('creditEveryoneAmountToBank');

//  Here Accountant will credit all amount to stduents account
Route::get('/getAllStudentsDetails', 'displayAllStudentsDetails@index')->name('getAllStudentsDetails');
Route::get('/showAllStudentsDetails', 'displayAllStudentsDetails@show')->name('showAllStudentsDetails');


/*
 *  Temp URL to be remove later
 */


Route::get('/chart', 'Charts@index')->name('chart');

//Route::get('chart', function(){
//    $chart = new LarapexChart();
//    $chart->setTitle('Users')->setXAxis(['Active', 'Guests'])->setDataset([100, 200]);
//});




Route::resource('ajax-crud', 'AjaxController');
//https://www.tutsmake.com/laravel-5-7-create-first-ajax-crud-application/
Route::get('/live_search', 'LiveSearch@index')->name('live_search');
Route::get('/live_search/action', 'LiveSearch@action')->name('live_search.action');
//https://www.webslesson.info/2018/04/live-search-in-laravel-using-ajax.html