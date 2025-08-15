<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyUserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CvUploadController;
use App\Http\Controllers\ResumeParserController;
use App\Models\Contact;
use App\Models\User;

Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

// Route::get('auth/google', function () {
//     return Socialite::driver('google')->redirect();
// })->name('google.login');
// Route::get('auth/google/callback', function () {
//     $googleUser = Socialite::driver('google')->stateless()->user();

//     $user = User::updateOrCreate(
//         ['email' => $googleUser->getEmail()],
//         [
//             'name' => $googleUser->getName(),
//             'google_id' => $googleUser->getId(),
//             'avatar' => $googleUser->getAvatar(),
//             'password' => bcrypt('default_password'), // Optional
//         ]
//     );

//     Auth::login($user);

//     return redirect('/dashboard');
// });

Route::get('/', function () {
    return view('auth.login');
});

// CSRF token refresh route
Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
});

// Test route to check session and CSRF
Route::get('/test-session', function () {
    return response()->json([
        'session_id' => session()->getId(),
        'csrf_token' => csrf_token(),
        'user_authenticated' => auth()->check()
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admin/users/{id}/details', [UserController::class, 'details']);
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/admin/companies-user/manage', [UserController::class, 'manage'])->name('admin.companies.manage');
    Route::post('/update-user-status', [UserController::class, 'updateStatus'])->name('update.user.status');

    Route::get('/resume', [ResumeParserController::class, 'showForm'])->name('resume.form');
    Route::post('/resume/upload', [ResumeParserController::class, 'upload'])->name('resume.upload');
    Route::post('/resume/upload-multiple', [ResumeParserController::class, 'uploadMultiple'])->name('resume.upload.multiple');
    Route::get('/resume/view/{id}', [ResumeParserController::class, 'view'])->name('resume.view');
    Route::get('/resumes', [ResumeParserController::class, 'index'])->name('resume.index');
    Route::get('/cv/upload', [CvUploadController::class, 'index'])->name('cv.index');
    Route::post('/cv/upload', [CvUploadController::class, 'store'])->name('cv.store');

    // Optional: List all parsed CVs
    Route::get('/cv/list', [CvUploadController::class, 'list'])->name('cv.list');

    // Optional: View individual CV
    Route::get('/cv/{id}', [CvUploadController::class, 'show'])->name('cv.show');

    // Optional: Edit parsed CV data
    Route::get('/cv/{id}/edit', [CvUploadController::class, 'edit'])->name('cv.edit');
    Route::put('/cv/{id}', [CvUploadController::class, 'update'])->name('cv.update');

    // Optional: Delete CV
    Route::delete('/cv/{id}', [CvUploadController::class, 'destroy'])->name('cv.destroy');

    // Optional: Bulk operations
    Route::post('/cv/bulk-delete', [CvUploadController::class, 'bulkDelete'])->name('cv.bulk-delete');
    Route::post('/cv/bulk-export', [CvUploadController::class, 'bulkExport'])->name('cv.bulk-export');

    // Search and filter routes
    Route::get('/cv/search', [CvUploadController::class, 'search'])->name('cv.search');
    Route::post('/cv/filter', [CvUploadController::class, 'filter'])->name('cv.filter');

    Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/companies/create', [CompanyController::class, 'addcompany'])->name('companies.create');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
    Route::get('/companies/{company}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::put('/companies/{id}', [CompanyController::class, 'update'])->name('companies.update');
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/company-details/{company}', [CompanyController::class, 'show'])->name('companies.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //companies's users
    Route::get('/company_users', [CompanyUserController::class, 'index'])->name('companies.users');
    Route::get('/companies_users/create', [CompanyUserController::class, 'create'])->name('companies.users.create');
    Route::post('/companies_users', [CompanyUserController::class, 'store'])->name('companies.users.store');
    Route::get('/companies_users/edit', [CompanyUserController::class, 'edit'])->name('companies.users.edit');
    Route::put('/companies_users/{id}', [CompanyUserController::class, 'update'])->name('companies.users.update');
    Route::delete('/companies_users/delete/{id}', [CompanyUserController::class, 'destroy'])->name('companies.users.destroy');
    Route::put('/companies_users/update-status/{id}', [CompanyUserController::class, 'updateStatus'])->name('companies.users.update.status');

    //jobs controller
    Route::prefix('jobs')->controller(JobController::class)->group(function () {
        Route::get('/', 'index')->name('jobs.index');
        Route::get('/create', 'create')->name('jobs.create');
        Route::post('/', 'store')->name('jobs.store');
        Route::get('/{id}/edit', 'edit')->name('jobs.edit');
        Route::put('/{id}', 'update')->name('jobs.update');
        Route::delete('/{id}', 'destroy')->name('jobs.destroy');
        Route::post('/bulk-delete', 'bulkDestroy')->name('jobs.bulk-destroy');
    });
    //cont controller
    Route::prefix('contact')->controller(ContactController::class)->group(function () {
        Route::get('/', 'index')->name('contact.index');
        Route::get('/create', 'create')->name('contact.create');
        Route::post('/', 'store')->name('contact.store');
        Route::get('/edit/{id}', 'edit')->name('contact.edit');
        Route::put('/{id}', 'update')->name('contact.update');
        Route::delete('/{id}', 'destroy')->name('contact.destroy');
        Route::get('/get-contacts-by-company', 'getContactsByCompany')->name('contact.getContactsByCompany');
    });
});
Route::middleware(['auth', 'role:super-admin'])->group(function () {
    Route::get('/admin', function () {
        return 'Welcome Super Admin!';
    });
});

require __DIR__ . '/auth.php';
