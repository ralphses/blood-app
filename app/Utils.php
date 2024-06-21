<?php

namespace App;

class Utils
{
    public const BLOOD_TYPE = [
        'A+' => "A Positive",
        'A-' => "A Negative",
        'B+' => "B Positive",
        'B-' => "B Negative",
        'AB+' => "AB Positive",
        'AB-' => "AB Negative",
        'O+' => "O Positive",
        'O-' => "O Negative"
    ];

    public const BLOOD_MATCH = [
        'A+' => ['A+', 'A-', 'O+', 'O-'],
        'A-' => ['A-', 'O-'],
        'B+' => ['B+', 'B-', 'O+', 'O-'],
        'B-' => ['B-', 'O-'],
        'AB+' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
        'AB-' => ['A-', 'B-', 'AB-', 'O-'],
        'O+' => ['O+', 'O-'],
        'O-' => ['O-']
    ];
}
