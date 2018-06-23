@php
    // текста за header-a и бутона
        if(isset($logIn) && $logIn ){
        $text="Влез";
        }else{
         $text="Регистрирай се безплатно";
        }
@endphp

<form action="{{ isset($logIn) && $logIn  ?route('logIn'): route('signUp')}}" method="POST" class="ui form">
    <!--header-->
    <div class="ui big header">
        {{$text}}
    </div>
    <!--бутон-->
    <div id="googleLogInButton" class="ui fluid basic button">
        <i class="google  icon"></i>
        {{$text}}

        @lang('с') Google
    </div>
    <!--divider-->
    <div class="ui horizontal divider">
        @lang('или')
    </div>
    <div class="ui fluid  input field">
        <input type="text" name="email" value="{{old('email')}}" placeholder="email">
    </div>
    <br>
    <div class="ui fluid  input field">
        <input type="password" name="password" placeholder="@lang('парола')">
    </div>
    <br>
    {{--Поле за потвърждение на паролата (ако формата е за регистрация )--}}
    @unless(isset($logIn) && $logIn )
        <div style="display: none" class="ui fluid  input field">
            <input type="password" name="password_confirmation" placeholder="@lang('потвърдете паролата')">
        </div>
    @endunless

    <div class="ui error message"></div>

    @if($errors->any() )
        @include('includes.warnings.allErrors')
    @endif
    <br>
    <button id="signUpButton" class="ui big fluid button orange">
        {{$text}}
    </button>

    {{csrf_field()}}

</form>

@push('header')

@php
    $passArr=[
      'en'=>'password',
      'bg'=>'парола',
    //  'de'=>''
    ];
@endphp


<script>
            {{--php променливите, които се ползват от front end валидацията--}}
    var signUpFormVariables = {
            'authUser':{{auth()->check()?'true':'false'}},
            'googleLogInRoute': "{{route('googleLogIn')}}",
            'CalendarRoute': "dashboard",
            'CheckEmailUniqueRoute': '{{route('checkEmailUnique')}}',
            'logIn':{{isset($logIn) && $logIn? 'true' : 'false'}},
            'validation': {
                'email': {
                    'emailPrompt': '@lang('validation.email',['attribute' => 'filed'])',
                    'uniquePrompt': '@lang('validation.custom.email.unique')',
                },
                'password': {
                    'emptyPrompt': '@lang('validation.required',['attribute' =>$passArr[App::getLocale()]])',
                    'minLenghtPrompt': '@lang('validation.min.string',['attribute' =>$passArr[App::getLocale()],'min'=>6])'
                },
                'password_confirmation': {
                    'matchPrompt': '@lang('validation.custom.password_confirmation.same')'
                }
            }
        };

</script>

<style>
    .ui.error *:first-letter {
        text-transform: uppercase;
    }
</style>

@endpush