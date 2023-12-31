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
// CategoryRequestの使用
use App\Http\Requests\CategoryRequest;
// QueryExceptionクラスの使用
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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
    * Store a newly created resource in storage.
    */
    public function CategoryStore(CategoryRequest $request)
    {
        // Validationの実施
        $validated = $request->validated();

        try {
            // トランザクションの開始
            DB::beginTransaction();

            // 1. Primaryカテゴリー作成と同時にprimary_category_idを設定
            $primaryCategory = new PrimaryCategory();
            $primaryCategory->name = $request->input('primary_name');
            $primaryCategory->sort_order = $request->input('primary_sort_order');
            $primaryCategory->save();

            // 2. nullでない場合のみセカンダリカテゴリーを作成
            $newSecondaryCategories = $request->input('new_secondary');

            if (!empty($newSecondaryCategories)) {
                foreach ($newSecondaryCategories as $secondaryData) {
                    if ($secondaryData['sort_order'] !== null && $secondaryData['name'] !== null) {
                        $secondaryCategory = new SecondaryCategory();
                        $secondaryCategory->sort_order = $secondaryData['sort_order'];
                        $secondaryCategory->name = $secondaryData['name'];
                        $secondaryCategory->primary_category_id = $primaryCategory->id; // primary_category_idを設定
                        $secondaryCategory->save();
                    }
                }
            }

            // トランザクションのコミット
            DB::commit();

            // トランザクションが正常に完了した場合の処理
            return redirect()->route('admin.categories.index')->with('success', 'カテゴリー登録が完了しました.');

        } catch (QueryException $e) {
            // クエリ実行時にエラーが発生した場合の処理
            DB::rollback(); // トランザクションのロールバック
            Log::error($e);
            return redirect()->back()->with('error', 'データ保存中にエラーが発生しました。');
        } catch (Throwable $e) {
            // その他の例外が発生した場合の処理
            DB::rollback(); // トランザクションのロールバック
            Log::error($e);
            throw $e; // 例外を再スロー
        }
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

    public function deleteSecondaryCategory($second_id)
    {
        try {
            // セカンダリーカテゴリを削除
            SecondaryCategory::findOrFail($second_id)->delete();

            // 削除が成功したらリダイレクト
            return redirect()->back()->with('success', 'セカンダリーカテゴリが削除されました。');
        } catch (\Exception $e) {
            // 削除が失敗した場合の処理
            return redirect()->back()->with('error', 'セカンダリーカテゴリの削除中にエラーが発生しました。');
        }
    }

    /**
    * Update the specified resource in storage.
    */
    public function CategoryUpDate(CategoryRequest $request, $primaryCategoryId)
    {
        // Validationの実施
        $validated = $request->validated();

        // プライマリーカテゴリーの更新
        $primaryCategory = PrimaryCategory::findOrFail($primaryCategoryId);
        $primaryCategory->sort_order = $request->input('primary_sort_order');
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

    /**
    * Remove the specified resource from storage.
    */
    public function CategoryTrash(string $id)
    {
        //ソフトデリート
        PrimaryCategory::findOrFail($id)->delete();

        return \redirect()->route('admin.categories.index')
        ->with('trash','カテゴリー情報をゴミ箱へ移しました');
    }

    /* Categoryゴミ箱情報の取得 */
    public function expiredCatergoryIndex()
    {
        // softDeleteのみを取得
        $expiredCategories = PrimaryCategory::onlyTrashed()->withCount('secondary')->get();
        return view('admin.expired-categories',\compact('expiredCategories'));
    }

    /* 削除済みカテゴリー情報の完全削除 */
    public function expiredCatergoryDestroy($id)
    {
        // PrimaryCategoryモデルのインスタンスを取得
        $primaryCategory = PrimaryCategory::onlyTrashed()->findOrFail($id);
        // 関連するSecondaryCategoryレコードを削除
        $primaryCategory->secondary()->forceDelete();
        // PrimaryCategoryレコードを物理的に削除
        $primaryCategory->forceDelete();

        return redirect()->route('admin.expired-categories.index')
        ->with('delete','カテゴリー情報を完全に削除しました');;
    }

    /* 削除済みカテゴリー情報のリストア */
    public function restoreCategory(Request $request, $id)
    {
        $category = PrimaryCategory::onlyTrashed()->findOrFail($id);

        // バリデーションルールを定義
        $rules = [
            'sort_order' => [
                'required',
                'integer',
                Rule::unique('primary_categories')->ignore($category->id)->whereNull('deleted_at'),
            ],
            'name' => [
                'required',
                'string',
                Rule::unique('primary_categories')->ignore($category->id)->whereNull('deleted_at'),
            ],
        ];

        // バリデーション実行
        $request->validate($rules);

        // カテゴリー情報を復元
        $category->restore();
        // ソート順と名前をリクエストから取得
        $sortOrder = $request->input('sort_order');
        $name = $request->input('name');

        // カテゴリー情報を更新
        $category->update([
            'sort_order' => $sortOrder,
            'name' => $name,
        ]);

        // 完了したらリダイレクト
        return redirect()->route('admin.categories.index')
                    ->with('success', 'カテゴリー情報を復元しました。');
    }
}
