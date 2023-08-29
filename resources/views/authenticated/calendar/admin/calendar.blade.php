@extends('layouts.sidebar')

@section('content')
<div class="mt-5 mb-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5 shadow" style="border-radius:10px; background:#FFF;">
    <div class="w-100">
      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="w-75 m-auto ">
        <p>{!! $calendar->render() !!}</p>
      </div>
    </div>
  </div>
</div>
@endsection
