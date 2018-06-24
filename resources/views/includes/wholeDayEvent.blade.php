<div id="{{$id}}" class="ui one column row">
    <div class="ui column">
        <div class="ui {{$color}} segment inverted fluid ">
            @if(isset($header))
                <div class="ui">{{$header}}</div>
            @endif
        </div>
    </div>
</div>
@if(isset($description))


    <div  class="ui  popup">
        <div class="header " style="z-index: 1000">{{$description}}</div>
    </div>
    @push('header')
    <script>
        $(document).ready(function () {
            $('#{{$id}}')
                .popup({
                    position: "top center"
                });
        });

    </script>
    @endpush
@endif