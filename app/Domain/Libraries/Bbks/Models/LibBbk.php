<?php

namespace App\Domain\Libraries\Bbks\Models;

use App\Domain\Libraries\Books\Models\LibBook;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class LibBbk extends Model
{
    use Filterable;

    public function children()
    {
        return $this->hasMany(self::class,'sub_id');
    }

    public function resources()
    {
        return $this->hasMany(LibBook::class,'lib_bbk_id');
    }
}
