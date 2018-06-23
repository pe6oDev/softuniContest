<!--charset-а-->
<meta charset="utf-8"/>
<!--за  google search console-->
<meta name="google-site-verification" content="yhwEu6WaTgMEJ99oan1L9C_4LbsG689cwBGqzsV_uOg" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0"/>
<meta name="csrf-token" content="{{csrf_token()}}">
@if(!config('app.cache'))
<!--за предотвратяване на кефиране на страницата-->
<meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META HTTP-EQUIV="EXPIRES" CONTENT="0">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endif

<meta name="robots" content="all" />
<meta name="keywords" content="общност, заедно, интереси, игри, събития"/>
<meta name="description" content="Tова приложение помага на потребителите да открият хора, споделящи техните страсти и интереси."/>
<meta name='author' content="kolioPe6oDev"/>