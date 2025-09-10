<?php

namespace App\Filters\Bbks;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class BbkFilter extends AbstractFilter
{
    public const SUB_ID = 'sub_id';
    public const IS_ACTIVE = 'is_active';
    public const NAME = 'name';
    public const CODE = 'code';
    public const INFO = 'info';

    /**
     * @return array[]
     */
    #[ArrayShape([self::SUB_ID => "array", self::IS_ACTIVE => "array", self::NAME => "array", self::CODE => "array", self::INFO => "array"])] protected function getCallbacks(): array
    {
        return [
            self::SUB_ID => [$this, 'sub_id'],
            self::IS_ACTIVE => [$this, 'is_active'],
            self::NAME => [$this, 'name'],
            self::CODE => [$this, 'code'],
            self::INFO => [$this, 'info'],
        ];
    }

    public function sub_id(Builder $builder, $value)
    {
//        dd($value);
        if ($value === 'null' || $value === null) {
            $builder->whereNull('sub_id');
        }else{
            $builder->where('sub_id', $value);
        }
    }

    public function is_active(Builder $builder, $value)
    {
        if ($value === 'null' || $value === null) {
            $builder->where('is_active',false);
        }else{
            $builder->where('is_active', true);
        }

    }

    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%$value%");
    }

    public function code(Builder $builder, $value)
    {
        $builder->where('code',  $value);
    }

    public function info(Builder $builder, $value)
    {
        $builder->where('info',  $value);
    }
}
