<?php
namespace App\Searchs;

use App\Models\Users\User;

class SearchResultFactories{

  // 改修課題：選択科目の検索機能
  public function initializeUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if($category == 'name'){ //カテゴリーが名前に設定されている
      if(is_null($subjects)){ //教科がnull
        $searchResults = new SelectNames();
      }else{//教科がある
        $searchResults = new SelectNameDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }else if($category == 'id'){//カテゴリーが社員idに設定されている
      if(is_null($subjects)){//教科がnull
        $searchResults = new SelectIds();
      }else{//教科がある
        $searchResults = new SelectIdDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }else{
      $allUsers = new AllUsers();
    return $allUsers->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }
  }
}
