<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user(){
        // リレーションの定義
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments(){
        // リレーションの定義
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    public function subCategories(){
        // リレーションの定義
        return $this->belongsToMany('App\Models\Categories\SubCategory', 'post_sub_categories', 'post_id', 'sub_category_id');
    }

    // コメント数
    public function commentCounts($post_id){
        // withを用いて、関連するpostCommentsもPostモデルと一緒に取得する.getメソッドを使うと対象になった複数のデータを取得
        return Post::with('postComments')->find($post_id)->postComments()->get()->count();
    }
}
