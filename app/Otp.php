<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\User;

class Otp extends Model
{
    protected $fillable = ['otp_code', 'valid_date', 'user_id'];

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

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
