<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 应该被转化为原生类型的属性
     *
     * @var array
     */
    protected $casts = [
        'right' => 'array',
        'order_by' => 'integer'
    ];

}
