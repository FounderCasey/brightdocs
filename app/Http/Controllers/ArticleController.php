<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Topic;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function create(Request $request) {
        $article = new Article;
        $article->title = $request->get('title');
        $article->content = $request->get("content");
        $article->topic = $request->get('topic');
        $article->save();

        $topicsDB = DB::table('topics')->select('name')->get();

        $topics = [];
        for ($i = 0; $i<sizeof($topicsDB); $i++) {
            array_push($topics, $topicsDB[$i]->name);
        }

        if (!in_array($request->get('topic'), $topics)) {
            $topic = new Topic;
            $topic->name = $request->get('topic');
            $topic->count = 0;
            $topic->save();

            DB::table('topics')->where('name', $request->get('topic'))->update([
             'count' => DB::raw('count+1')
            ]);
        } else {
            DB::table('topics')->where('name', $request->get('topic'))->update([
             'count' => DB::raw('count+1')
            ]);
        }
    }

    public function update(Request $request) {
        $article = Article::find($request->get('id'));

        $article->content = $request->get("content");
        $article->save();
    }

    public function get(Request $request)
    {
        $articles = Article::orderBy('title', 'asc')->get();

        return response()->json($articles);
    }

    public function show()
    {
        return view('tenants.articles');
    }
}
