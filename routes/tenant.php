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
use Illuminate\Http\Request;

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

    Route::post('/createTopic', 'TopicController@create');
    Route::post('/updateArticle', 'ArticleController@update');
});

Route::get('/app/articles', 'ArticleController@show');

Route::get('/test', function(Request $request) {
    $article = Article::find(14);


                           dd($article->content);

        $article->content = $request->get("content");
        $article->save();
});

Route::get('/api/articles/{id}', function ($id) {
    $article = Article::find($id);

    return response()->json($article);

    // return view('tenants.article', [
    //     'article' => $article
    // ]);
});

Route::get('/app/{topic}/articles', function($topic) {
    $articles = Article::select('title', 'topic', 'content', 'id', 'updated_at')
                           ->where('topic', '=', $topic)
                           ->get();

    //return response()->json($articles, $topic);

    return view('tenants.articles', [
        'articles' => $articles,
        'topic' => $topic
    ]);
});

Route::get('/api/{topic}/articles', function($topic) {
    $articles = Article::select('title', 'topic', 'content', 'id', 'updated_at')
                           ->where('topic', '=', $topic)
                           ->get();

    return response()->json($articles);
});

Route::get('/api/{topic}/articles/{id}', function($topic, $id) {
    $articles = Article::select('title', 'topic', 'id', 'content', 'id', 'updated_at')
                           ->where('topic', '=', $topic)
                           ->where('id', '=', $id)
                           ->get();

    return response()->json($articles);

    // return view('tenants.article', [
    //     'articles' => $articles
    // ]);
});

/* REDIRECTS */

Route::get('/articles', function() {
    return redirect('/app/articles');
});

Route::get('/topics', function () {
    return redirect('/app/topics');
});

/* API */

Route::get('/api/articles', 'ArticleController@get');

Route::get('/api/topics', 'TopicController@get');