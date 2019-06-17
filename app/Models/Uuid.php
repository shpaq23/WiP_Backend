<?php
/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/17/2019
 * Time: 7:45 PM
 */
namespace App\Models;
use Illuminate\Support\Str;

trait Uuid
{
    protected static function bootUuid()
    {
        static::creating(function ($model) {
            if (! $model->uuid) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}