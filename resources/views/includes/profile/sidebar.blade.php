{{--Sidebar мену за профила--}}
@php
    use Illuminate\Support\Facades\Auth;
    $admin_id = \Illuminate\Support\Facades\Cookie::get('admin_id');
@endphp

{{--Бутон за покзаване на менюто--}}
<div style="background-color: rgb(255,255,255,.5); " class="ui fixed vertical menu">
    <a style="background-color: rgb(255,255,255,.5)" class="item">
        <div id="sideBarShowButton" class="ui icon  red  circular button fixed">
            <i class="ui large bars right  icon"></i>
        </div>
    </a>
</div>

{{--нужните script-ове и css файлове--}}
@push('header')
<link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
<script src="{{asset('js/profile.js')}}"></script>
@endpush


<div style="z-index: 10; display:none" id="sideBar"   class="ui sidebar  visible overlay  inverted segment">
    <div class="ui   grid">
        <div class="ui row">
            <div class="ui eight wide column left aligned">
            </div>
            {{--Бутон за скриване на sidebar-а--}}
            <div class="ui eight wide column right aligned">
                <div id="sideBarHideButton" class="ui icon  red circular button"><i class="ui arrow left  icon"></i>
                </div>
            </div>


        </div>

        <div class="ui row">
            <div class="ui eight wide column left">
                <div style="color: white" class="ui  header">
                    {{auth()->user()->email}}
                </div>
                <div id="profileEditButton" class="ui button circular icon" data-tooltip="редактирай" data-position="right center"><i
                            class="ui edit icon"></i></div>
               </div>
            </div>
        </div>
    <br><br>
    <div class="ui row">
        <div class="ui sixteen wide column">
            <a href="{{route('user.logout')}}">
                <div class="ui button fluid icon ">излез <i class="ui sign out icon"></i></div>
            </a>
            <br>
                <div class="ui divider"></div>
        </div>
    </div>
    <div class="ui row">
        <div class="ui sixteen wide column">
            <a>
                <div class="ui button fluid icon ">Меню буттон 1</div>
            </a>
            <br>
        </div>
    </div>


</div>

@include('includes.modals.profileEdit')