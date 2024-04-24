<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FriendRequestController;
use App\Models\FriendRequest;

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



Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthenticationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthenticationController::class, 'register']);
Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

// Password Reset Routes

Route::get('/forgetpassword', [PasswordResetController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('forgot.password.post');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('reset.password.post');



// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/edit', [AuthenticationController::class, 'EditProfileForm'])->name('edit.profile.get'); 
Route::post('/edit-profile',[AuthenticationController::class,'EditProfile'])->name('edit.profile.post');

//Search
Route::post('/search',[FriendRequestController::class,'SearchFriend'])->name('search');


// Friend Request
Route::get('/friendlist',[FriendRequestController::class ,'DisplayFriend'])->name('friendlist.get');
Route::post('/friendrequest',[FriendRequestController::class ,'SendRequest'])->name('friendrequest.post');
Route::get('/friendrequestslist', [FriendRequestController::class,'ShowFriendRequest'])->name('friend.requestslist');
Route::post('/friendrequestreject' , [FriendRequestController::class,'RejectFriendRequest'])->name('friendrequest.reject');
Route::post('/friendrequestaccept' , [FriendRequestController::class,'acceptFriendRequest'])->name('friendrequest.accept');



// Route to display the accepted friend requests page
Route::get('/accepted-friend-requests', [FriendRequestController::class, 'DisplayAcceptedFriend'])->name('accepted.friend.requests');

Route::get('/chat', [ChatController::class, 'index']) ->name('chat');
   

Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send.message');
Route::get('/fetch-messages', [ChatController::class, 'FetchMessage'])->name('fetch.messages');




