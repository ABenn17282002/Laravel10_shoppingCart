<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// 認証モデルの使用
use Illuminate\Support\Facades\Auth;
// DBFacadeの使用
use Illuminate\Support\Facades\DB;
// Primary・SecondaryCategoryモデルの使用
use App\Models\PrimaryCategory;
use App\Models\SecondaryCategory;

class CategoryController extends Controller
{
    /*ログイン済みユーザーのみ表示させるため
    コンストラクタの設定 */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
    * PrimaryCategory＆SecondaryCategories Count
    */
    public function Primaryindex()
    {
        // PrimaryCategoryに紐づくsecondaryCategoryの数を取得
        $primaryCategories = PrimaryCategory::withCount('secondary')->get();

        return view('admin.categories.index', compact('primaryCategories'));
    }

    /**
    * Display the editing form for a specific primary category and its associated secondary categories.
    *
    * @param  PrimaryCategory  $primaryCategory
    * @return \Illuminate\Http\Response
    */
    public function CategoryEdit(PrimaryCategory $primaryCategory)
    {
        // Secondary情報の取得
        $secondaryCategories = $primaryCategory->secondary;

        return view('admin.categories.edit', compact('primaryCategory', 'secondaryCategories'));
    }

}
