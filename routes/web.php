<?php

//use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

use App\Livewire\Master\UserIndex;
use App\Livewire\Master\CustomerIndex;
use App\Livewire\Manajemen\ProjectIndex;
use App\Livewire\Master\SupplierIndex;

use App\Livewire\Actions\Logout;
use App\Livewire\Master\VendorIndex;
use App\Models\Vendor;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', Welcome::class);

Route::view('/', 'welcome')->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/user', UserIndex::class)
        ->name('user-index');

    Route::get('/customer', CustomerIndex::class)
        ->name('customer-index');

    Route::get('/vendor', VendorIndex::class)
        ->name('vendor-index');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/project', ProjectIndex::class)
        ->name('project-index');
});

Route::get('/logout', [Logout::class, 'doLogout']);
require __DIR__ . '/auth.php';
