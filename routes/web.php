<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Article;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-eloquent', function () {
    $start = microtime(true);

    $articles = Article::with('comments')->take(1000)->get();

    $end = microtime(true);

    return 'Eloquent Time: ' . ($end - $start);
});

Route::get('/test-raw', function () {
    $start = microtime(true);

    $articles = DB::select("
        SELECT articles.*, comments.comment
        FROM articles
        LEFT JOIN comments ON comments.article_id = articles.id
        LIMIT 1000
    ");

    $end = microtime(true);

    return 'Raw SQL Time: ' . ($end - $start);
});