<?php

namespace App\Domain\Libraries\Books\Models;

use App\Domain\Libraries\Publishings\Models\LibPublishing;
use App\Domain\Libraries\Resources\Models\LibResource;
use Illuminate\Database\Eloquent\Model;

class LibBook extends Model
{
    public function publishing()
    {
        return $this->belongsTo(LibPublishing::class,'lib_publishing_id');
    }

    public function resource()
    {
        return $this->belongsTo(LibResource::class);
    }
}
