<?php

use App\Http\Controllers\Admin\ContentDescriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LogoutController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SiteMapController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProductController;

Route::group(
    ['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']],
    function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('profile', [UserController::class, 'profile'])->name('profile');
        Route::put('profile', [UserController::class, 'updateProfile'])->name('profile.update');
        Route::post('users/storeMedia', [UserController::class, 'storeMedia'])->name('users.storeMedia');
        Route::post('users/removeMedia', [UserController::class, 'removeMedia'])->name('users.removeMedia');
        Route::post('users/change-status', [UserController::class, 'changeStatus'])->name('change.user.status');

        Route::resource('users', UserController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('menus', MenuController::class);
        Route::post('abouts/storeMedia', [AboutController::class, 'storeMedia'])->name('abouts.storeMedia');
        Route::post('abouts/removeMedia', [AboutController::class, 'removeMedia'])->name('abouts.removeMedia');
        Route::resource('abouts', AboutController::class);
        Route::post('services/storeMedia', [ServiceController::class, 'storeMedia'])->name('services.storeMedia');
        Route::post('services/removeMedia', [ServiceController::class, 'removeMedia'])->name('services.removeMedia');
        Route::resource('services', ServiceController::class);
        Route::post('products/storeMedia', [ProductController::class, 'storeMedia'])->name('products.storeMedia');
        Route::post('products/removeMedia', [ProductController::class, 'removeMedia'])->name('products.removeMedia');
        Route::post('products/change-status', [ProductController::class, 'changeStatus'])->name('change.product.status');
        Route::resource('products', ProductController::class);

        Route::post('contentdescriptions/storeMedia', [ContentDescriptionController::class, 'storeMedia'])->name('contentdescriptions.storeMedia');
        Route::post('contentdescriptions/removeMedia', [ContentDescriptionController::class, 'removeMedia'])->name('contentdescriptions.removeMedia');
        Route::resource('contentdescriptions', ContentDescriptionController::class);
        Route::resource('sitemap', SitemapController::class);
        Route::get('sections', [SectionController::class, 'index'])->name('sections.index');
        Route::get('sections/{section}', [SectionController::class, 'show'])->name('sections.show');
        Route::post('settings/destroy', [SettingController::class, 'destroy'])->name('settings.destroy');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    }
);
