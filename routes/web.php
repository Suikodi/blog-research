<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Article;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| ELOQUENT TESTS (READ ONLY)
|--------------------------------------------------------------------------
*/
Route::get('/test-eloquent', function () {

    $results = [];

    // 1. Simple Select
    $start = microtime(true);
    Article::take(1000)->get();
    $results['simple_select'] = microtime(true) - $start;

    // 2. Select with Where
    $start = microtime(true);
    Article::where('id', '<=', 1000)->get();
    $results['where_clause'] = microtime(true) - $start;

    // 3. Join (via relationship)
    $start = microtime(true);
    Article::with('comments')->take(1000)->get();
    $results['join_relationship'] = microtime(true) - $start;

    // 4. Aggregation
    $start = microtime(true);
    Article::select('user_id', DB::raw('COUNT(*) as total'))
        ->groupBy('user_id')
        ->get();
    $results['aggregation'] = microtime(true) - $start;

    // 5. Order + Limit
    $start = microtime(true);
    Article::orderBy('created_at', 'desc')->take(1000)->get();
    $results['order_limit'] = microtime(true) - $start;

    return response()->json([
        'type' => 'Eloquent',
        'results' => $results
    ]);
});


/*
|--------------------------------------------------------------------------
| RAW SQL TESTS (READ ONLY)
|--------------------------------------------------------------------------
*/
Route::get('/test-raw', function () {

    $results = [];

    // 1. Simple Select
    $start = microtime(true);
    DB::select("SELECT * FROM articles LIMIT 1000");
    $results['simple_select'] = microtime(true) - $start;

    // 2. Select with Where
    $start = microtime(true);
    DB::select("SELECT * FROM articles WHERE id <= 1000");
    $results['where_clause'] = microtime(true) - $start;

    // 3. Join
    $start = microtime(true);
    DB::select("
        SELECT articles.*, comments.comment
        FROM articles
        LEFT JOIN comments ON comments.article_id = articles.id
        LIMIT 1000
    ");
    $results['join'] = microtime(true) - $start;

    // 4. Aggregation
    $start = microtime(true);
    DB::select("
        SELECT user_id, COUNT(*) as total
        FROM articles
        GROUP BY user_id
    ");
    $results['aggregation'] = microtime(true) - $start;

    // 5. Order + Limit
    $start = microtime(true);
    DB::select("
        SELECT * FROM articles
        ORDER BY created_at DESC
        LIMIT 1000
    ");
    $results['order_limit'] = microtime(true) - $start;

    return response()->json([
        'type' => 'Raw SQL',
        'results' => $results
    ]);
});