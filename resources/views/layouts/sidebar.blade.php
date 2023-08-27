<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AtlasBulletinBoard</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
  <!-- bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <!-- style.css -->
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <!-- マテリアルアイコン -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&family=Oswald:wght@200&display=swap" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="all_content">
  <div class="d-flex">
    <nav class="sidebar">
      @section('sidebar')
      <ul>
        <li><a href="{{ route('top.show') }}"><span class="material-icons">home</span><span>トップ</span></a></li>
        <li><a href="/logout"><span class="material-icons">logout</span>ログアウト</a></li>
        <li><a href="{{ route('calendar.general.show',['user_id' => Auth::id()]) }}"><span class="material-icons">event_note</span><span>スクール予約</span></a></li>
        @if(!(Auth::user()->role == 4))
          <li><a href="{{ route('calendar.admin.show',['user_id' => Auth::id()]) }}"><span class="material-icons">event_available
          </span><span>スクール予約確認</span></a></li>
          <li><a href="{{ route('calendar.admin.setting',['user_id' => Auth::id()]) }}"><span class="material-icons">edit_calendar</span><span>スクール枠登録</span></a></li>
        @endif
        <li><a href="{{ route('post.show') }}"><span class="material-icons">chat</span><span>掲示板</span></a></li>
        <li><a href="{{ route('user.show') }}"><span class="material-icons">group</span><span>ユーザー検索</span></a></li>
        @show
      </ul>
    </nav>
    <div class="main-container">
      @yield('content')
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/register.js') }}" rel="stylesheet"></script>
  <script src="{{ asset('js/bulletin.js') }}" rel="stylesheet"></script>
  <script src="{{ asset('js/user_search.js') }}" rel="stylesheet"></script>
  <script src="{{ asset('js/calendar.js') }}" rel="stylesheet"></script>
</body>
</html>
