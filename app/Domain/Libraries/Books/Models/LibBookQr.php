<?php

namespace App\Domain\Libraries\Books\Models;

use Illuminate\Database\Eloquent\Model;

class LibBookQr extends Model
{
    public $timestamps = false;

    protected $fillable = ['lib_book_resource_id', 'qr_path'];
}
