@php
/* php関数を使用しpathを変数化する */
// shopsの場合：'storage/shops/'
if($type ==="shops"){
    $path = 'storage/shops/';
}

// productsの場合：'storage/products/'
if($type === 'products'){
    $path = 'storage/products/';
}
@endphp


{{-- 画像の取得コンポーネント --}}
<div>
    {{-- 空の場合:no_image --}}
    @if(empty($filename))
        <img src="{{ asset('images/no_image.jpg')}}">
    @else
    {{-- それ以外は変数によりpathを取得 --}}
        <img src="{{ asset($path . $filename)}}">
    @endif
</div>
