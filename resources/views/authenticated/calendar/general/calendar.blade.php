@extends('layouts.sidebar')

@section('content')
<div class="d-flex pt-5" style="align-items:center; justify-content:center;">
  <div class="border w-75 pt-5 pb-5 shadow" style="border-radius:10px; background:#FFF;">
    <p class="text-center">{{ $calendar->getTitle() }}</p>
    <div class="w-75 m-auto ">
        {!! $calendar->render() !!}
    </div>
    <div class="text-right w-75">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>

@endsection
