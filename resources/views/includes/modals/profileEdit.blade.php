{{--Модал за редакция на профила--}}
{{--от тук се вика модала за смяна/задаване на паролата--}}
<div id="profilеЕditModal" class=" ui    modal">
    <i class="close icon"></i>
    <div class=" header ">Редактирай профила</div>
    <div class="content">
        @if(auth()->user()->password)
            <div id="changePassButton" class="ui button">смени паролата</div>
        @else
            <div id="makePassButton" class="ui button">сложи парола</div>
        @endif
        <br><br><br>

            <user-info prop-info="{{auth()->user()->more_info}}"></user-info>


    </div>
</div>
@if(auth()->user()->password)
    @include('includes.modals.changePassword')
@else
    @include('includes.modals.makePasswordModal')
@endif