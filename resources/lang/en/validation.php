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

    'accepted' => ':attribute debe ser aceptado.',
    'active_url' => ':attribute no es una URL valida.',
    'after' => ':attribute debe ser posterior a :date.',
    'after_or_equal' => ':attribute debe ser menor o igual a :date.',
    'alpha' => ':attribute deben ser solo letras.',
    'alpha_dash' => ':attribute deben ser letras, numeros, - y _',
    'alpha_num' => ':attribute deben ser solo letras y numeros.',
    'array' => ':attribute debe ser un array.',
    'before' => ':attribute debe ser una fecha previa a :date.',
    'before_or_equal' => ':attribute debe ser una fecha previa o igual a :date.',
    'between' => [
        'numeric' => ':attribute debe ser de entre :min y :max.',
        'file' => ':attribute debe ser de entre :min y :max kilobytes.',
        'string' => ':attribute debe ser de entre :min y :max characters.',
        'array' => ':attribute debe ser de entre :min y :max items.',
    ],
    'boolean' => ':attribute el campo debe ser verdadero o falso.',
    'confirmed' => ':attribute la confirmación no coincide.',
    'date' => ':attribute no es una fecha valida.',
    'date_equals' => ':attribute debe ser igual a :date.',
    'date_format' => ':attribute no tiene el formato :format.',
    'different' => ':attribute y :other deben ser diferentes.',
    'digits' => ':attribute debe ser de :digits digitos.',
    'digits_between' => ':attribute debe tener entre :min y :max digitos.',
    'dimensions' => ':attribute tiene dimensiones de imagen invalidas.',
    'distinct' => ':attribute tiene un valor duplicado.',
    'email' => ':attribute debe ser un mail valido.',
    'exists' => ':attribute seleccionado no es valido.',
    'file' => ':attribute debe ser un archivo.',
    'filled' => ':attribute debe tener un valor.',
    'gt' => [
        'numeric' => ':attribute debe ser mayor a :value.',
        'file' => ':attribute debe ser mayor a :value kilobytes.',
        'string' => ':attribute debe ser mayor a :value caracteres.',
        'array' => ':attribute debe tener mas un :value items.',
    ],
    'gte' => [
        'numeric' => ':attribute debe ser mayor o igual a :value.',
        'file' => ':attribute debe ser mayor a :value kilobytes.',
        'string' => ':attribute debe ser mayor o igual a :value caracteres.',
        'array' => ':attribute debe tener:value items o mas.',
    ],
    'image' => ':attribute debe ser una imagen.',
    'in' => 'El :attribute seleccionado es invalido.',
    'in_array' => ':attribute no existe en :other.',
    'integer' => ':attribute debe ser entero.',
    'ip' => ':attribute debe ser una IP valida.',
    'ipv4' => ':attribute debe ser una direccion IPv4 valida.',
    'ipv6' => ':attribute debe ser una direccion IPv6 valida.',
    'json' => ':attribute debe ser una direccion JSON valido.',
    'lt' => [
        'numeric' => ':attribute debe ser menor a :value.',
        'file' => ':attribute debe ser menor o igual aa :value kilobytes.',
        'string' => ':attribute debe ser menor o igual a :value caracteres.',
        'array' => ':attribute debe ser menor a :value items.',
    ],
    'lte' => [
        'numeric' => ':attribute debe ser menor o igual a :value.',
        'file' => ':attribute debe ser menor o igual a :value kilobytes.',
        'string' => ':attribute debe ser menor o igual a :value caracteres.',
        'array' => ':attribute debe ser menor a :value items.',
    ],
    'max' => [
        'numeric' => ':attribute no debe superar :max.',
        'file' => ':attribute no debe ser mayor a :max kilobytes.',
        'string' => ':attribute no debe ser mayor a :max caracteres.',
        'array' => ':attribute no debe tener mas de :max items.',
    ],
    'mimes' => ':attribute debe ser un tipo de archivo: :values.',
    'mimetypes' => ':attribute debe ser un tipo de archivo: :values.',
    'min' => [
        'numeric' => ':attribute debe ser como minimo :min.',
        'file' => ':attribute debe ser como monimo :min kilobytes.',
        'string' => ':attribute debe ser como monimominimo :min caracteres.',
        'array' => ':attribute debe ser como minimo :min items.',
    ],
    'not_in' => ':attribute seleccionado es invalido.',
    'not_regex' => ':attribute formato invalido',
    'numeric' => ':attribute debe ser un numero.',
    'present' => ':attribute el campo debe estrar presente.',
    'regex' => ':attribute esun formato invalido.',
    'required' => ':attribute es un campo requerido.',
    'required_if' => ':attribute es un campo requerido cuando :other es :value.',
    'required_unless' => ':attribute es un campo obligatorioa menos que :other es :values.',
    'required_with' => ':attribute es un campo requerido cuando :values esta presente.',
    'required_with_all' => ':attribute es un campo requerido cuando :values esta presente.',
    'required_without' => ':attribute es un campo requerido cuando :values no está presente.',
    'required_without_all' => ':attribute es un campo requerido cuando :values no esta presente.',
    'same' => ':attribute y :other deben ser iguales.',
    'size' => [
        'numeric' => ':attribute debe tener :size.',
        'file' => ':attribute debe ser :size kilobytes.',
        'string' => ':attribute debe ser :size caracteres.',
        'array' => ':attribute debe contener :size items.',
    ],
    'starts_with' => ':attribute debe comenzar con uno de los siguientes: :values',
    'string' => ':attribute debe ser string.',
    'timezone' => ':attribute no es una zona valida.',
    'unique' => ':attribute ya existe.',
    'uploaded' => ':attribute falló en la subida.',
    'url' => ':attribute formato invalido.',
    'uuid' => ':attribute debe ser UUID valido.',

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
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    // 'attributes' => [],
    'attributes' => array(
                        'file-seccion-una-a'=>'Imagen uno',
                        'file-seccion-una-a-upload-manual' => 'Video uno template 1 subida manual ',

                        'file-seccion-tres-a'=>'Imagen uno template 3',
                        'file-seccion-tres-a-upload-manual' => 'Video uno template 3 subida manual ',
                        'file-seccion-tres-b'=>'Imagen dos template 3',
                        'file-seccion-tres-b-upload-manual' => 'Video dos template 3 subida manual ',
                        'file-seccion-tres-c'=>'Imagen tres template 3',
                        'file-seccion-tres-c-upload-manual' => 'Video tres template 3 subida manual ',

                        'file-seccion-cuatro-a'=>'Imagen uno template 4',
                        'file-seccion-cuatro-a-upload-manual' => 'Video uno template 4 subida manual ',
                        'file-seccion-cuatro-b'=>'Imagen uno template 4',
                        'file-seccion-cuatro-b-upload-manual' => 'Video dos template 4 subida manual ',
                        'file-seccion-cuatro-c'=>'Imagen uno template 4',
                        'file-seccion-cuatro-c-upload-manual' => 'Video tres template 4 subida manual ',
                        'file-seccion-cuatro-d'=>'Imagen uno template 4',
                        'file-seccion-cuatro-d-upload-manual' => 'Video cuatro template 4 subida manual ',
                        )
];
