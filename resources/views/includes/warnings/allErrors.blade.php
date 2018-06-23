{{--Изкарва всички грешки от дадена backend валидация във списък --}}
@if($errors->all())
    <?php
    $hasConformationError = false;
    ?>

    <div class="ui visible error message">
        <div class='ui list'>
            @foreach ($errors->all() as $error)
                {{--за да не се изписва 2 пъти -"паролите не съвпадат"--}}
                @if(!($error=="паролите не съвпадат" && $hasConformationError==false))
                    <div class='ui item'><label>{{$error}}</label></div>
                @endif
                <?php
                if ($error == "паролите не съвпадат") {
                    $hasConformationError = true;
                }
                ?>
            @endforeach
        </div>

    </div>


@endif