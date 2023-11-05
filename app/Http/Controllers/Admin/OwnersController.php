<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Ownerモデルクラス
use App\Models\Owner;
// Adminモデルクラス
use APP\Models\Admin;
// Shopモデルクラス
use App\Models\Shop;
// QueryBuilder クエリービルダー
use Illuminate\Support\Facades\DB;
// 日付を扱うクラス
use Carbon\Carbon;
// 暗号化クラス
use Illuminate\Support\Facades\Hash;
// validationクラス
use Illuminate\Validation\Rules;
// 例外catch用
use Throwable;
// エラーLog記録用
use Illuminate\Support\Facades\Log;

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
        // Owne_tableの名前,email, <-id情報がないと編集できないので追加
        $owners = Owner::select('id','name','email','created_at')
        // ページネーション
        ->paginate(3);

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
            // 店舗名作成のvalidation
            'shop_name' => ['required', 'string', 'max:255'],
        ]);

        // try catch構文
        try{
            /**
             * オーナー作成時にshopも同時に作成
             * transaction2回失敗時=> error(引数:$request)
             * */
            DB::transaction(function() use($request){

                // Owner情報の作成
                $owner = Owner::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                // Shop情報の作成
                Shop::create([
                    // owner_tableよりowner_idを取得
                    'owner_id'=> $owner->id,
                    'name'=>$request->shop_name,
                    'information'=>'',
                    'filename'=>'',
                    'is_selling'=>true
                ]);

            },2);

        } catch (Throwable $e){

           // 例外処理の記録と画面表示
            Log::error($e);
            throw $e;

        }

        // owners.indexページへリダイレクト flashmessage
        return \redirect()->route('admin.owners.index')
        ->with('success','オーナー登録が完了しました。');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // idがなければ404画面
        $owner = Owner::findOrFail($id);

        // admin/owners/edit.blade.phpにowner変数(owner_id)を渡す。
        return \view('admin.owners.edit',\compact('owner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validation
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // mailアドレス変更しない場合の許可
            'email' => ['required', 'string', 'email', 'max:255',],
            // Password変更しない場合の許可
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            // 店舗名作成のvalidation
            'shop_name' => ['required', 'string', 'max:255'],
        ]);

        // idがなければ404画面
        $owner = Owner::findOrFail($id);
        // フォームから取得した値を代入
        $owner -> name = $request->name;
        $owner -> email = $request->email;

        // password情報が空でないときのみ適応する！
        if ($request->filled('password')) {
            $owner  -> password = Hash::make($request->password);
        }

        // ショップ情報を更新(Shop名の変更)
        $owner->shop->update([
            'name' => $request->shop_name,
        ]);

        // 情報を保存
        $owner ->save();

        return \redirect()
        ->route('admin.owners.index')
        ->with('update','オーナー情報を更新しました');

        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //ソフトデリート
        Owner::findOrFail($id)->delete();

        return \redirect()
        ->route('admin.owners.index')
        ->with('trash','オーナー情報をゴミ箱へ移しました');
    }

    /* Ownerゴミ箱情報の取得 */
    public function expiredOwnerIndex()
    {
        // softDeleteのみを取得
        $expiredOwners = Owner::onlyTrashed()->get();
        return view('admin.expired-owners',\compact('expiredOwners'));
    }

    /* 期限切れOwner情報の完全削除 */
    public function expiredOwnerDestroy($id)
    {
        // 論理削除したuserを物理削除をする
        Owner::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.expired-owners.index')
        ->with('delete','オーナー情報を完全に削除しました');;
    }
}
