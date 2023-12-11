<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            カテゴリ情報編集画面
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <section class="text-gray-600 body-font relative">
                    <div class="container px-5 py-20 mx-auto">
                        <form id="editForm" action="" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- プライマリーカテゴリーの編集 --}}
                            <div class="mb-4">
                                <label for="primary_name" class="text-sm text-gray-600">プライマリーカテゴリー:</label>
                                <input type="text" id="primary_name" name="primary_name" value="{{ $primaryCategory->name }}" class="w-full bg-gray-100 rounded border border-gray-300" required>
                            </div>

                            {{-- 既存のセカンダリーカテゴリーの編集 --}}
                            <label class="text-sm text-gray-600">既存セカンダリーカテゴリ編集：</label>
                            @if (count($secondaryCategories) > 0)
                                @foreach ($secondaryCategories as $secondaryCategory)
                                    <div class="mb-4">
                                        <input type="text" name="secondary[{{ $secondaryCategory->id }}]" value="{{ $secondaryCategory->name }}" class="w-full bg-white rounded border border-gray-300 focus:outline-none focus:border-indigo-500 text-base px-4 py-2">
                                    </div>
                                @endforeach
                            @else
                                <p class="text-left mb-4">作成済みSeconadaryCatergory情報はありません。</p>
                            @endif

                            {{-- 新しいセカンダリーカテゴリーの追加 --}}
                            <div class="mb-4">
                                <label class="text-sm text-gray-600">新規セカンダリーの登録：</label>
                                <input type="text" name="new_secondary[]" value="" class="w-full bg-white rounded border border-gray-300 focus:outline-none focus:border-indigo-500 text-base px-4 py-2">
                                <button type="button" onclick="addNewCategory()">+ 追加</button>
                            </div>

                            <div class="flex justify-end">
                                <button type="button" onclick="location.href='{{ route('admin.categories.index')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">更新する</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<script>
    function addNewCategory() {
        // 新しい入力フィールドを含む div 要素を作成
        let newInputDiv = document.createElement('div');
        newInputDiv.className = 'mb-4 flex items-center space-x-2';

        // input 要素を作成
        let input = document.createElement('input');
        input.type = 'text';
        input.name = 'new_secondary[]';
        input.className = 'w-11/12 bg-white rounded border border-gray-300 focus:outline-none focus:border-indigo-500 text-base px-3 py-2';

        // 削除ボタンを作成
        let removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.textContent = '削除';
        removeButton.className = 'bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded';
        removeButton.onclick = function() {
            // このボタンの親要素（div）を削除
            newInputDiv.remove();
        };

        // div に input と削除ボタンを追加
        newInputDiv.appendChild(input);
        newInputDiv.appendChild(removeButton)

        // 新しいdiv要素をフォームに追加
        let form = document.querySelector('#editForm'); // ここでフォームを適切に選択
        form.insertBefore(newInputDiv, form.lastElementChild);
    }
</script>
</x-app-layout>
