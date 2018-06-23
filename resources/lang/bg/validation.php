<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | The following language lines contain the default error messages used by
      | the validator class. Some of these rules have multiple versions such
      | as the size rules. Feel free to tweak each of these messages here.
      |
     */

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'Полето за  :attribute трябва да е дата след :date.',
    'alpha' => ':attribute може да съдържа само букви.',
    'alpha_dash' => ':attribute не може да съдържа специални знаци и разстояние',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'Полете за :attribute трябва да задържа между :min и :max знака.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => ' :attribute не съвпада с полето за потвърждение',
    'date' => 'Полето за :attribute не е валидна дата',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'Полето за :attribute трябва да бъде дълго точно :digits цифри.',
    'digits_between' => 'Полето за :attribute трябва да съдържа между :min и :max знака.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'Полето  трябва да  е валиден E-mail адрес.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'В :attribute трябва да има продукти.',
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'Полето за :attribute трябва да е цяло число.',
    'ip' => 'The :attribute must be a valid IP address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'max' => [
        'numeric' => ':attribute не трябва да е по-голямо от :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => ':attribute не тябва да надвишава :max символа.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => ':attribute трябва да е поне :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => ':attribute трябва да е поне :min символа.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'Полето за :attribute е задължително.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values is present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => ':attribute вече е заето',
    'uploaded'             => 'Неуспешно качане на файловете',
    'url' => 'The :attribute format is invalid.',
    'password' => 'Въвели сте грешна парола',
    'float' => "Трябва да имате до 2 знака след запетаята",
    'phone' => 'Невалиден телефонен номер',
    'supplier'=>'Невалиден доставчик',

    /*
      |--------------------------------------------------------------------------
      | Custom Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | Here you may specify custom validation messages for attributes using the
      | convention "attribute.rule" to name the lines. This makes it quick to
      | specify a specific custom language line for a given attribute rule.
      |
     */
    'custom' => [

        'passwords'=>[
            'confirmed'=>'паролите не съвпадат'
        ],

        'password_confirmation' => [
            'same' => 'паролите не съвпадат'
        ],
        'pass_confirmation' => [
            'same' => 'паролите не съвпадат'
        ],
        'password' => [
            'confirmed' => 'паролите не съвпадат'
        ],

        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'topic'=>[
            'integer'=>'Недей да ръчкаш инспектора!',
        ],

        'previousDate'=>[
            'before'=>'Полето за :attribute трябва да преди днешната дата',
            'after'=>'Полето за :attribute трябва да е дата след 1900 година',
        ],
        'username' => [
            'unique' => 'Потребителското име  е заето',
        ],
        'email' => [
            'unique' => 'Електронната поща е заета',
        ],
        'password_confirmation' => [
            'same' => 'паролите не съвпадат'
        ],
        'pass_confirmation' => [
            'same' => 'паролите не съвпадат'
        ],
        'value' => [
            'unique'=>'вече е заето',
            'required' => 'трябва да въведете нещо',
            'email' => 'трябва да въведете валиден Е-mail адрес',
//            'oldPass' => [
//                'required' => 'полето е задължително'
//            ],
//            'newPass' => [
//                'required' => 'полето е задължително',
//                'same' => 'паролите не отговарят',
//                'min' => 'паролата трябва де поне :min символа',
//                'max' => 'паролата не трябва да надвишава :max символа'
//            ],
            'confPass' => [
                'required' => 'полето е задължително',
                'same' => 'паролите не отговарят',
            ],
        ],
        'maxNumberImages'=>'твърде много изображения ( до :number разрешени )'
    ],
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Attributes
      |--------------------------------------------------------------------------
      |
      | The following language lines are used to swap attribute place-holders
      | with something more reader friendly such as E-Mail Address instead
      | of "email". This simply helps us make messages a little cleaner.
      |
     */
    'attributes' => [
        'images'=>'изображения',
        'newPass'=>'новата парола',
        'pass'=>'парола',
        'oldPass'=>'старата парола',
        'dateTo'=>'дата',
        'nextNumber'=>'пореден номер',
        'photo'=>'качване на снимка',
        'product_price'=>'цена на продукта',
        'product_name'=>'име на продукта',
        'product_info'=>'описание на продуката',
        'product_type' => 'вид на продукта',
        'lensesModel' => 'модел диоптрични лещи',
        'orderNumber' => 'номер поръчка',
        'previousDate' => 'задна дата',
        'framesModel' => 'модел на рамки',
        'serviceModel' => 'вид услуга',
        'lensesPrice' => 'цена на диоптричните лещи',
        'framesPrice' => 'цена на рамката',
        'servicePrice' => 'цена на услугата',
        'name'=>'името',
        'message'=>'съобщение',
        'topic'=>'тема',
        'email' => 'електронна поща',
        'username' => 'потребителското име',
        'password' => 'паролата',
        'password_confirmation' => 'потвърждение на паролата',
        'first_name' => 'името',
        'last_name' => 'фамилията',
        'second_name' => 'презимето',
        'firstName' => 'името',
        'thirdName' => 'фамилията',
        'secondName' => 'презимето',
        'phone' => 'телефона',
        'accessKey'=>'код за достъп',
        'value' => ' ',
        'glassesModel' => 'модела на стъклата',
        'startHour' => 'начален час',
        'startMinutes' => 'начални минути',
        'endHour' => 'краен час',
        'endMinutes' => 'крайни минути',
        'companyName'=>'име на фирма/лицето',
        'companyNumber'=>'идентификационен номер',
        'companyMol'=>'МОЛ',
        'companyAddress'=>'адрес на фирмата',
        'address'=>'адрес',
        'postal'=>'пощенски код',
        'receiverName'=>'име на получателя',
        'receiverPhone'=>'телефон на получателя',
        'text' => 'текст',
        'image'=>'изображение'
    ],
];