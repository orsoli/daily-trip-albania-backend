<?php
return [

        'title'                 => ['Required.', 'Must be a string.', 'Max 255 characters.'],
        'name'                  => ['Required.', 'Must be a string.', 'Max 255 characters.'],
        'slug'                  => ['Required.','Must be a string.','Max 100 characters.','Must be unique.','Should contain only lowercase letters, numbers, and hyphens (-).','No spaces or special characters allowed.'],
        'first_name'            => ['Required.', 'Must be a string.', 'Max 255 characters.'],
        'last_name'             => ['Required.', 'Must be a string.', 'Max 255 characters.'],
        'email'                 => ['Required.', 'Must be a valid email.', 'Max 255 characters.', 'Must be unique.'],
        'date_of_birth'         => ['Required.', 'Must be a valid date.'],
        'personal_nr'           => ['Required.', 'Must be a string.', 'Exactly 10 characters.', 'Must be unique.'],
        'password'              => ['Required.', 'Must be a string.', 'Min 8 characters.', 'Must be confirmed.'],
        'description'           => ['Required.', 'Must be a string.', 'Max 500 characters.', 'Should provide a clear and concise description.', 'Avoid using special characters unnecessarily.'],
        'thumbnail'             => ['Optional.', 'Must be an image file.', 'Allowed formats: jpeg, png, jpg, gif, svg.', 'Max size: 2MB.'],
        'duration'              => ['Required.', 'Must be a string.', 'Max 255 characters.'],
        'difficulty'            => ['Required.', 'Must be a string.', 'Max 255 characters.'],
        'price'                 => ['Required.', 'Must be a number.', 'Minimum value: 0.', 'Maximum two decimal places.'],
        'gallery_images'        => ['Optional.', 'Must be images file.', 'Allowed formats: jpeg, png, jpg, gif, svg.', 'Max size: 2MB/each.'],
        'is_active'             => ['Optional.', 'Activating this option will publish the article and make it visible on the homepage.'],
        'delete_gallery_images' => ['Optional.', 'Check the box to delete an image from the gallery. The selected images will be removed upon updating the changes.'],
        'country'               => ['Required.', 'Must be a string.', 'Max 255 characters.'],
        'city'                  => ['Required.', 'Must be a string.', 'Max 255 characters.'],
        'nearest_airport'       => ['Optional.', 'Must be a string.', 'Max 255 characters.'],
        'latitude'              => ['Optional.', 'Must be a numeric value.', 'Should be a valid latitude coordinate.'],
        'longitude'             => ['Optional.', 'Must be a numeric value.', 'Should be a valid longitude coordinate.'],



    ];
