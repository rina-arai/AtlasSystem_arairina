<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectIdDetails implements DisplayUsers{

  // 改修課題：選択科目の検索機能
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){

    // キーワードの条件
    if(is_null($keyword)){ //キーワードがnull
      $keyword = User::get('id')->toArray();
    }else{
      $keyword = array($keyword);
    }

    // 性別の条件
    if(is_null($gender)){ //性別がnull
      $gender = ['1', '2'];
    }else{
      $gender = array($gender);
    }

    // 権限の条件
    if(is_null($role)){ //権限がnull
      $role = ['1', '2', '3', '4', '5'];
    }else{
      $role = array($role);
    }


    // Userモデルから、Userの情報とリレーション'subjects'のロード
    $users = User::with('subjects')
    // キーワードに関係するレコードのidを全て取得
    ->whereIn('id', $keyword)
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
    // 並び替えのパラメータで並び替えて、取得
    ->orderBy('id', $updown)->get();

    return $users;

  }

}

// モデル名::where(‘基準となるカラム’, ‘条件’) ->get();
