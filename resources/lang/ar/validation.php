<?php

return [
    'required' => 'حقل :attribute مطلوب.',
    'exists' => 'الـ :attribute المحدد غير صالح.',
    'date' => 'الـ :attribute ليس تاريخًا صالحًا.',
    'after_or_equal' => 'الـ :attribute يجب أن يكون تاريخًا بعد أو يساوي اليوم.',
    'integer' => 'الـ :attribute يجب أن يكون عددًا صحيحًا.',

    'custom' => [
        'can_reserve_today' => 'يمكنك الحجز فقط اليوم.',
        'check_active_day' => 'اليوم المحدد ليس نشطًا للحجوزات.',
    ],

    'attributes' => [
        'user_id' => 'المستخدم',
        'reservation_date' => 'تاريخ الحجز',
        'slate_number' => 'رقم اللوحة',
    ],
];
