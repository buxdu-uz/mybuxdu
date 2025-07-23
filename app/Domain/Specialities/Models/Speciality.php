<?php

namespace App\Domain\Specialities\Models;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    protected $fillable=[
        'code',
        'name',
        'department_id',
        'h_structure_type',
        'h_education_type',
        'h_bachelor_speciality',
        'h_master_speciality',
        'doctorate_speciality',
        'h_speciality_ordinatura',
    ];
}
