<?php

namespace App\Domain\Departments\Models;

use App\Domain\Classifiers\Models\ClassifierOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Department extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'code',
        'active',
        'h_structure_type',
        'h_locality_type',
    ];

    public function structureType(): HasOne
    {
        return $this->HasOne(ClassifierOption::class, 'id', 'h_structure_type');
    }

    public function localityType(): HasOne
    {
        return $this->HasOne(ClassifierOption::class, 'id', 'h_locality_type');
    }

    public static function getIdByCode(string $code)
    {
        return Department::whereCode($code)->firstOrFail()->id;
    }

    public function childrens()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->BelongsTo(self::class, 'parent_id', 'id');
    }
}
