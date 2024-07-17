<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = [
        'tckimlik_no',
        'ad',
        'soyad',
        'dogum_yili',
        'email',
        'phone',
        'gender',
        'birth_place',
        'blood_type',
        'social_media',
        'address',
        'position',
        'education',
        'marital_status',
        'driving_license',
        'note',
        'education_details',
        'work_details',
        'reference_details',
        'language_details',
        'experience_details',
        'criminal_record',
        'disability_situation',
        'travel_ban',
        'smoking'
    ];
}
