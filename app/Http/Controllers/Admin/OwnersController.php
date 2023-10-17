<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
/* DB操作用モジュール */
use App\Models\Owner;  // Eloquent エロクアント
use Illuminate\Support\Facades\DB; // QueryBuilder クエリービルダー

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
        // OwnerのDataを全て取得
        $e_all = Owner::all();

        // Owner_tableからname列のみを取得する
        $q_get = DB::table('owners')->select('name')->get();

        // Owner_tableからname列の最初のみを取得する object(stdClass)
        $q_first = DB::table('owners')->select('name')->first();

        // 配列
        $c_test = \collect([
            'name' =>'testname'
        ]);

        // debug
        var_dump($q_first);

        dd($e_all, $q_get, $q_first, $c_test);
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
