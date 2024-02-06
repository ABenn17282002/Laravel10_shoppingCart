<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>

{{-- Flassmessage --}}
<script>
$(function(){
    // 登録処理完了
    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    // 更新処理完了
    @elseif (Session::has('update'))
        toastr.info("{{ Session::get('update') }}");
    // ゴミ箱へ移動
    @elseif (Session::has('trash'))
        toastr.options =
        {
            "closeButton" : true,
            "positionClass": "toast-top-center",
        }
        toastr.warning("{{ Session::get('trash') }}");
    // ゴミ箱情報の完全削除
    @elseif (Session::has('delete'))
        toastr.options =
        {
            "closeButton" : true,
            "positionClass": "toast-top-center",
        }
        toastr.warning("{{ Session::get('delete') }}");
    // Error
    @elseif (Session::has('error'))
        toastr.options =
        {
            "closeButton" : true,
            "positionClass": "toast-top-center",
        }
        toastr.warning("{{ Session::get('error') }}");
    @endif

    // shop,image,product,cart情報
    @if (Session::has('info'))
        toastr.options =
        {
            "closeButton" : true,
            "positionClass": "toast-top-center",
        }
        toastr.info("{{ Session::get('info') }}");
    @elseif (Session::has('alert'))
        toastr.options =
        {
            "closeButton" : true,
            "positionClass": "toast-top-center",
        }
        toastr.warning("{{ Session::get('alert') }}");
    @endif
});
</script>
