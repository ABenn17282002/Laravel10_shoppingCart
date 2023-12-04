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
    * Category Edit
    */
    public function CategoryEdit(PrimaryCategory $primaryCategory)
    {
        $secondaryCategories = $primaryCategory->secondary;

        // dd($secondaryCategories);

        return view('admin.categories.edit', compact('primaryCategory', 'secondaryCategories'));
    }
}
