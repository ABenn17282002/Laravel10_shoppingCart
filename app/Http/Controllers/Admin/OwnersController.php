<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
/* DB操作用モジュール */
use App\Models\Owner;  // Eloquent エロクアント
use Illuminate\Support\Facades\DB; // QueryBuilder クエリービルダー
/* 日付を扱うクラス */
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;  // 暗号化クラス
use Illuminate\Validation\Rules;      // validationクラス

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
        // Owne_tableの名前,email,作成日を取得
        $owners = Owner::select('name','email','created_at')->get();

        // admin/owners/index.blade.phpに$owners変数を渡す
        return \view('admin.owners.index',compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // admin/owners/create.blade.phpに返す
        return \view('admin.owners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:owners'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Ownerのname,email,passowrdの保存
        Owner::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // owners.indexページへリダイレクト flashmessage
        return \redirect()->route('admin.owners.index')
        ->with('success','オーナー登録が完了しました。');
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
