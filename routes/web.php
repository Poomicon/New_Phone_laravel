<?php
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () { //เส้นทางหน้าแรก
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'), // สำหรับเข้าสู่ระบบ
        'canRegister' => Route::has('register'), //สำหรับลงทะเบียน 
        'laravelVersion' => Application::VERSION, //เวอร์ชันของ Laravel.
        'phpVersion' => PHP_VERSION, // เวอร์ชันของ PHP
    ]);
});
Route::get('/greeting', function () {
    return 'Hello World';
});
Route::get('/user', [UserController::class, 'index'])->name("csmju");
Route::get('/user/{id}', function (string $id) { //userกับเลขID
    return 'User '.$id;
});
Route::get('/users/{user}', [UserController::class, 'show']);

Route::get('/products', [ProductController::class, 'index'])->middleware(['auth', 'verified'])->name('products.index'); //เข้าที่หน้าindexของproductเเต่ผ่านmiddleware ก่อน
Route::get('/products/{id}', [ProductController::class, 'show']); // /products ตามด้วย id ในเว็ป จะขึ้นเลข id ของ product

Route::get('/dashboard', function () { 
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); //ผู้ใช้ต้องเข้าสู่ระบบก่อนเข้าถึงเเล้วแสดงหน้า Dashboard

Route::middleware('auth')->group(function () { //ผู้ใช้ต้องเข้าสู่ระบบก่อนเข้าถึง
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); //เปิดหน้าแก้ไขโปรไฟล์
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); //อัปเดตข้อมูลโปรไฟล์
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); //ลบโปรไฟล์ผู้ใช้
});
Route::resource('chirps', ChirpController::class) // ใช้จัดการกับ Chirps โดยเรียกใช้งาน ChirpController
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']); // ผู้ใช้ต้องเข้าสู่ระบบ,ผู้ใช้ต้องยืนยันอีเมล.

require __DIR__.'/auth.php';
