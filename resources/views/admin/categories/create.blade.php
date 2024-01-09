<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            新規カテゴリー情報の登録
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-20 mx-auto">
                            <form id="createForm" action="{{ route('admin.categories.store')}}" method="POST">
                                @csrf
                                {{-- プライマリーカテゴリーの登録 --}}
                                @if ($errors->any())
                                <div>
                                    <ul>
                                    @if ($errors->has('primary_name'))
                                        <li style="color: red;">{{ $errors->first('primary_name') }}</li>
                                    @endif
                                    @if ($errors->has('primary_sort_order'))
                                        <li style="color: red;">{{ $errors->first('primary_sort_order') }}</li>
                                    @endif
                                    </ul>
                                </div>
                                @endif
                                <label class="text-sm text-gray-600">プライマリーカテゴリ情報の入力</label>
                                <div class="mb-4 flex">
                                    {{-- Primary Category sort_order --}}
                                    <div class="w-1/6">
                                        <label for="primary_sort_order" class="text-sm text-gray-600">ソート順</label>
                                        <input type="number" id="primary_sort_order" name="primary_sort_order" value="{{ old('primary_sort_order') }}" class="w-full bg-gray-100 rounded border border-gray-300" required>
                                    </div>
                                    {{-- Primary Category name --}}
                                    <div class="w-5/6 mr-4">
                                        <label for="primary_name" class="text-sm text-gray-600">カテゴリー名</label>
                                        <input type="text" id="primary_name" name="primary_name" value="{{ old('primary_name') }}" class="w-full bg-gray-100 rounded border border-gray-300" required>
                                    </div>
                                </div>

                                {{-- 既存のセカンダリーカテゴリーの編集 --}}
                                <div class="overflow-x-auto mb-20">
                                    @if ($errors->any())
                                    <div>
                                        <ul>
                                        @if ($errors->has('new_secondary.*.name'))
                                            <li style="color: red;">{{ $errors->first('new_secondary.*.name') }}</li>
                                        @endif
                                        @if ($errors->has('new_secondary.*.sort_order'))
                                            <li style="color: red;">{{ $errors->first('new_secondary.*.sort_order') }}</li>
                                        @endif
                                        </ul>
                                    </div>
                                    @endif
                                    <label class="text-sm text-gray-600">セカンダリーカテゴリー情報</label>
                                    <table class="min-w-full bg-white">
                                        <thead class="bg-gray-800 text-white">
                                            <tr>
                                                <th class="w-1/12 py-3 px-4 text-left">順序</th>
                                                <th class="w-10/12 py-3 px-4 text-left">カテゴリー名</th>
                                                <th class="w-1/12 py-3 px-4 text-left"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-700">
                                            <tr id="newCategoryRow">
                                                <td class="border px-4 py-2">
                                                    <input type="number" name="new_secondary[0][sort_order]" value="{{ old('new_secondary[0][sort_order]') }}" class="w-full bg-gray-100 rounded border border-gray-300 focus:outline-none focus:border-indigo-500 text-base px-3 py-2">
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input type="text" name="new_secondary[0][name]" value="{{ old('new_secondary[0][name]') }}" class="w-full bg-gray-100 rounded border border-gray-300 focus:outline-none focus:border-indigo-500 text-base px-3 py-2">
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <button type="button" onclick="addNewCategory(0)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">追加</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="flex justify-end">
                                    <button type="button" onclick="location.href='{{ route('admin.categories.index')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">登録する</button>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script>
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
</script>
</x-app-layout>
