<x-app-layout>
    {{-- Owner/image/create.blade.php引用、一部変更 --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            画像情報編集画面
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Error_message --}}
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    {{-- 画像編集,imageId取得--}}
                    <form method="post" action="{{ route('owner.images.update', ['image' => $image->id ])}}" enctype="multipart/form-data">
                            @csrf
                            {{-- 一部編集の際はPUTMethod使用 --}}
                            @method('PUT')
                            <div class="-m-2">
                                {{-- 画像タイトル --}}
                                <div class="p-2 w-1/2 mx-auto">
                                    <div class="relative">
                                        <label for="title" class="leading-7 text-sm text-gray-600">画像タイトル</label>
                                        <input type="text" id="title" name="title" value="{{ $image->title }}"class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                {{-- 古い画像のサムネイル --}}
                                <div class="p-2 w-1/2 mx-auto">
                                    <div class="relative">
                                        <label for="title" class="leading-7 text-sm text-gray-600">現在のサムネイル画像</label>
                                        <x-thumbnail :filename="$image->filename" type="products" />
                                    </div>
                                </div>
                                {{-- 新しい画像ファイルのアップロード --}}
                                <div class="p-2 w-1/2 mx-auto">
                                    <div class="relative">
                                        <label for="image" class="leading-7 text-sm text-gray-600">新しい画像ファイル</label>
                                        <input type="file" id="image" name="image" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" onchange="previewImage()">
                                        <img id="newImagePreview" src="#" alt="新しい画像プレビュー" class="hidden w-full mt-2">
                                    </div>
                                </div>
                                <div class="w-full flex justify-around mx-auto">
                                        <div class="p-2 w-1/2 flex justify-around mt-4">
                                            {{-- 戻る --}}
                                            <button type="button" onclick="location.href='{{ route('owner.images.index')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                            {{-- 更新用ボタン --}}
                                            <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                                        </div>
                                        <div class="p-2 w-1/2 flex justify-around mt-4">
                                            {{-- data-id=>image_id取得 ==>onclickで削除実行 --}}
                                            <a href="#" data-id="{{ $image->id }}" onclick="deletePost(this)" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded ">削除する</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- 削除用ボタン --}}
                    <form id="delete_{{ $image -> id }}" method="post" action="{{ route('owner.images.destroy', ['image' => $image->id])}}">
                        @csrf
                        {{-- 削除メソッド --}}
                        @method('delete')
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage() {
            var oFReader = new FileReader();
            // ImageのURLを取得
            oFReader.readAsDataURL(document.getElementById("image").files[0]);
            // 画像のソースを取得し表示する
            oFReader.onload = function (oFREvent) {
                document.getElementById("newImagePreview").src = oFREvent.target.result;
                document.getElementById("newImagePreview").style.display = 'block';
            };
        };
        // 削除確認モーダル
        function deletePost(e) {
            'use strict';
            if (confirm('本当に削除してもいいですか?')) {
            document.getElementById('delete_' + e.dataset.id).submit();
            }
        }
    </script>
</x-app-layout>
