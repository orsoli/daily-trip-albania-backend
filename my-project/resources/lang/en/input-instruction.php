<?php
return [

        'first_name'   => ['Required.', 'Must be a string.', 'Max 255 characters.'],
        'last_name'    => ['Required.', 'Must be a string.', 'Max 255 characters.'],
        'email'        => ['Required.', 'Must be a valid email.', 'Max 255 characters.', 'Must be unique.'],
        'date_of_birth'=> ['Required.', 'Must be a valid date.'],
        'personal_nr'  => ['Required.', 'Must be a string.', 'Exactly 10 characters.', 'Must be unique.'],
        'password'     => ['Required.', 'Must be a string.', 'Min 8 characters.', 'Must be confirmed.'],

    ];