<?php

namespace App\Domain\Libraries\Books\Models;

use App\Domain\Libraries\Bbks\Models\LibBbk;
use App\Domain\Libraries\Publishings\Models\LibPublishing;
use App\Domain\Libraries\Resources\Models\LibResourceType;
use App\Models\LibBookResource;
use Illuminate\Database\Eloquent\Model;

class LibBook extends Model
{
    protected $fillable = [
        'humen_id',
        'lib_resource_type_id',
        'lib_publishing_id',
        'lib_bbk_id',
        'name',
        'author',
        'annotation',
        'number',
        'is_active',
        'page',
        'image',
        'price',
        'release_date'
    ];

    public function bbk()
    {
        return $this->belongsTo(LibBbk::class,'lib_bbk_id')->without('children');
    }

    public function publishing()
    {
        return $this->belongsTo(LibPublishing::class,'lib_publishing_id');
    }

    public function lib_book_resources()
    {
        return $this->hasMany(LibBookResource::class,'lib_book_id');
    }

    public function resourceType()
    {
        return $this->belongsTo(LibResourceType::class,'lib_resource_type_id');
    }
}
