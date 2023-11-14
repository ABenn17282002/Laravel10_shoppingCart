{{-- 画像の取得コンポーネント --}}
<div>
    {{-- 空の場合:no_image それ以外はstorage/shops/からファイル名取得して表示--}}
    @if(empty($filename))
        <img src="{{ asset('images/no_image.jpg')}}">
    @else
        <img src="{{ asset('storage/shops/' . $filename)}}">
    @endif
</div>
