<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Article;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| HELPER: Benchmark Function
|--------------------------------------------------------------------------
*/
function benchmark($callback, $iterations = 30, $warmup = 5)
{
    $times = [];

    for ($i = 0; $i < $iterations; $i++) {
        $start = microtime(true);
        $callback();
        $end = microtime(true);

        if ($i >= $warmup) {
            $times[] = ($end - $start) * 1000; // ms
        }
    }

    $avg = array_sum($times) / count($times);

    $variance = array_reduce($times, function ($carry, $time) use ($avg) {
        return $carry + pow($time - $avg, 2);
    }, 0) / count($times);

    $stdDev = sqrt($variance);

    return [
        'avg' => round($avg, 3),
        'std_dev' => round($stdDev, 3),
    ];
}

/*
|--------------------------------------------------------------------------
| ELOQUENT TEST
|--------------------------------------------------------------------------
*/
Route::get('/test-eloquent', function () {

    $results = [];

    $results['Simple Select'] = benchmark(function () {
        Article::take(1000)->get();
    });

    $results['Where Clause'] = benchmark(function () {
        Article::where('id', '<=', 1000)->get();
    });

    $results['Join (with comments)'] = benchmark(function () {
        Article::with('comments')->take(1000)->get();
    });

    $results['Aggregation'] = benchmark(function () {
        Article::select('user_id', DB::raw('COUNT(*) as total'))
            ->groupBy('user_id')
            ->get();
    });

    $results['Order + Limit'] = benchmark(function () {
        Article::orderBy('created_at', 'desc')->take(1000)->get();
    });

    return view('benchmark-table', [
        'type' => 'Eloquent',
        'results' => $results
    ]);
});

/*
|--------------------------------------------------------------------------
| RAW SQL TEST
|--------------------------------------------------------------------------
*/
Route::get('/test-raw', function () {

    $results = [];

    $results['Simple Select'] = benchmark(function () {
        DB::select("SELECT * FROM articles LIMIT 1000");
    });

    $results['Where Clause'] = benchmark(function () {
        DB::select("SELECT * FROM articles WHERE id <= 1000");
    });

    $results['Join'] = benchmark(function () {
        DB::select("
            SELECT articles.*, comments.comment
            FROM articles
            LEFT JOIN comments ON comments.article_id = articles.id
            LIMIT 1000
        ");
    });

    $results['Aggregation'] = benchmark(function () {
        DB::select("
            SELECT user_id, COUNT(*) as total
            FROM articles
            GROUP BY user_id
        ");
    });

    $results['Order + Limit'] = benchmark(function () {
        DB::select("
            SELECT * FROM articles
            ORDER BY created_at DESC
            LIMIT 1000
        ");
    });

    return view('benchmark-table', [
        'type' => 'Raw SQL',
        'results' => $results
    ]);
});
