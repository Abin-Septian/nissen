<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth
Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm')->middleware('guest');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login')->middleware('guest');
Route::post('logout')->name('logout')->uses('Auth\LoginController@logout');

// Dashboard
Route::get('/')->name('dashboard')->uses('DashboardController')->middleware('auth');

// Users
Route::get('users')->name('users')->uses('UsersController@index')->middleware('remember', 'auth');
Route::get('users/create')->name('users.create')->uses('UsersController@create')->middleware('auth');
Route::post('users')->name('users.store')->uses('UsersController@store')->middleware('auth');
Route::get('users/{user}/edit')->name('users.edit')->uses('UsersController@edit')->middleware('auth');
Route::put('users/{user}')->name('users.update')->uses('UsersController@update')->middleware('auth');
Route::delete('users/{user}')->name('users.destroy')->uses('UsersController@destroy')->middleware('auth');
Route::put('users/{user}/restore')->name('users.restore')->uses('UsersController@restore')->middleware('auth');

// Images
Route::get('/img/{path}', 'ImagesController@show')->where('path', '.*');

// Organizations
Route::get('organizations')->name('organizations')->uses('OrganizationsController@index')->middleware('remember', 'auth');
Route::get('organizations/create')->name('organizations.create')->uses('OrganizationsController@create')->middleware('auth');
Route::post('organizations')->name('organizations.store')->uses('OrganizationsController@store')->middleware('auth');
Route::get('organizations/{organization}/edit')->name('organizations.edit')->uses('OrganizationsController@edit')->middleware('auth');
Route::put('organizations/{organization}')->name('organizations.update')->uses('OrganizationsController@update')->middleware('auth');
Route::delete('organizations/{organization}')->name('organizations.destroy')->uses('OrganizationsController@destroy')->middleware('auth');
Route::put('organizations/{organization}/restore')->name('organizations.restore')->uses('OrganizationsController@restore')->middleware('auth');

// Departmens
Route::get('departments')->name('departments')->uses('DepartmentsController@index')->middleware('remember', 'auth');
Route::get('departments/create')->name('departments.create')->uses('DepartmentsController@create')->middleware('auth');
Route::post('departments')->name('departments.store')->uses('DepartmentsController@store')->middleware('auth');
Route::get('departments/{department}/edit')->name('departments.edit')->uses('DepartmentsController@edit')->middleware('auth');
Route::put('departments/{department}')->name('departments.update')->uses('DepartmentsController@update')->middleware('auth');
Route::delete('departments/{department}')->name('departments.destroy')->uses('DepartmentsController@destroy')->middleware('auth');
Route::put('departments/{department}/restore')->name('departments.restore')->uses('DepartmentsController@restore')->middleware('auth');

// Section
Route::get('sections')->name('sections')->uses('SectionsController@index')->middleware('remember', 'auth');
Route::get('sections/create')->name('sections.create')->uses('SectionsController@create')->middleware('auth');
Route::post('sections')->name('sections.store')->uses('SectionsController@store')->middleware('auth');
Route::get('sections/{section}/edit')->name('sections.edit')->uses('SectionsController@edit')->middleware('auth');
Route::put('sections/{section}')->name('sections.update')->uses('SectionsController@update')->middleware('auth');
Route::delete('sections/{section}')->name('sections.destroy')->uses('SectionsController@destroy')->middleware('auth');
Route::put('sections/{section}/restore')->name('sections.restore')->uses('SectionsController@restore')->middleware('auth');

// Position
Route::get('positions')->name('positions')->uses('PositionsController@index')->middleware('remember', 'auth');
Route::get('positions/create')->name('positions.create')->uses('PositionsController@create')->middleware('auth');
Route::post('positions')->name('positions.store')->uses('PositionsController@store')->middleware('auth');
Route::get('positions/{position}/edit')->name('positions.edit')->uses('PositionsController@edit')->middleware('auth');
Route::put('positions/{position}')->name('positions.update')->uses('PositionsController@update')->middleware('auth');
Route::delete('positions/{position}')->name('positions.destroy')->uses('PositionsController@destroy')->middleware('auth');
Route::put('positions/{position}/restore')->name('positions.restore')->uses('PositionsController@restore')->middleware('auth');

// Contacts
Route::get('contacts')->name('contacts')->uses('ContactsController@index')->middleware('remember', 'auth');
Route::get('contacts/create')->name('contacts.create')->uses('ContactsController@create')->middleware('auth');
Route::post('contacts')->name('contacts.store')->uses('ContactsController@store')->middleware('auth');
Route::get('contacts/{contact}/edit')->name('contacts.edit')->uses('ContactsController@edit')->middleware('auth');
Route::put('contacts/{contact}')->name('contacts.update')->uses('ContactsController@update')->middleware('auth');
Route::delete('contacts/{contact}')->name('contacts.destroy')->uses('ContactsController@destroy')->middleware('auth');
Route::put('contacts/{contact}/restore')->name('contacts.restore')->uses('ContactsController@restore')->middleware('auth');

// Employees
Route::get('employees')->name('employees')->uses('EmployeesController@index')->middleware('remember', 'auth');
Route::get('employees/create')->name('employees.create')->uses('EmployeesController@create')->middleware('auth');
Route::post('employees')->name('employees.store')->uses('EmployeesController@store')->middleware('auth');
Route::get('employees/{employee}/edit')->name('employees.edit')->uses('EmployeesController@edit')->middleware('auth');
Route::put('employees/{employee}')->name('employees.update')->uses('EmployeesController@update')->middleware('auth');
Route::delete('employees/{employee}')->name('employees.destroy')->uses('EmployeesController@destroy')->middleware('auth');
Route::put('employees/{employee}/restore')->name('employees.restore')->uses('EmployeesController@restore')->middleware('auth');

// Trainings
Route::get('trainings')->name('trainings')->uses('TrainingsController@index')->middleware('remember', 'auth');
Route::get('trainings/create')->name('trainings.create')->uses('TrainingsController@create')->middleware('auth');
Route::post('trainings')->name('trainings.store')->uses('TrainingsController@store')->middleware('auth');
Route::get('trainings/{training}/edit')->name('trainings.edit')->uses('TrainingsController@edit')->middleware('auth');
Route::put('trainings/{training}')->name('trainings.update')->uses('TrainingsController@update')->middleware('auth');
Route::delete('trainings/{training}')->name('trainings.destroy')->uses('TrainingsController@destroy')->middleware('auth');
Route::put('trainings/{training}/restore')->name('trainings.restore')->uses('TrainingsController@restore')->middleware('auth');

// Trainings List
Route::get('training_list')->name('training_list')->uses('TrainingListController@index')->middleware('remember', 'auth');
Route::get('training_list/{training}')->name('training_list.show')->uses('TrainingListController@show')->middleware('auth');

// Training Record
Route::get('training_record')->name('training_record')->uses('TrainingRecordController@index')->middleware('remember', 'auth');
Route::get('training_record/{employee}')->name('training_record.show')->uses('TrainingRecordController@show')->middleware('auth');

// Reports
//Route::get('reports')->name('reports')->uses('ReportController')->middleware('auth');

// 500 error
Route::get('500', function () {
    // Force debug mode for this endpoint in the demo environment
    if (App::environment('demo')) {
        Config::set('app.debug', true);
    }

    echo $fail;
});
