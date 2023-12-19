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
// CategoryUpdateRequestの使用
use App\Http\Requests\CategoryUpdateRequest;

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
    * Show the form for creating a new resource.
    */
    public function Categorycreate()
    {
        // admin/categories/create.blade.phpに返す
        return \view('admin.categories.create');
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
        $secondaryCategories = $primaryCategory->secondary()->orderBy('sort_order')->get();


        return view('admin.categories.edit', compact('primaryCategory', 'secondaryCategories'));
    }


    /**
    * Update the specified resource in storage.
    */
    public function CategoryUpDate(CategoryUpdateRequest $request, $primaryCategoryId)
    {
        // Validationの実施
        $validated = $request->validated();

        // プライマリーカテゴリーの更新
        $primaryCategory = PrimaryCategory::findOrFail($primaryCategoryId);
        $primaryCategory->name = $validated['primary_name'];
        $primaryCategory->save();

        // 既存のセカンダリーカテゴリーの更新
        if (array_key_exists('secondary', $validated)) {
            foreach ($validated['secondary'] as $secId => $data) {
                $secondaryCategory = SecondaryCategory::findOrFail($secId);
                $secondaryCategory->name = $data['name'] ?? $secondaryCategory->name;
                $secondaryCategory->sort_order = $data['sort_order'] ?? $secondaryCategory->sort_order;
                $secondaryCategory->save();
            }
        }

        // 新規セカンダリーカテゴリーの追加
        if (array_key_exists('new_secondary', $validated)) {
            foreach ($validated['new_secondary'] as $data) {
                if (!empty($data['name']) && isset($data['sort_order'])) {
                    SecondaryCategory::create([
                        'primary_category_id' => $primaryCategoryId,
                        'name' => $data['name'],
                        'sort_order' => $data['sort_order'],
                    ]);
                }
            }
        }

        // 更新が完了したらリダイレクト
        return redirect()->route('admin.categories.index')
                    ->with('success', 'カテゴリが更新されました。');
    }

}
