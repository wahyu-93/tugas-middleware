<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class roles extends Model
{
    protected $fillable = ['role'];
    
    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    protected static function boot(){
        parent::boot();
        static::creating(function($model){
            if(!$model->getKey()){
                $model->{$model->getKeyname()} = (string) Str::uuid();
            }
        });
    }  


}
