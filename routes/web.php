<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/team', [App\Http\Controllers\TeamController::class, 'myTeams'])->name('team.teams');
Route::get('/whoweare', [App\Http\Controllers\WhoWeAreController::class, 'index'])->name('whoweare');

Route::get('/tournament/{tournament}', [App\Http\Controllers\TournamentController::class, 'showGuests'])->name('tournament.show');

// Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('home');

    Route::get('/homepagesetup', [App\Http\Controllers\HomePageSetupController::class, 'index'])->name('homepagesetup.index');

    Route::post('/result/{result}/image/upload', [App\Http\Controllers\ImageController::class, 'resultImageUpload'])->name('result.image.upload');
    Route::get('/image/{image}/reject', [App\Http\Controllers\ImageController::class, 'rejectImage'])->name('image.reject');
    Route::get('/image/{image}/accept', [App\Http\Controllers\ImageController::class, 'acceptImage'])->name('image.accept');

    Route::resource('/season/{season}/tournament', App\Http\Controllers\TournamentController::class);
    Route::get('/season/{season}/tournament/{tournament}/download_calendar', [App\Http\Controllers\TournamentController::class, 'downloadRoundsAndTeams'])->name('tournament.download_calendar');
    Route::get('/season/{season}/tournament/{tournament}/download_results', [App\Http\Controllers\TournamentController::class, 'downloadResults'])->name('tournament.download_results');
    Route::get('/season/{season}/tournament/{tournament}/evaluate_classification', [App\Http\Controllers\TournamentController::class, 'evaluateClassification'])->name('tournament.evaluate_classification');
    Route::get('/season/{season}/activate', [App\Http\Controllers\SeasonController::class, 'activate'])->name('season.activate');

    Route::resource('/result', App\Http\Controllers\ResultController::class);
    Route::resource('/team', App\Http\Controllers\TeamController::class);

    Route::resource('/season', App\Http\Controllers\SeasonController::class);
    Route::resource('/notice', App\Http\Controllers\NoticeController::class);
});
