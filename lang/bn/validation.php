<?php

/*
|--------------------------------------------------------------------------
| Validation messages — বাংলা (Bangla)
|--------------------------------------------------------------------------
|
| Only the rules actually used across the public forms are translated here;
| anything missing falls back to the English file via the fallback locale.
|
*/

return [

    'required'  => ':attribute অবশ্যই পূরণ করতে হবে।',
    'email'     => ':attribute একটি সঠিক ইমেইল ঠিকানা হতে হবে।',
    'confirmed' => ':attribute নিশ্চিতকরণ মিলছে না।',
    'date'      => ':attribute একটি সঠিক তারিখ হতে হবে।',
    'after'     => ':attribute :date এর পরের একটি তারিখ হতে হবে।',
    'unique'    => 'এই :attribute আগে থেকেই ব্যবহৃত হয়েছে।',

    'string' => [
        'string' => ':attribute অবশ্যই একটি বৈধ লেখা হতে হবে।',
    ],
    'max' => [
        'string'  => ':attribute :max অক্ষরের বেশি হতে পারবে না।',
        'numeric' => ':attribute :max এর বেশি হতে পারবে না।',
    ],
    'min' => [
        'string'  => ':attribute অন্তত :min অক্ষরের হতে হবে।',
        'numeric' => ':attribute অন্তত :min হতে হবে।',
    ],

    /*
    | Field-name overrides used inside the messages above.
    */
    'attributes' => [
        'name'          => 'নাম',
        'customer_name' => 'নাম',
        'email'         => 'ইমেইল ঠিকানা',
        'phone'         => 'ফোন নম্বর',
        'subject'       => 'বিষয়',
        'message'       => 'বার্তা',
        'password'      => 'পাসওয়ার্ড',
        'preferred_date'=> 'পরিদর্শনের তারিখ',
    ],

    'custom' => [],

];
