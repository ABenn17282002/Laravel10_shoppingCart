<x-tests.app>
    {{-- view/component/tests/app.blade.php用header--}}
    <x-slot name="header">
        コンポーネントテスト2Heaeder
    </x-slot>
    {{-- view/component/tests/app.blade.php用コンポーネント--}}
    コンポーネントテスト2

    {{-- cardへ値を受け渡しをするコンポーネント 変数を渡す場合は:プロパティ名="$変数"---}}
    <x-tests.card  title="Component2" content="Component2の本文" :messages="$messages"/>
</x-tests.app>
