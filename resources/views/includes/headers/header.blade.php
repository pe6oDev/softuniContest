@include('includes.headers.headerMeta')

<script>
    window.Laravel = {!! json_encode([
        'user' => Auth::user()??Auth::user(),
        'csrfToken' => csrf_token(),
        'vapidPublicKey' => config('webpush.vapid.public_key'),
        'pusher' => [
            'key' => config('broadcasting.connections.pusher.key'),
            'cluster' => config('broadcasting.connections.pusher.options.cluster'),
        ],
    ]) !!};
</script>


{{--<script src="{{asset('js/jquery.min.js')}}{{config('app.cache')? '':'?'.str_random()}}"></script>--}}

<script
        src="https://code.jquery.com/jquery-3.2.1.js"
        integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

<link rel="stylesheet" href="{{asset('css/main.css')}}">


@if(isset($scripts))

    @foreach ($scripts as $script )
        @if (config('app.cache'))
            <script src="{!!$script!!}"></script>
        @else
            <script src="{!!$script!!}?{{str_random()}}"></script>
        @endif
    @endforeach
@endif

@include('includes.headers.headerSemantic')

@if(isset($styles))

    @foreach ($styles as $style )
        @if (config('app.cache'))
            <link href="{!!$style!!}" rel="stylesheet">
        @else
            <link href="{!!$style!!}?{{str_random()}}" rel="stylesheet">
        @endif
    @endforeach
@endif


@if (config('app.cache'))
    <script src="{{asset('js/main.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
@else
    <script src="{{asset('js/main.js')}}?{{str_random()}}"></script>
    <link rel="stylesheet" href="{{asset('css/main.css')}}?{{str_random()}}">
@endif

{{--За смяната на картинките на сезоните--}}
<style>
    #app{
        background-image: url('{{asset('images/'.season().'.jpg')}}')
    }
</style>