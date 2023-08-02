@extends('layouts.sidebar')

@section('content')
<!-- 新規投稿フォーム -->
<div class="post_create_container d-flex">
  <div class="post_create_area border w-50 m-5 p-5">
    <div class="">
      <p class="mb-0">カテゴリー</p>
      <select class="w-100" form="postCreate" name="post_category_id">
        @foreach($main_categories as $main_category)
        <optgroup label="{{ $main_category->main_category }}"></optgroup>
        <!-- サブカテゴリー表示 -->
        <optgroup>
          @foreach($main_category->subCategories as $sub_category)
          <option value="{{ $sub_category->id }}">{{ $sub_category->sub_category }}</option>
          @endforeach
        </optgroup>
        @endforeach
      </select>
    </div>
    <div class="mt-3">
      @if($errors->first('post_title'))
      <span class="error_message">{{ $errors->first('post_title') }}</span>
      @endif
      <p class="mb-0">タイトル</p>
      <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
    </div>
    <div class="mt-3">
      @if($errors->first('post_body'))
      <span class="error_message">{{ $errors->first('post_body') }}</span>
      @endif
      <p class="mb-0">投稿内容</p>
      <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
    </div>
    <div class="mt-3 text-right">
      <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
    </div>
    <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
  </div>

  <!-- 右側、カテゴリー追加 -->
  @can('admin')
  <div class="w-25 ml-auto mr-auto">
    <div class="category_area mt-5 p-5">
      <!-- メインカテゴリー追加 -->
      <div class="">
        <p class="m-0">メインカテゴリー</p>
          <!-- 内容エラー文の表示 -->
          <span class="error_message">
            @if ($errors->has('main_category'))
                @foreach ($errors->get('main_category') as $message)
                    {{ $message }}<br>
                @endforeach
            @endif
          </span>
        <input type="text" class="w-100" name="main_category" form="mainCategoryCreate">
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="mainCategoryCreate">
      </div>
      <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryCreate">{{ csrf_field() }}</form>

      <!-- サブカテゴリー追加 -->
      <div class="">
        <p class="m-0">サブカテゴリー</p>
        <!-- メインカテゴリー選択 -->
        <!-- 内容エラー文の表示 -->
        <span class="error_message">
          @if ($errors->has('main_category_id'))
              @foreach ($errors->get('main_category_id') as $message)
                  {{ $message }}<br>
              @endforeach
          @endif
        </span>
        <select class="w-100" name="main_category_id" form="subCategoryRequest">
          @foreach($main_categories as $main_category)
            <option label="{{ $main_category->main_category }}" value="{{ $main_category->id }}"></option>
          @endforeach
        </select>
        <!-- サブカテゴリー入力 -->
        <span class="error_message">
          @if ($errors->has('sub_category'))
              @foreach ($errors->get('sub_category') as $message)
                  {{ $message }}<br>
              @endforeach
          @endif
        </span>
        <input type="text" class="w-100" name="sub_category" form="subCategoryRequest">
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="subCategoryRequest">
      </div>
      <form action="{{ route('sub.category.create') }}" method="post" id="subCategoryRequest">{{ csrf_field() }}</form>
    </div>
  </div>
  @endcan
</div>
@endsection
