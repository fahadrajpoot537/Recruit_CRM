<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/admin/companies-user/manage', [UserController::class, 'manage'])->name('admin.companies.manage');
    Route::post('/update-user-status', [UserController::class, 'updateStatus'])->name('update.user.status');

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
});
Route::middleware(['auth', 'role:super-admin'])->group(function () {
    Route::get('/admin', function () {
        return 'Welcome Super Admin!';
    });
});

require __DIR__.'/auth.php';
