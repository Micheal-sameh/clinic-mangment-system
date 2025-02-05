<?php

return [
    'required' => 'The :attribute field is required.',
    'exists' => 'The selected :attribute is invalid.',
    'date' => 'The :attribute is not a valid date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to today.',
    'integer' => 'The :attribute must be an integer.',

    'custom' => [
        'can_reserve_today' => 'You can only reserve today.',
        'check_active_day' => 'The selected day is not active for reservations.',
    ],

    'attributes' => [
        'user_id' => 'user',
        'reservation_date' => 'reservation date',
        'slate_number' => 'slate number',
    ],
];
