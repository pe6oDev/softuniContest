@extends('layouts.welcome')

@section('title')
    @lang('Главна страница')
@endsection

@section('main')
    <br><br><br>
    <div class="ui center aligned container">
        <div class="ui center aligned doubling grid">
            <div class="ui segment text container center aligned ">
                <div class="ui header">Скорошни известия <i class="ui bell blue icon"></i></div>
                <div class="ui celled list">
                    <div class="item">

                        <div class="content">
                            <div class="header">Увеличаваме таксата по кредита</div>
                            по случай скорошни финансови затруднения...
                        </div>
                    </div>
                    <div class="item">
                        <div class="content">
                            <div class="header">Увеличаваме таксата по кредита</div>
                            по случай скорошни финансови затруднения...
                        </div>

                    </div>
                    <div class="item">
                        <div class="content">
                            <div class="header">Увеличаваме таксата по кредита</div>
                            по случай скорошни финансови затруднения...
                        </div>
                    </div>
                </div>
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
