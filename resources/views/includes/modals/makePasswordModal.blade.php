{{--Модал за задаване на паролата (някои потребители нямат парола, защото са се регистригали с google )--}}
<make-password
        make-pass-url="{{route('setPass')}}"
        success-message="успешно сложихте парола"
        ok-label="Готово"
        cancel-label="Отказ"
        input-translated ="въведи"
        new-pass-label="@lang('validation.attributes.pass')"
        password-confirmation-error="паролите не съвпадат"
        header="сложи паролата"
></make-password>
