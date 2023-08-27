@extends('layouts.sidebar')

@section('content')
<p class="w-75 page_title">投稿一覧</p>
<div class="board_area w-100 m-auto d-flex">
  <div class="post_view w-75 mt-5">
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <!-- 投稿者の名前 -->
      <p class="text-muted bold"><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <!-- 投稿タイトル -->
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}" class="text-dark bold">{{ $post->post_title }}</a></p>
      <div class="post_bottom_area d-flex">
        <!-- サブカテゴリー -->
        @foreach($post->subCategories as $sub_category)
          <span class="tag_sub">{{ $sub_category->sub_category }}</span>
        @endforeach
        <div class="d-flex post_status">
          <!-- コメント数 -->
          <div class="mr-5">
            <i class="fa fa-comment" style="color:gray;"></i><span class="">{{ $post_comment->commentCounts($post->id) }}</span>
          </div>
          <!-- いいね数 -->
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
            @else
            <p class="m-0"><i class="far fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area w-25 mt-5">
    <div class="m-4">
      <!-- 投稿ボタン -->
      <div><a href="{{ route('post.input') }}" class="post_btn">投稿</a></div>
      <!-- 検索窓 -->
      <div class="post_search d-flex">
        <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" value="検索" form="postSearchRequest">
      </div>
      <!-- いいね、自分の投稿ボタン -->
      <div class="post_good_like d-flex" style="justify-content:space-between;">
        <input type="submit" name="like_posts" class="" value="いいねした投稿" form="postSearchRequest">
        <input type="submit" name="my_posts" class="" value="自分の投稿" form="postSearchRequest">
      </div>
      <!-- カテゴリー別 -->
      <ul>
        <p>カテゴリー検索</p>
        @foreach($categories as $category)
          <!-- メインカテゴリー -->
          <li class="main_categories border-bottom border-secondary" category_id="{{ $category->id }}"><span>{{ $category->main_category }}<span></li>
          <!-- サブカテゴリー -->
          <ul class="sub_categories">
            @foreach($category->subCategories as $sub_category)
            <li class="border-bottom border-secondary">
              <input type="submit" name="sub_category" class="" value="{{ $sub_category->sub_category }}" form="postSearchRequest">
            </li>
            @endforeach
          </ul>
        @endforeach
      </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection
