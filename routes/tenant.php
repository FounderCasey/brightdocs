<?php

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider
| with the tenancy and web middleware groups. Good luck!
|
*/

use App\Article;
use App\Topic;
use Illuminate\Support\Facades\DB;

Auth::routes();

Route::get('/app', function () {
        return view('tenants.home');
    });

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {

        return view('tenants.dashboard');
    })->middleware('check_role:' . "User");

    Route::get('/logout', 'Auth\LoginController@logout');

    Route::post('/create', 'ArticleController@create');
});

Route::get('/app/articles', 'ArticleController@show');

Route::get('/api/articles', 'ArticleController@get');

Route::get('/api/topics', 'TopicController@get');

Route::get('/test', function() {
    $articles = Article::orderBy('created_at', 'asc')->get();

    dd(response()->json($articles));
});

Route::get('/articles/{id}', function ($id) {
    $article = Article::find($id);

    return view('tenants.article', [
        'article' => $article
    ]);
});

Route::get('/articles', function() {
    return redirect('/app/articles');
});

Route::get('/topics', function () {
    return redirect('/app/topics');
});