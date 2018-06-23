@extends('layouts.welcome')

@section('title')
    @lang('Главна страница')
@endsection

@section('main')
    <br><br><br>
<div class="ui center aligned container">
   <div class="ui center aligned doubling grid">
      dash
   </div>
    <br><br><br>
</div>

@endsection

@push('scripts')
<script>
  var  hideSidebar = true;
</script>
<script src="{{asset('js/sideBar.js')}}"></script>
@endpush

@section('sidebar')
    @include('includes.profile.sidebar')
@endsection
