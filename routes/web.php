<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\control\ActorsController;
use App\Http\Controllers\control\ArticlesController;
use App\Http\Controllers\control\CategoriesController;
use App\Http\Controllers\control\CommentsController;
use App\Http\Controllers\control\EpisodesController;
use App\Http\Controllers\control\GenresController;
use App\Http\Controllers\control\KeywordsController;
use App\Http\Controllers\control\LikesController;
use App\Http\Controllers\control\MoviesController;
use App\Http\Controllers\control\ReviewsController;
use App\Http\Controllers\control\SeasonsController;
use App\Http\Controllers\control\SeriesController;
use App\Http\Controllers\control\TagsController;
use App\Http\Controllers\control\UsersController;
use App\Http\Controllers\control\AdminsController;
use App\Http\Controllers\control\photosController;
use App\Http\Controllers\control\homeController;
use App\Http\Controllers\control\authController;

use App\Http\Controllers\dashboard\actorController;
use App\Http\Controllers\dashboard\userController;
use App\Http\Controllers\dashboard\articlesController as articlesCont;

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


Route::get('/', function () {
    return view('dashboard.index');
});

Route::get('/control', function () {
    return view('control.index');
});


// \Mail::send ( 'emails.code.code', $data, function ($sendemail) use($email) {
//     $sendemail->from ( 'info@me.com', 'Me Team' );
//     $sendemail->to ( $email, '' )->subject ( 'Activate your account' );
// } );


Route::get('/sendmail5', function () {
	$to_name = 'RECEIVER_NAME';
	$to_email = 'jabe9000@gmail.com';
	$data = array('name'=>'Ogbonna Vitalis(sender_name)', 'body' => 'A test mail');

	Mail::send('mail', $data, function($message) use ($to_name, $to_email) {
		$message->to($to_email, $to_name)->subject('Laravel Test Mail');
		$message->from('jabe90asasa00@gmail.com','Test Mail');
	});

	return 'success The Link was sent to your email.';
});
Route::get('/sendmail', function () {

	$mail = 'jabe9000@gmail.com';
	$name = 'jabe9000';
	$data = array('name' => 'salmmm', 'body' => 'Test mail');
	Mail::send('mail', $data, function($message) use ($name, $mail){
		$message->from ('info@me.com', 'Me Team' );
		$message->to($mail)->subject('Test subject');
	});

    return 'success The Link was sent to your email.';
});



Route::get('/control/photos', [photosController::class, 'index']);
Route::post('/control/photos', [photosController::class, 'save']);
Route::put('/control/photos', [photosController::class, 'store']);
Route::delete('/control/photos/{id}', [photosController::class, 'destroy']);
Route::delete('/control/photos', [photosController::class, 'deleteAll']);


Route::get('/control/delete', [ActorsController::class, 'delete']);
Route::get('/control/delete', [ActorsController::class, 'delete']);


Route::get('/view', function () {
	return view('view.view');
});

Route::get('/editor', function () {
	return view('editor');
});




Route::get('/dashtest', function () {
    return view('dashboard.test');
});


Route::get('/blogdetail', function () {
    return view('dashboard.blog.blogdetail');
});
Route::get('/bloggrid', function () {
    return view('dashboard.blog.bloggrid');
});



Route::get('/actordetail', function () {
    return view('dashboard.actor.actordetail');
});
Route::get('/actorgrid', function () {
    return view('dashboard.actor.actorgrid');
});


Route::get('/moviesingle', function () {
    return view('dashboard.movie.moviesingle');
});
Route::get('/moviegrid', function () {
    return view('dashboard.movie.moviegrid');
});


Route::get('/seriessingle', function () {
    return view('dashboard.series.seriessingle');
});
Route::get('/seriesgrid', function () {
    return view('dashboard.series.seriesgrid');
});


Route::get('/userprofile', function () {
    return view('dashboard.user.userprofile');
});
Route::get('/userrate', function () {
    return view('dashboard.user.userrate');
});
Route::get('/userfavoritegrid', function () {
    return view('dashboard.user.userfavoritegrid');
});


Route::get('/login', [userController::class, 'showLoginForm'])->name('user.login');
Route::post('/login', [userController::class, 'login'])->name('user.login.submit');
// Route::get('/register', [userController::class, 'showRegisterForm'])->name('user.register');
Route::post('/register', [userController::class, 'register'])->name('user.register.submit');
Route::get('/forget_passowrd', [userController::class, 'forget_passowrd'])->name('user.forget_passowrd');
Route::post('/forget_passowrd', [userController::class, 'forget_passowrd_post'])->name('user.forget_passowrd.submit');
Route::get('/recover_password/{token}', [userController::class, 'recover_password'])->name('user.recover_password');
Route::post('/recover_password/{token}', [userController::class, 'recover_password_post'])->name('user.recover_password.submit');
Route::any('/logout', [userController::class, 'logout'])->name('user.logout');

Route::prefix('actor')->group(function(){
	Route::post('search', [actorController::class, 'search']);
	Route::get('actorlist', [actorController::class, 'list']);
	Route::get('/{id}', [actorController::class, 'show']);

	Route::get('/userprofile', [userController::class, 'list']);
	Route::get('/userrate/{id}', [userController::class, 'show']);
	Route::get('/userfavoritegrid', [userController::class, 'show']);
});

Route::prefix('blog')->group(function(){
	Route::post('search', [articlesCont::class, 'search']);
	Route::get('actorlist', [articlesCont::class, 'list']);
	Route::get('/{id}', [articlesCont::class, 'show']);
});
// return view('dashboard.actor.actordetail');




// Auth::routes();

Route::prefix('control')->group(function(){
    Route::get('/login', [authController::class, 'showLoginForm'])->name('control.login');
    Route::post('/login', [authController::class, 'login'])->name('control.login.submit');
    Route::get('/register', [authController::class, 'showRegisterForm'])->name('control.register');
    Route::post('/register', [authController::class, 'register'])->name('control.register.submit');
    Route::get('/forget_passowrd', [authController::class, 'forget_passowrd'])->name('control.forget_passowrd');
    Route::post('/forget_passowrd', [authController::class, 'forget_passowrd_post'])->name('control.forget_passowrd.submit');
    Route::get('/recover_password/{token}', [authController::class, 'recover_password'])->name('control.recover_password');
    Route::post('/recover_password/{token}', [authController::class, 'recover_password_post'])->name('control.recover_password.submit');
    Route::any('/logout', [authController::class, 'logout'])->name('control.logout');
    
    Route::any('/', [homeController::class, 'index'])->name('control.index');

    Route::resource('/actors', ActorsController::class);
	Route::delete('/actorsDeleteAll', [ActorsController::class, 'deleteAll']);

	Route::resource('/genres', GenresController::class);
	Route::delete('/control/genresDeleteAll', [GenresController::class, 'deleteAll']);

	Route::resource('/movies', MoviesController::class);
	Route::delete('/moviesDeleteAll', [MoviesController::class, 'deleteAll']);

	Route::resource('/series', SeriesController::class);
	Route::delete('/seriesDeleteAll', [SeriesController::class, 'deleteAll']);

	Route::resource('/seasons', SeasonsController::class);
	Route::delete('/seriesDeleteAll', [SeriesController::class, 'deleteAll']);

	Route::resource('/episodes', EpisodesController::class);
	Route::delete('/episodesDeleteAll', [EpisodesController::class, 'deleteAll']);
	Route::post('/getSeasons/{id}', [EpisodesController::class, 'getSeasons']);

	Route::resource('/likes', LikesController::class);
	Route::delete('/likesDeleteAll', [LikesController::class, 'deleteAll']);

	Route::resource('/reviews', ReviewsController::class);
	Route::delete('/reviewsDeleteAll', [ReviewsController::class, 'deleteAll']);

	Route::resource('/movies', MoviesController::class);
	Route::delete('/moviesDeleteAll', [MoviesController::class, 'deleteAll']);


	Route::resource('/articles', ArticlesController::class);
	Route::delete('/articlesDeleteAll', [ArticlesController::class, 'deleteAll']);

	Route::resource('/categories', CategoriesController::class);
	Route::delete('/categoriesDeleteAll', [CategoriesController::class, 'deleteAll']);

	Route::resource('/comments', CommentsController::class);
	Route::delete('/control/commentsDeleteAll', [CommentsController::class, 'deleteAll']);



	Route::resource('/keywords', KeywordsController::class);
	Route::resource('/tags', TagsController::class);

	Route::resource('/users', UsersController::class);
	Route::delete('/usersDeleteAll', [UsersController::class, 'deleteAll']);



	Route::resource('/admins', AdminsController::class);
	Route::delete('/usersDeleteAll', [AdminsController::class, 'deleteAll']);


});