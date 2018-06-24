@extends('layouts.welcome')

@section('title')
    @lang('Главна страница')
@endsection

@section('main')
    <br><br><br>
    <div class="ui center aligned container">
        <div class="ui center aligned doubling grid">
            <div class="ui segment text container center aligned ">
              <div class="header">Потребители - смяна на права</div>
            </div>
        </div>

        <admin-table
                :get-n="10"
                type="users"
                search-prompt='търси'
                nothing-found-mess="не бе открито нищо') :( ! "
                load-url="{{route('usersAjax')}}"
                change-type-url="{{route('changeUserType')}}"
                header-name="Потребители"
                load-more-label="зареди още"
                :table-headers="[
                'Email',
                'Създаден на',
                'Тип',
            ]"
                :keys="['email','created_at','type']"
                :show-total-num="true"
                {{--:row-width="[50,12,12,12,12]"--}}
                :no-search="[2,1]"
                {{--:no-sort="[4]"--}}
        ></admin-table>

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
