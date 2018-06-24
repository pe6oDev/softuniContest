@inject('calendar', 'App\Calendar')
@php
        $defName =  __('списък') ." ".date('d/m/Y (G:i)'); // името което се дава по подразбиране
        $months =$calendar::getMonths();
@endphp
{{--Модал за създаване или редактиране на събитие--}}
<event-modal
        id="{{$id}}"
        post-url="{{route('postEvent')}}"
        {{--edit-url="{{route('editEvent')}}"--}}
        :months="{{json_encode ($months)}}"
        @if($id === "editModal")
        ref="editModal"
        @endif
        day-id="{{$dayId}}"
        month-id="{{$monthId}}"
        header = "@lang($type)"
        date = ""
        question = "Какво ще правиш?"
        beginning="Начало"
        hour = "Час"
        minutes = "Минути"
        end = "Край"
        duration = "Продължителност"
        save = "Запиши"
        no = "Не"
        the-hours = "Часовете"
        the-minutes = "Минутите"
        not-valid = "не са валидни"
        notif-text = "Известия"
        at-start = "В началото на събитието"
        hour-before = "час преди началото"
        hours-before = "часа преди началото"
        other = "Другo.."
        notif-time = "Време на известието"
        add-text = "Добави"
        max-num-of-notifications = "{{config('app.notification_limit')}}"
></event-modal>