@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-75 m-auto h-75">
    <p><span>{{ $date }}日</span><span class="ml-3">{{ $part }}部</span></p>
    <div class="reserve_detail p-2 shadow" style="border-radius:10px; background:#FFF;">
      <table class="w-100 ">
        <tr class="text-center head">
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
          <th class="w-25">場所</th>
        </tr>
        <!-- $reservePersonの各要素に対してリレーションを呼び出す必要あり -->
        @foreach($reservePersons as $reservePerson)
          @foreach($reservePerson->users as $user)
            <tr class="text-center child">
              <td class="w-25">{{ $user->id }}</td>
              <td class="w-25">{{ $user->over_name }}{{ $user->under_name }}</td>
              <td class="w-25">リモート</td>
            </tr>
          @endforeach
        @endforeach
      </table>
    </div>
  </div>
</div>
@endsection
