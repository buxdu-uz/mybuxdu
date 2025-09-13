<?php

namespace App\Models;

use App\Domain\Libraries\Books\Models\LibBookQr;
use App\Enums\LibBookResourceEnum;
use Illuminate\Database\Eloquent\Model;

class LibBookResource extends Model
{
    protected $fillable = [
        'lib_book_resource_id',
        'humen_id',
        'in_whom_id',
        'status',
        'add_date',
        'oh_date',
        'arrival_date'
    ];

    protected $casts = [
        'status' => LibBookResourceEnum::class
    ];

    public function qr()
    {
        return $this->belongsTo(LibBookQr::class, 'id','lib_book_resource_id');
    }
}
