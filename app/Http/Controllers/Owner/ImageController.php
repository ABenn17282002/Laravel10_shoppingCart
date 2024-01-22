<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
// Requestクラス
use Illuminate\Http\Request;
// UploadImageRequestクラス
use App\Http\Requests\UploadImageRequest;
// ImageServiceの使用
use App\Services\ImageService;
// Imageモデル
use App\Models\Image;
// ユーザ認証
use Illuminate\Support\Facades\Auth;
// storageクラス
use Illuminate\Support\Facades\Storage;
// Productクラスの使用
use App\Models\Product;

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
        ->paginate(3);

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
        ->with('info','画像を登録しました。');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Image_idの取得(ない場合:404)
        $image = Image::findOrFail($id);
        return \view('owner.images.edit',\compact('image'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // バリデーションルール
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image|max:2048', // 2MBまでの画像を許容
        ]);

        // 対象のImageモデルを取得
        $imageModel = Image::findOrFail($id);

        // タイトルを更新
        $imageModel->title = $request->input('title');

        // 画像がアップロードされている場合の処理
        if ($request->hasFile('image')) {
            // 古い画像を削除
            Storage::delete('public/products/' . $imageModel->filename);

            // ImageServiceを使用して新しい画像をアップロードし、ファイル名を取得
            $fileNameToStore = ImageService::upload($request->file('image'), 'products');

            // 新しいファイル名をモデルに設定
            $imageModel->filename = $fileNameToStore;
        }

        // データベースに保存
        $imageModel->save();

        // 成功メッセージとともにリダイレクト
        return redirect()->route('owner.images.index')
        ->with('success', '画像情報が更新されました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // imageIDを取得
        $image = Image::findOrFail($id);

        // 削除したい画像をProductで使っているかの確認
        $imageInProducts =Product::where('image1', $image->id)
        ->orWhere('image2', $image->id)
        ->orWhere('image3', $image->id)
        ->orWhere('image4', $image->id)
        ->get();

        // 画像をProduct側で使用の場合、image1-4を確認してnullにする。
        if($imageInProducts){
            $imageInProducts->each(function($product) use($image){
                if($product->image1 === $image->id){
                    $product->image1 = null;
                    $product->save();
                }
                if($product->image2 === $image->id){
                    $product->image2 = null;
                    $product->save();
                }
                if($product->image3 === $image->id){
                    $product->image3 = null;
                    $product->save();
                }
                if($product->image4 === $image->id){
                    $product->image4 = null;
                    $product->save();
                }
            });
        }

        // file情報取得
        $filePath = 'public/products'. $image->filename;

        // fileがあれば画像削除
        if(Storage::exists($filePath)){
            Storage::delete($filePath);
        }

        // DB情報削除
        Image::findOrFail($id)->delete();

        // redirect owner/images/index.blade.php + flashmessage
        return redirect()
        ->route('owner.images.index')
        ->with('delete','画像を完全に削除しました');
    }
}
