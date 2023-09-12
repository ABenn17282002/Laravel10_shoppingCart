<x-tests.app>
    {{-- view/component/tests/app.blade.php用header--}}
    <x-slot name="header">
        コンポーネントテスト1Heaeder
    </x-slot>
    {{-- view/component/tests/app.blade.php用コンポーネント--}}
    コンポーネントテスト1

    {{-- cardへ値を受け渡しをするコンポーネント  変数を渡す場合は:プロパティ名="$変数"--}}
    <x-tests.card  title="Component_test1" content="Component1の本文" :messages="$messages"/>
</x-tests.app>
