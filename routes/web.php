<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\PermissionController;

// ── Language switcher ───────────────────────────────────────────────────────
// Persists the chosen locale in the session and a 1-year cookie, then returns
// the visitor to the page they came from. Guarded against unsupported locales.
Route::get('/locale/{locale}', function (string $locale) {
    if (array_key_exists($locale, config('app.supported_locales', []))) {
        session(['locale' => $locale]);
        cookie()->queue(cookie('locale', $locale, 60 * 24 * 365)); // 1 year
    }

    return redirect()->back();
})->name('locale.switch');

// ── Public routes ──────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Properties
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property:slug}', [PropertyController::class, 'show'])->name('properties.show');

// Bookings
Route::get('/properties/{property:slug}/book', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/properties/{property:slug}/book', [BookingController::class, 'store'])->name('bookings.store');

// ── Auth ───────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Admin routes ───────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Properties
    Route::get('/properties', [AdminPropertyController::class, 'index'])->name('properties.index')->middleware('menu:properties');
    Route::get('/properties/create', [AdminPropertyController::class, 'create'])->name('properties.create')->middleware('menu:properties');
    Route::post('/properties', [AdminPropertyController::class, 'store'])->name('properties.store')->middleware('menu:properties');
    Route::get('/properties/{property}/edit', [AdminPropertyController::class, 'edit'])->name('properties.edit')->middleware('menu:properties');
    Route::put('/properties/{property}', [AdminPropertyController::class, 'update'])->name('properties.update')->middleware('menu:properties');
    Route::delete('/properties/{property}', [AdminPropertyController::class, 'destroy'])->name('properties.destroy')->middleware('menu:properties');
    Route::post('/properties/{property}/set-primary', [AdminPropertyController::class, 'setPrimary'])->name('properties.set-primary')->middleware('menu:properties');

    // Bookings
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index')->middleware('menu:bookings');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show')->middleware('menu:bookings');
    Route::put('/bookings/{booking}', [AdminBookingController::class, 'update'])->name('bookings.update')->middleware('menu:bookings');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index')->middleware('menu:categories');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store')->middleware('menu:categories');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update')->middleware('menu:categories');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('menu:categories');

    // Testimonials
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index')->middleware('menu:testimonials');
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store')->middleware('menu:testimonials');
    Route::put('/testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update')->middleware('menu:testimonials');
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy')->middleware('menu:testimonials');

    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index')->middleware('menu:messages');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show')->middleware('menu:messages');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy')->middleware('menu:messages');

    // Settings (CMS)
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index')->middleware('menu:settings');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update')->middleware('menu:settings');

    // Employees
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index')->middleware('menu:employees');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create')->middleware('menu:employees');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store')->middleware('menu:employees');
    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit')->middleware('menu:employees');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update')->middleware('menu:employees');
    Route::patch('/employees/{employee}/toggle-active', [EmployeeController::class, 'toggleActive'])->name('employees.toggle-active')->middleware('menu:employees');
    Route::patch('/employees/{employee}/reset-password', [EmployeeController::class, 'resetPassword'])->name('employees.reset-password')->middleware('menu:employees');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy')->middleware('menu:employees');

    // Permissions
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index')->middleware('menu:permissions');
    Route::put('/permissions', [PermissionController::class, 'update'])->name('permissions.update')->middleware('menu:permissions');
});
