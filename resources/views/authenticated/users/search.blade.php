@extends('layouts.sidebar')

@section('content')
<div class="search_content w-100 d-flex">
  <div class="reserve_users_area">
    @foreach($users as $user)
    <div class="border one_person mt-4 shadow">
      <div>
        <span class="text-black-50">ID : </span><span>{{ $user->id }}</span>
      </div>
      <div><span class="text-black-50">名前 : </span>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}" style="color:#03AAD2">
          <span>{{ $user->over_name }}</span>
          <span>{{ $user->under_name }}</span>
        </a>
      </div>
      <div>
        <span class="text-black-50">カナ : </span>
        <span>({{ $user->over_name_kana }}</span>
        <span>{{ $user->under_name_kana }})</span>
      </div>
      <div>
        @if($user->sex == 1)
        <span class="text-black-50">性別 : </span><span>男</span>
        @else
        <span class="text-black-50">性別 : </span><span>女</span>
        @endif
      </div>
      <div>
        <span class="text-black-50">生年月日 : </span><span>{{ $user->birth_day }}</span>
      </div>
      <div>
        @if($user->role == 1)
        <span class="text-black-50">権限 : </span><span>教師(国語)</span>
        @elseif($user->role == 2)
        <span class="text-black-50">権限 : </span><span>教師(数学)</span>
        @elseif($user->role == 3)
        <span class="text-black-50">権限 : </span><span>講師(英語)</span>
        @else
        <span class="text-black-50">権限 : </span><span>生徒</span>
        @endif
      </div>
      <div>
        @if($user->role == 4)
        <span class="text-black-50">選択科目 :</span>
        @foreach($user->subjects as $subject)
        <span>{{ $subject->subject }}</span>
        @endforeach
        @endif
      </div>
    </div>
    @endforeach
  </div>

  <!-- 右エリア：検索条件等 -->
  <div class="search_area w-25 ">
    <div class="">
      <p>検索</p>
      <!-- キーワードフォーム -->
      <div>
        <input type="text" class="free_word search_form" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>
      <div class="search_select">
        <label>カテゴリ</label>
        <select form="userSearchRequest" name="category" class="search_form">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>
      <div class="search_select">
        <label>並び替え</label>
        <select name="updown" form="userSearchRequest" class="search_form">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>

      <!-- 検索条件の追加　アコーディオン -->
      <div class="search_conditions_all">
        <label class="m-0 search_conditions border-bottom border-secondary" ><span>検索条件の追加</span></label>
        <div class="search_conditions_inner" >
          <div class="mt-3 search_select">
            <label>性別</label>
            <div>
              <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
              <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
            </div>
          </div>
          <div class="search_select">
            <label>権限</label>
            <select name="role" form="userSearchRequest" class="engineer search_form">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="selected_engineer">
            <label>選択科目</label>
            <!-- name="xxxxx[]"で配列の形でデータを送信 -->
            <div>
              <span>国語</span><input type="checkbox" name="subject[]" value="1" form="userSearchRequest">
              <span>数学</span><input type="checkbox" name="subject[]" value="2" form="userSearchRequest">
              <span>英語</span><input type="checkbox" name="subject[]" value="3" form="userSearchRequest">
            </div>
          </div>
        </div>
      </div>
      <div class="mt-5 submit">
        <input type="submit" name="search_btn" value="検索" form="userSearchRequest" class="post_btn">
      </div>
      <div class="reset">
        <input type="reset" value="リセット" form="userSearchRequest">
      </div>
    </div>
    <!-- form="userSearchRequest"はid="userSearchRequest"と関連づけたいものにつける -->
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
@endsection
