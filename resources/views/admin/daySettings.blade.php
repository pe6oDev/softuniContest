@extends('layouts.welcome')

@section('title')
    @lang('Главна страница')
@endsection

@section('main')
    <br><br><br>
    <div class="ui center aligned container">
        <div id="touchzone" class="ui one column center aligned stackable grid" style="background-color: rgba(255,255,255,0.8)">
            <div class="ui row">
                <div class="thirteen wide column">
                    <h2 class="header">Настройки за неработни дни</h2>
                </div>
            </div>
            <day-settings></day-settings>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    var hideSidebar = true;
</script>
<script src="{{asset('js/sideBar.js')}}"></script>
<script src="{{asset('js/daySettings.js')}}"></script>
@endpush

@section('sidebar')
    @include('includes.profile.sidebar')
@endsection
