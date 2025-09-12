<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibBookResource extends Model
{
    protected $fillable = [
        'lib_book_id',
        'humen_id',
        'in_whom_id',
        'status',
        'add_date',
        'oh_date',
        'arrival_date'
    ];
}
