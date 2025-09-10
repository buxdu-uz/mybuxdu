<?php

namespace App\Domain\Libraries\Bbks\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class LibBbk extends Model
{
    use Filterable;

    public function children()
    {
        return $this->hasMany(self::class,'sub_id');
    }
}
