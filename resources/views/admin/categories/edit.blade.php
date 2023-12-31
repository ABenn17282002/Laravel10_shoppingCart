<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            カテゴリ情報編集画面
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font relative">
                        {{-- flassmessageの表示 --}}
                        <x-flash-message />
                        <div class="container px-5 py-10 mx-auto">
                            <form id="update_{{ $primaryCategory->id }}" action="{{ route('admin.categories.update', ['id' => $primaryCategory->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @if ($errors->any())
                                <div>
                                    <ul>
                                        @if ($errors->has('primary_sort_order'))
                                            <li style="color: red;">{{ $errors->first('primary_sort_order') }}</li>
                                        @endif
                                        @if ($errors->has('primary_name'))
                                            <li style="color: red;">{{ $errors->first('primary_name') }}</li>
                                        @endif
                                        @if ($errors->has('secondary.*.name'))
                                            <li style="color: red;">{{ $errors->first('secondary.*.name') }}</li>
                                        @endif
                                        @if ($errors->has('secondary.*.sort_order'))
                                            <li style="color: red;">{{ $errors->first('secondary.*.sort_order') }}</li>
                                        @endif
                                        @if ($errors->has('new_secondary.*.name'))
                                            <li style="color: red;">{{ $errors->first('new_secondary.*.name') }}</li>
                                        @endif
                                        @if ($errors->has('new_secondary.*.sort_order'))
                                            <li style="color: red;">{{ $errors->first('new_secondary.*.sort_order') }}</li>
                                        @endif
                                    </ul>
                                </div>
                                @endif
                            {{-- プライマリーカテゴリーの編集 --}}
                            <label class="text-sm text-gray-600">プライマリーカテゴリー情報</label>
                            <div class="mb-4 flex">
                                {{-- Primary Category sort_order --}}
                                <div class="w-1/6">
                                    <label for="primary_sort_order" class="text-sm text-gray-600">ソート順</label>
                                    <input type="number" id="primary_sort_order" name="primary_sort_order" value="{{ $primaryCategory->sort_order }}"  class="w-full bg-gray-100 rounded border border-gray-300" required>
                                </div>
                                {{-- Primary Category name --}}
                                <div class="w-5/6 mr-4">
                                    <label for="primary_name" class="text-sm text-gray-600">カテゴリー名</label>
                                    <input type="text" id="primary_name" name="primary_name" value="{{ $primaryCategory->name }}" class="w-full bg-gray-100 rounded border border-gray-300" required>
                                </div>
                            </div>
                            {{-- 既存のセカンダリーカテゴリーの編集 --}}
                            <label class="text-sm text-gray-600">セカンダリーカテゴリー情報</label>
                            <div class="overflow-x-auto mb-20">
                                <table class="min-w-full bg-white">
                                    <thead class="bg-gray-800 text-white">
                                        <tr>
                                            <th class="w-1/12 py-3 px-4 text-left">順序</th>
                                            <th class="w-10/12 py-3 px-4 text-left">カテゴリー名</th>
                                            <th class="w-1/12 py-3 px-4 text-left"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-700">
                                        @forelse ($secondaryCategories as $secondaryCategory)
                                        <tr>
                                            <td class="border px-4 py-2"><input type="number" name="secondary[{{ $secondaryCategory->id }}][sort_order]" value="{{ $secondaryCategory->sort_order }}" class="w-20 bg-white rounded border border-gray-300 focus:outline-none focus:border-indigo-500 text-base px-4 py-2"></td>
                                            <td class="border px-4 py-2"><input type="text" name="secondary[{{ $secondaryCategory->id }}][name]" value="{{ $secondaryCategory->name }}" class="w-full bg-white rounded border border-gray-300 focus:outline-none focus:border-indigo-500 text-base px-4 py-2"></td>
                                            <td class="border px-4 py-2 text-center">
                                                <button type="button" data-id="{{ $secondaryCategory->id }}" onclick="deleteCategory(event, this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">削除</button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-left py-4">登録済みセカンダリーカテゴリ情報はありません。</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                    {{-- 新規セカンダリーカテゴリーの追加行 --}}
                                    <tr id="newCategoryRow">
                                        <td class="border px-4 py-2">
                                            <input type="number" name="new_secondary[0][sort_order]" value="" class="w-full bg-gray-100 rounded border border-gray-300 focus:outline-none focus:border-indigo-500 text-base px-3 py-2">
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="text" name="new_secondary[0][name]" value="" class="w-full bg-gray-100 rounded border border-gray-300 focus:outline-none focus:border-indigo-500 text-base px-3 py-2">
                                        </td>
                                        <td class="border px-4 py-2">
                                            <button type="button" onclick="addNewCategory()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">追加</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="flex justify-end">
                                <button type="button" onclick="location.href='{{ route('admin.categories.index')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                <button type="button" onclick="updatePost(this)" data-id="{{ $primaryCategory->id }}" class="text-white bg-lime-500 border-0 py-2 px-8 focus:outline-none hover:bg-lime-400 rounded text-lg">更新する</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<script>
// deleteCategory関数を定義
function deleteCategory(event, element) {
    try {
        event.preventDefault();
        const id = element.dataset.id;
        const url = `{{ route('admin.categories.deleteSecondary', ['second_id' => ':id']) }}`.replace(':id', id); // 動的なURLを生成
        const formAction = url;
        const form = createDeleteForm(formAction); // 削除用のフォームを生成
        if (form) {
            if (confirm('セカンダリーカテゴリ情報を削除しますか?')) {
                // フォームをコンソールに出力
                console.log(form);
                document.body.appendChild(form); // フォームをページに追加
                form.submit(); // フォームをサブミット
            }
        } else {
            console.error('Form not found for id:', id);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// 削除用のフォームを生成する関数
function createDeleteForm(action) {
    const form = document.createElement('form');
    form.setAttribute('method', 'POST');
    form.setAttribute('action', action);
    form.setAttribute('onsubmit', 'return confirm("セカンダリーカテゴリ情報を削除しますか?");');
    // LaravelのCSRFトークンを取得
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const csrfTokenInput = document.createElement('input');
    csrfTokenInput.setAttribute('type', 'hidden');
    csrfTokenInput.setAttribute('name', '_token');
    csrfTokenInput.setAttribute('value', csrfToken); // LaravelのCSRFトークンを設定
    form.appendChild(csrfTokenInput);
    return form;
}


let newIndex = 1; // 新しい行のインデックスを初期化

// 新しいカテゴリを追加する関数を定義
function addNewCategory() {
    const newRow = document.createElement('tr');

    newRow.innerHTML = `
        <td class="border px-4 py-2">
            <input type="number" name="new_secondary[${newIndex}][sort_order]" class="w-full bg-gray-100 rounded border border-gray-300 focus:outline-none focus:border-indigo-500 text-base px-3 py-2">
        </td>
        <td class="border px-4 py-2">
            <input type="text" name="new_secondary[${newIndex}][name]" class="w-full bg-gray-100 rounded border border-gray-300 focus:outline-none focus:border-indigo-500 text-base px-3 py-2">
        </td>
        <td class="border px-4 py-2 text-center">
            <button type="button" onclick="removeNewCategory(${newIndex})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">削除</button>
        </td>
    `;

    // フォームに新しい行を追加
    document.querySelector('tbody').appendChild(newRow);

    newIndex++; // インデックスを増やす

}

// 新しいカテゴリを削除する関数を定義
function removeNewCategory(index) {
    // 削除ボタンがクリックされたとき、該当する行を削除
    document.querySelector(`[name="new_secondary[${index}][sort_order]"]`).closest('tr').remove();
}

// ボタンがクリックされたときに情報を更新する関数を定義
function updatePost(element) {
    'use strict';
    if (confirm('情報を更新しても宜しいですか？')) {
        document.getElementById('update_' + element.dataset.id).submit();
    }
}
</script>
</x-app-layout>
