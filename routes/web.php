<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
Route::get('/profile/edit', [App\Http\Controllers\HomeController::class, 'profileEdit'])->name('profile.edit');
Route::put('/profile/update', [App\Http\Controllers\HomeController::class, 'profileUpdate'])->name('profile.update');
Route::get('/profile/changepassword', [App\Http\Controllers\HomeController::class, 'changePasswordForm'])->name('profile.change.password');
Route::post('/profile/changepassword', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('profile.changepassword');

// Routes for Admin
Route::group(['middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/roles-permissions', [App\Http\Controllers\RolePermissionController::class, 'roles'])->name('roles-permissions');
    Route::get('/role-create', [App\Http\Controllers\RolePermissionController::class, 'createRole'])->name('role.create');
    Route::post('/role-store', [App\Http\Controllers\RolePermissionController::class, 'storeRole'])->name('role.store');
    Route::get('/role-edit/{id}', [App\Http\Controllers\RolePermissionController::class, 'editRole'])->name('role.edit');
    Route::put('/role-update/{id}', [App\Http\Controllers\RolePermissionController::class, 'updateRole'])->name('role.update');

    Route::get('/permission-create', [App\Http\Controllers\RolePermissionController::class, 'createPermission'])->name('permission.create');
    Route::post('/permission-store', [App\Http\Controllers\RolePermissionController::class, 'storePermission'])->name('permission.store');
    Route::get('/permission-edit/{id}', [App\Http\Controllers\RolePermissionController::class, 'editPermission'])->name('permission.edit');
    Route::put('/permission-update/{id}', [App\Http\Controllers\RolePermissionController::class, 'updatePermission'])->name('permission.update');

    Route::get('assign-subject-to-class/{id}', [App\Http\Controllers\GradeController::class, 'assignSubject'])->name('class.assign.subject');
    Route::post('assign-subject-to-class/{id}', [App\Http\Controllers\GradeController::class, 'storeAssignedSubject'])->name('store.class.assign.subject');

    Route::resource('assignrole', App\Http\Controllers\RoleAssignController::class);
    Route::resource('classes', App\Http\Controllers\GradeController::class);
    Route::resource('subject', App\Http\Controllers\SubjectController::class);
    Route::resource('teacher', App\Http\Controllers\TeacherController::class);
    Route::resource('parents', App\Http\Controllers\ParentsController::class);
    Route::resource('student', App\Http\Controllers\StudentController::class);
    Route::get('attendance', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
});

// Routes for Teacher
Route::group(['middleware' => ['auth', 'role:Teacher']], function () {
    Route::post('attendance', [App\Http\Controllers\AttendanceController::class, 'store'])->name('teacher.attendance.store');
    Route::get('attendance-create/{classid}', [App\Http\Controllers\AttendanceController::class, 'createByTeacher'])->name('teacher.attendance.create');
});

// Routes for Parent
Route::group(['middleware' => ['auth', 'role:Parent']], function () {
    Route::get('attendance/{attendance}', [App\Http\Controllers\AttendanceController::class, 'show'])->name('attendance.show');
});

// Routes for Student
Route::group(['middleware' => ['auth', 'role:Student']], function () {
    // Add student-specific routes here if needed
});
