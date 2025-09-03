<?php

namespace App\Domain\Libraries\Bbks\Models;

use Illuminate\Database\Eloquent\Model;

class LibBbk extends Model
{
    public function children()
    {
        return $this->hasMany(self::class,'sub_id');
    }
}
