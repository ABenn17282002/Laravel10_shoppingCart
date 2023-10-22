<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
/* DB操作用モジュール */
use App\Models\Owner;  // Eloquent エロクアント
use Illuminate\Support\Facades\DB; // QueryBuilder クエリービルダー
/* 日付を扱うクラス */
use Carbon\Carbon;

class OwnersController extends Controller
{

    /*ログイン済みユーザーのみ表示させるため
    コンストラクタの設定 */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*  Carbon(日付を扱うクラス)
        https://coinbaby8.com/carbon-laravel.html */

        // 年
        $date_now = Carbon::now();
        echo $date_now->year;
        echo "<br>";

        // 現在時刻を表示
        $date_parse = Carbon::parse(now());
        echo $date_parse;
        echo "<br>";

        // Format ****年**月**日
        echo $date_now ->format('Y年m月d日');
        echo "<br>";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
