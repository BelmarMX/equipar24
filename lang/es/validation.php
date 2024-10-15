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

    'accepted' => 'El valor del campo :attribute debe ser aceptado.',
    'accepted_if' => 'El valor del campo :attribute debe ser aceptado cuyo :other es/está :value.',
    'active_url' => 'El valor del campo :attribute debe ser una URL válida.',
    'after' => 'El valor del campo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El valor del campo :attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => 'El valor del campo :attribute solo debe contener letras.',
    'alpha_dash' => 'El valor del campo :attribute solo debe contener letras, números y guiones.',
    'alpha_num' => 'El valor del campo :attribute solo debe contener letras y números',
    'array' => 'El valor del campo :attribute debe ser un arreglo.',
    'ascii' => 'El valor del campo :attribute solo debe contener caracteres alfanuméricos y símbolos single-byte.',
    'before' => 'El valor del campo :attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => 'El valor del campo :attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'array' => 'El valor del campo :attribute debe estar entre los elementos :min y :max.',
        'file' => 'El valor del campo :attribute debe pesar entre :min y :max kilobytes.',
        'numeric' => 'El valor del campo :attribute debe estar entre :min y :max.',
        'string' => 'El valor del campo :attribute debe estar entre los caracteres :min y :max.',
    ],
    'boolean' => 'El valor del campo :attribute debe ser true o false.',
    'can' => 'El valor del campo :attribute contiene un valor no autorizado.',
    'confirmed' => 'El valor del campo :attribute no concuerda con la confirmación.',
    'contains' => 'El valor del campo :attribute es un valor requerido.',
    'current_password' => 'La contraseña es incorrecta.',
    'date' => 'El valor del campo :attribute debe ser una fecha válida.',
    'date_equals' => 'El valor del campo :attribute debe ser una fecha igual a :date.',
    'date_format' => 'El valor del campo :attribute debe seguir el formato correcto :format.',
    'decimal' => 'El valor del campo :attribute debe tener :decimal dígitos decimales.',
    'declined' => 'El valor del campo :attribute debe ser rechazado.',
    'declined_if' => 'El valor del campo :attribute debe ser rechazado cuando :other es/está :value.',
    'different' => 'El valor del campo :attribute y :other deben ser diferentes.',
    'digits' => 'El valor del campo :attribute debe tener :digits dígitos.',
    'digits_between' => 'El valor del campo :attribute debe estar entre los dígitos :min y :max.',
    'dimensions' => 'El valor del campo :attribute tiene dimensiones de imagen inválidas.',
    'distinct' => 'El valor del campo :attribute tiene un valor duplicado.',
    'doesnt_end_with' => 'El valor del campo :attribute no debe terminar en alguno de los siguientes valores: :values.',
    'doesnt_start_with' => 'El valor del campo :attribute no debe comenzar con alguno de los siguientes valores: :values.',
    'email' => 'El valor del campo :attribute debe ser una dirección de correo válida.',
    'ends_with' => 'El valor del campo :attribute debe terminar en alguno de los siguientes valores: :values.',
    'enum' => 'El elemento seleccionado :attribute es inválido.',
    'exists' => 'El elemento seleccionado :attribute es inválido.',
    'extensions' => 'El valor del campo :attribute debe tener una de las siguientes extensiones: :values.',
    'file' => 'El valor del campo :attribute debe ser un archivo.',
    'filled' => 'El valor del campo :attribute debe contener un valor.',
    'gt' => [
        'array' => 'El valor del campo :attribute debe tener mas de :value elemento(s).',
        'file' => 'El valor del campo :attribute debe pesar más de :value kilobytes.',
        'numeric' => 'El valor del campo :attribute debe ser mayor a :value.',
        'string' => 'El valor del campo :attribute debe tener más de :value caracter(es).',
    ],
    'gte' => [
        'array' => 'El valor del campo :attribute debe tener :value elemento(s) o más.',
        'file' => 'El valor del campo :attribute debe tener un peso mayor o igual a :value kilobytes.',
        'numeric' => 'El valor del campo :attribute debe ser mayor o igual a :value.',
        'string' => 'El valor del campo :attribute debe ser mayor o igual a :value caracter(es).',
    ],
    'hex_color' => 'El valor del campo :attribute must be a valid hexadecimal color.',
    'image' => 'El valor del campo :attribute debe ser una imagen.',
    'in' => 'El elemento seleccionado :attribute es inválido.',
    'in_array' => 'El valor del campo :attribute debe existir en :other.',
    'integer' => 'El valor del campo :attribute debe ser un entero.',
    'ip' => 'El valor del campo :attribute debe ser una IP válida.',
    'ipv4' => 'El valor del campo :attribute debe ser una IPv4 válida.',
    'ipv6' => 'El valor del campo :attribute debe ser una IPv6 válida.',
    'json' => 'El valor del campo :attribute debe ser una cádena JSON válida.',
    'list' => 'El valor del campo :attribute debe ser una lista.',
    'lowercase' => 'El valor del campo :attribute debe estar escrito en minúsculas.',
    'lt' => [
        'array' => 'El valor del campo :attribute debe tener menos de :value elementos.',
        'file' => 'El valor del campo :attribute debe pesar menos de :value kilobytes.',
        'numeric' => 'El valor del campo :attribute debe ser menor a :value.',
        'string' => 'El valor del campo :attribute debe tener menos de :value caracteres.',
    ],
    'lte' => [
        'array' => 'El valor del campo :attribute no debe tener mas de :value elementos.',
        'file' => 'El valor del campo :attribute debe tener un peso menor o igual a :value kilobytes.',
        'numeric' => 'El valor del campo :attribute debe ser menor o igual a :value.',
        'string' => 'El valor del campo :attribute debe tener menor o igual a :value caracter(es).',
    ],
    'mac_address' => 'El valor del campo :attribute debe ser una dirección MAC válida.',
    'max' => [
        'array' => 'El valor del campo :attribute no debe tener mas de :max elementos.',
        'file' => 'El valor del campo :attribute no debe pesar más de :max kilobytes.',
        'numeric' => 'El valor del campo :attribute no debe ser mayor a :max.',
        'string' => 'El valor del campo :attribute no debe tener más de :max caracter(es).',
    ],
    'max_digits' => 'El valor del campo :attribute no debe tener más de :max dígitos.',
    'mimes' => 'El valor del campo :attribute debe ser un archivo de tipo: :values.',
    'mimetypes' => 'El valor del campo :attribute debe ser un archivo de tipo: :values.',
    'min' => [
        'array' => 'El valor del campo :attribute debe tener al menos :min elementos.',
        'file' => 'El valor del campo :attribute debe pesar por lo menos :min kilobytes.',
        'numeric' => 'El valor del campo :attribute por lo menos debe ser :min.',
        'string' => 'El valor del campo :attribute por lo menos debe tener :min caracter(es).',
    ],
    'min_digits' => 'El valor del campo :attribute debe tener al menos :min dígitos.',
    'missing' => 'El valor del campo :attribute no debe existir.',
    'missing_if' => 'El valor del campo :attribute no debe existir cuando :other es :value.',
    'missing_unless' => 'El valor del campo :attribute no debe existir a menos que :other sea :value.',
    'missing_with' => 'El valor del campo :attribute no debe existir cuando :values esté presente.',
    'missing_with_all' => 'El valor del campo :attribute no debe existir cuando los valores :values estén presentes.',
    'multiple_of' => 'El valor del campo :attribute debe ser un múltiplo de :value.',
    'not_in' => 'El elemento seleccionado :attribute es inválido.',
    'not_regex' => 'El valor del campo :attribute tiene un formato incorrecto.',
    'numeric' => 'El valor del campo :attribute debe ser numérico.',
    'password' => [
        'letters' => 'El valor del campo :attribute debe contener por lo menos una letra.',
        'mixed' => 'El valor del campo :attribute debe contener por lo menos una letra mayúscula y una minúscula.',
        'numbers' => 'El valor del campo :attribute debe contener por lo menos un número.',
        'symbols' => 'El valor del campo :attribute debe contener por lo menos un símbolo.',
        'uncompromised' => 'El recurso proporcionado :attribute se encuentra en una brecha de seguridad. Por favor selecciona un :attribute diferente.',
    ],
    'present' => 'El valor del campo :attribute debe estar presente.',
    'present_if' => 'El valor del campo :attribute debe estar presente cuando :other sea :value.',
    'present_unless' => 'El valor del campo :attribute debe estar presente a menos que :other sea :value.',
    'present_with' => 'El valor del campo :attribute debe estar presente cuando :values esté presente.',
    'present_with_all' => 'El valor del campo :attribute debe estar presente cuando los valores :values estén presentes.',
    'prohibited' => 'El valor del campo :attribute está prohibido.',
    'prohibited_if' => 'El valor del campo :attribute esá prohibido cuando :other sea :value.',
    'prohibited_unless' => 'El valor del campo :attribute está prohibido a menos que :other esté en :values.',
    'prohibits' => 'El valor del campo :attribute prohibe que :other esté presente.',
    'regex' => 'El valor del campo :attribute tiene un formato incorrecto.',
    'required' => 'El valor del campo :attribute es obligatorio.',
    'required_array_keys' => 'El valor del campo :attribute debe contener algún elemento de: :values.',
    'required_if' => 'El valor del campo :attribute es obligatorio cuando :other sea :value.',
    'required_if_accepted' => 'El valor del campo :attribute es obligatorio cuando :other sea aceptado.',
    'required_if_declined' => 'El valor del campo :attribute es obligatorio cuando :other sea rechazado.',
    'required_unless' => 'El valor del campo :attribute es obligatorio a menos que :other se encuentre en :values.',
    'required_with' => 'El valor del campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all' => 'El valor del campo :attribute es obligatorio cuando los valores :values estén presentes.',
    'required_without' => 'El valor del campo :attribute es obligatorio cuando :values no se encuentre.',
    'required_without_all' => 'El valor del campo :attribute es obligatorio cuando ninguno de los valores :values estén presentes.',
    'same' => 'El valor del campo :attribute debe ser igual a :other.',
    'size' => [
        'array' => 'El valor del campo :attribute debe contener :size elementos.',
        'file' => 'El valor del campo :attribute debe pesar :size kilobytes.',
        'numeric' => 'El valor del campo :attribute debe ser :size.',
        'string' => 'El valor del campo :attribute debe tener :size caracter(es).',
    ],
    'starts_with' => 'El valor del campo :attribute debe iniciar con alguno de los siguientes valores: :values.',
    'string' => 'El valor del campo :attribute debe ser una cádena válida.',
    'timezone' => 'El valor del campo :attribute debe ser una zona de tiempo válida.',
    'unique' => 'El valor de :attribute ya ha sido utilizado.',
    'uploaded' => 'El archivo :attribute no pudo ser cargado.',
    'uppercase' => 'El valor del campo :attribute debe estar escrito en mayúsculas.',
    'url' => 'El valor del campo :attribute debe ser una URL válida.',
    'ulid' => 'El valor del campo :attribute debe ser un ULID válido.',
    'uuid' => 'El valor del campo :attribute debe ser un UUID válido.',

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

    'attributes' => [],

];
