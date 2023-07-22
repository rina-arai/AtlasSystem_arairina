<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class Subjects extends Model
{
    const UPDATED_AT = null;


    protected $fillable = [
        'subject'
    ];

    // ３番目の引数は、関係を定義しているモデルの外部キー名、４番目の引数は、関連付けるモデルの外部キー名
    public function users(){
        return $this->belongsToMany('App\User', 'subject_users', 'subject_id', 'user_id');// リレーションの定義
    }
}
