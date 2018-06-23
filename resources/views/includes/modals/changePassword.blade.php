{{--Модал за смяна на паролата--}}
<change-password
        change-pass-url="{{route('changePass')}}"
        password-confirmation-error="паролите не съвпадат"
        success-message="успешно променихте паролата си"
        ok-label="готово"
        cancel-label="отказ"
        input-translated ="въведи"
        оld-pass-label ="стара парола"
        new-pass-label="нова парола"
        header="смени паролата"
></change-password>
