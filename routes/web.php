<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FacultyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

  // Profile Edit Route
Route::get('/admin/profile/edit', [ProfileController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin']) // Apply the admin middleware
    ->name('admin.profile.edit');


//////////////////////////////////////////////////////////    ADMIN    ////////////////////////////////////////////////////////////////

// Default dashboard route for "Admin"
Route::middleware(['auth', 'verified'])->group(function () {
  Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard'); // Admin dashboard
});

// Admin routes
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
  Route::get('/admindashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
  Route::get('/admin/profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
  Route::get('/admin/Submitted-Reports', [AdminController::class, 'submittedReports'])->name('admin.submitted-reports');
  Route::get('/admin/Clearances', [AdminController::class, 'clearances'])->name('admin.clearances');
  Route::get('/admin/Faculty', [AdminController::class, 'Faculty'])->name('admin.faculty');
  Route::get('/admin/Shared Files', [AdminController::class, 'sharedFiles'])->name('admin.shared-files');
  Route::get('/admin/My Files', [AdminController::class, 'myFiles'])->name('admin.my-files');
  // Content Controllers
  Route::get('/admin/faculty', [AdminController::class, 'manageFaculty'])->name('admin.faculty');
  Route::post('/admin/update-user', [AdminController::class, 'updateUser'])->name('admin.update-user');
  Route::post('/admin/update-clearance', [AdminController::class, 'updateClearance'])->name('admin.update-clearance');
  // Clearances Controllers
  Route::get('/admin/clearance-management', [AdminController::class, 'clearanceManagement'])->name('admin.clearance-management');
  //Route::post('/admin/clearance-management/add', [AdminController::class, 'addClearanceChecklist'])->name('admin.add-clearance-checklist');
  Route::post('/admin/clearance-management/update', [AdminController::class, 'updateClearanceChecklist'])->name('admin.update-clearance-checklist');
  Route::post('/admin/clearance-management/remove', [AdminController::class, 'removeClearanceChecklist'])->name('admin.remove-clearance-checklist');
  Route::get('/admin/clearance-checklist/{id}', [AdminController::class, 'getClearanceChecklist'])->name('admin.get-clearance-checklist');
  Route::post('/admin/send-checklist/{id}', [AdminController::class, 'sendChecklist'])->name('admin.send-checklist');
  Route::get('/admin/edit-clearance-checklist/{table}', [AdminController::class, 'editClearanceChecklist'])->name('admin.edit-clearance-checklist');

  Route::post('/admin/send-checklist', [AdminController::class, 'sendChecklist'])->name('admin.send-checklist');
  Route::get('/admin/clearance-management', [AdminController::class, 'clearanceManagement'])->name('admin.clearance-management');
  Route::post('/admin/add-clearance-checklist', [AdminController::class, 'addClearanceChecklist'])->name('admin.add-clearance-checklist');
  Route::get('/admin/edit-clearance-checklist/{table}', [AdminController::class, 'editClearanceChecklist'])->name('admin.edit-clearance-checklist');
  Route::post('/admin/update-clearance-checklist/{table}', [AdminController::class, 'updateClearanceChecklist'])->name('admin.update-clearance-checklist');
  Route::delete('/admin/delete-clearance-checklist/{table}', [AdminController::class, 'deleteClearanceChecklist'])->name('admin.delete-clearance-checklist');
  // Add other admin-specific routes here
});


//////////////////////////////////////////////////////////    FACULTY    ////////////////////////////////////////////////////////////////


// Normal user dashboard route
Route::middleware(['auth', 'verified', 'redirect.admin'])->group(function () {
  Route::get('/dashboard', [FacultyController::class, 'dashboard'])->name('dashboard'); // Normal user dashboard
});

// Faculty routes
Route::middleware(['auth', 'verified'])->group(function () {
  Route::get('/dashboard', [FacultyController::class, 'dashboard'])->name('dashboard');
  Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::get('/dashboard', [FacultyController::class, 'dashboard'])->name('dashboard');
  Route::get('/My-Files', [FacultyController::class, 'myFiles'])->name('myFiles');
  Route::get('/clearance', [FacultyController::class, 'clearances'])->name('clearance');
  Route::get('/Shared Files', [FacultyController::class, 'sharedFiles'])->name('sharedFiles');
  Route::get('/Submitted Reports', [FacultyController::class, 'submittedReports'])->name('submittedReports');
  Route::get('/Archive', [FacultyController::class, 'archive'])->name('archive');
  // Clearances Controllers
  Route::get('/faculty/clearance', [FacultyController::class, 'showClearancePage'])->name('faculty.clearance');
  Route::post('/upload-file/{requirementId}', [FacultyController::class, 'uploadFile'])->name('faculty.upload-file');
  // Add other faculty routes here
  Route::get('/faculty/test', [FacultyController::class, 'showTestPage'])->name('test');
});

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
