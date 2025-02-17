<?php
return [

        'name'           => ['Required.', 'Must be a string.', 'Max 255 characters.'],
        'slug'           => ['Required.','Must be a string.','Max 100 characters.','Must be unique.','Should contain only lowercase letters, numbers, and hyphens (-).','No spaces or special characters allowed.'],
        'first_name'     => ['Required.', 'Must be a string.', 'Max 255 characters.'],
        'last_name'      => ['Required.', 'Must be a string.', 'Max 255 characters.'],
        'email'          => ['Required.', 'Must be a valid email.', 'Max 255 characters.', 'Must be unique.'],
        'date_of_birth'  => ['Required.', 'Must be a valid date.'],
        'personal_nr'    => ['Required.', 'Must be a string.', 'Exactly 10 characters.', 'Must be unique.'],
        'password'       => ['Required.', 'Must be a string.', 'Min 8 characters.', 'Must be confirmed.'],
        'description'    => ['Required.', 'Must be a string.', 'Max 500 characters.', 'Should provide a clear and concise description.', 'Avoid using special characters unnecessarily.'],

    ];