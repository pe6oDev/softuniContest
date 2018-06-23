@extends('layouts.welcome')

@section('title')
    @lang('Главна страница')
@endsection

@section('main')
    <br><br><br>
    <div class="ui center aligned container">
        <div class="ui center aligned doubling grid">
            <div class="ui segment text container center aligned ">
              Тука трябва да се показват потребителите и да може да им се сменят правата
                (видимо само за админи!) //Трябва да сложа midleware :D
            </div>
        </div>
        <br><br><br>
    </div>

@endsection

@push('scripts')
<script>
    var hideSidebar = true;
</script>
<script src="{{asset('js/sideBar.js')}}"></script>
@endpush

@section('sidebar')
    @include('includes.profile.sidebar')
@endsection
