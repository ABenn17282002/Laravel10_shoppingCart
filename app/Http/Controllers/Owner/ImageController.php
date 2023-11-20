<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
// UploadImageRequestクラス
use App\Http\Requests\UploadImageRequest;
// ImageServiceの使用
use App\Services\ImageService;
// Imageモデル
use App\Models\Image;
// ユーザ認証
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    /*ログイン済みImageのみ表示させるため
    コンストラクタの設定 */
    public function __construct()
    {
        $this->middleware('auth:owners');

        // コントローラミドルウェア
        $this->middleware(function ($request, $next) {
            // image_idの取得
            $id = $request->route()->parameter('image');
            // null判定
            if(!is_null($id)){
                // images_OwnerIdの取得
                $imagesOwnerId= Image::findOrFail($id)->owner->id;
                // 文字列→数値に変換
                $imageId = (int)$imagesOwnerId;
                // imageIdが認証済でない場合
                if($imageId  !== Auth::id()){
                    abort(404); // 404画面表示
                }
            }

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 認証済Owner_idに紐づくImageIDを取得
        $images = Image::where('owner_id', Auth::id())
        // 降順取得20件まで
        ->orderBy('updated_at', 'desc')
        ->paginate(20);

        // owner/images/index.balde.phpにimages変数付で返す
        return view('owner.images.index',compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // owner/images/create.blade.phpにviewを返す
        return \view('owner.images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadImageRequest $request)
    {
        // 複数ファイルを取得
        $imageFiles = $request->file('files');
        // 配列が空でない場合
        if(!is_null($imageFiles)){
            foreach($imageFiles as $imageFile){
                // 製品フォルダ内に画像を1つずつupload
                $fileNameToStore = ImageService::upload($imageFile, 'products');
                // image_tableのowneridとfilenameに記録
                Image::create([
                    'owner_id' => Auth::id(),
                    'filename' => $fileNameToStore
                ]);
            }
        }

        // redirect owner/images/index.blade.php + flashmessage
        return redirect()
        ->route('owner.images.index')
        ->with('info','画像登録を実施しました。');

        // セッションから特定のフラッシュメッセージを削除
        $request->session()->forget('info');
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
