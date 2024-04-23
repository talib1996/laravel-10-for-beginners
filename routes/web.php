<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Profile\AvatarController;
use OpenAI\Laravel\Facades\OpenAI;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\TicketController;

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
    // dd("Allah!");
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('avatar.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/testopenai', function(){

    $result = OpenAI::chat()->create([
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'user', 'content' => 'Hello!'],
        ],
    ]);
    
    echo $result->choices[0]->message->content; // Hello! How can I assist you today?
});


require __DIR__.'/auth.php';

Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('login.github');
 
Route::get('/auth/callback', function () {

    if (Storage::disk('public')->exists('avatars')) {
        // There is already an image in the 'avatars' directory
        // You can perform further actions here if needed
        $directory = 'avatars/';

        // Get all files in the 'avatars' directory
        $files = Storage::disk('public')->files($directory);

        foreach ($files as $file) {
            Storage::disk('public')->delete($file);
        }
            }
    $user = Socialite::driver('github')->user();
    // dd($user->avatar);

       // Fetch the avatar image from GitHub
    $avatarContents = file_get_contents($user->avatar);
    $avatarName = basename($user->avatar);
    $tmpFilePath = sys_get_temp_dir() . '/' . $avatarName;
    // dd($tmpFilePath);
   
       // Save the image temporarily
    file_put_contents($tmpFilePath, $avatarContents);

    // Store the image in the storage
    $path = Storage::disk('public')->put('avatars', new \Illuminate\Http\UploadedFile($tmpFilePath, $avatarName, mime_content_type($tmpFilePath), null, true));



    $user = User::updateOrCreate([
        'email' => $user->email,
    ], [
        'name' => $user->name,
        'email' => $user->email,
        'password' => 'password',
    ]);
 
    Auth::login($user);
    // Update the user's avatar path in the database
    auth()->user()->update(['avatar' => $path]);

    return redirect('/dashboard');
    // $user->token
});

Route::middleware('auth')->group(function () {
    Route::resource('/ticket', TicketController::class);
// 
});