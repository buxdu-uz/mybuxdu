<?php

namespace App\Domain\Libraries\Resources\Models;

use Illuminate\Database\Eloquent\Model;

class LibResourceType extends Model
{
    protected $table = 'lib_resource_types';

    public function getNameAttribute($value)
    {
        // Noto‘g‘ri kodlashni UTF-8 ga konvertatsiya qilamiz
//        return mb_convert_encoding($value, 'UTF-8', 'Windows-1251');
//        return mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
        return iconv('latin1', 'utf-8//IGNORE', $value);
        // Agar to‘g‘ri chiqmasa, 'ISO-8859-1' yoki 'CP1252'ni ham sinab ko‘rish mumkin
    }
}
