@extends('layouts.sidebar')
@section('content')
<div class="mt-5 mb-5" style="align-items:center; justify-content:center;">
  <div class="w-75 m-auto pt-5 pb-5 border shadow" style="border-radius:10px; background:#FFF;">
    <p class="text-center">{{ $calendar->getTitle() }}</p>
    <div class="m-auto ">
      {!! $calendar->render() !!}
    </div>
    <div class="adjust-table-btn text-right w-80">
      <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
    </div>
  </div>
</div>
@endsection
