<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectNameDetails implements DisplayUsers{

  // 改修課題：選択科目の検索機能
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){


    if(is_null($gender)){
      $gender = ['1', '2'];
    }else{
      $gender = array($gender);
    }
    if(is_null($role)){
      $role = ['1', '2', '3', '4', '5'];
    }else{
      $role = array($role);
    }

    $users = User::with('subjects')
    ->where(function($q) use ($keyword){
      $q->Where('over_name', 'like', '%'.$keyword.'%')
      ->orWhere('under_name', 'like', '%'.$keyword.'%')
      ->orWhere('over_name_kana', 'like', '%'.$keyword.'%')
      ->orWhere('under_name_kana', 'like', '%'.$keyword.'%');
    })
    ->where(function($q) use ($role, $gender){
      $q->whereIn('sex', $gender)
      ->whereIn('role', $role);
    })
    // リレーション先のテーブルの条件で検索したいときwhereHas使う　第一引数はリレーションメソッド名
    // useを使うことでクロージャの外で宣言している変数を使える
    ->whereHas('subjects', function($q) use ($subjects){
      // subjectを配列として受け取る
      if(is_array($subjects)){
        // 配列$subjectsがあれば無名関数を使って foreach でチェックした科目を回してwhere句に渡してあげる
        $q->where(function($q) use($subjects){
        // 送られた科目とidが同じものを全て取得
          foreach($subjects as $subject_id){
          $q->orWhere('subjects.id', $subject_id);
          }
        });
      }
    })
    ->orderBy('over_name_kana', $updown)->get();

    return $users;
  }

}
