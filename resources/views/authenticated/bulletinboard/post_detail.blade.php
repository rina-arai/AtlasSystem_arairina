@extends('layouts.sidebar')
@section('content')
<div class="vh-100 d-flex">
  <div class="w-50 mt-5">
    <div class="m-3 detail_container post_area">
      <div class="p-3">
        <div class="detail_inner_head">
          <div>
            <!-- サブカテゴリー入れる -->
            @foreach($post->subCategories as $sub_category)
              <span class="tag_sub">{{ $sub_category->sub_category }}</span>
            @endforeach
            <!-- タイトルエラー文の表示 -->
            <span class="error_message">
              @if ($errors->has('post_title'))
                @foreach ($errors->get('post_title') as $message)
                  {{ $message }}<br>
                @endforeach
              @endif
            </span>
            <!-- 内容エラー文の表示 -->
            <span class="error_message">
              @if ($errors->has('post_body'))
                @foreach ($errors->get('post_body') as $message)
                  {{ $message }}<br>
                @endforeach
              @endif
            </span>
          </div>
          <!-- 編集、削除ボタン -->
          @if(Auth::user()->id == $post->user_id)
          <div class="detail_inner_btn">
            <span class="edit-modal-open btn btn-primary" post_title="{{ $post->post_title }}" post_body="{{ $post->post }}" post_id="{{ $post->id }}">編集</span>
            <span><a href="{{ route('post.delete', ['id' => $post->id]) }}" onclick="return confirm('削除してよろしいですか？')" class="btn btn-danger">削除</a></span>
          </div>
          @endif
        </div>
        <!-- 名前、日付 -->
        <div class="contributor d-flex mt-3">
          <p>
            <span>{{ $post->user->over_name }}</span>
            <span>{{ $post->user->under_name }}</span>
            さん
          </p>
          <span class="ml-5">{{ $post->created_at }}</span>
        </div>
        <div class="detsail_post_title">{{ $post->post_title }}</div>
        <div class="mt-3 detsail_post">{{ $post->post }}</div>
      </div>
      <!-- コメント -->
      <div class="p-3">
        <div class="comment_container">
          <span class="">コメント</span>
          @foreach($post->postComments as $comment)
          <div class="comment_area mt-3 border-bottom">
            <p class="mb-1">
              <span>{{ $comment->commentUser($comment->user_id)->over_name }}</span>
              <span>{{ $comment->commentUser($comment->user_id)->under_name }}</span>さん
            </p>
            <p>{{ $comment->comment }}</p>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <div class="w-50 p-3">
    <div class="comment_container post_area m-5">
      <div class="comment_area p-3">
        <!-- 内容エラー文の表示 -->
        <span class="error_message">
          @if ($errors->has('comment'))
            @foreach ($errors->get('comment') as $message)
              {{ $message }}<br>
            @endforeach
          @endif
        </span>
        <p class="m-0">コメントする</p>
        <textarea class="w-100 border" name="comment" form="commentRequest"></textarea>
        <input type="hidden" name="post_id" form="commentRequest" value="{{ $post->id }}">
        <input type="submit" class="btn btn-primary" form="commentRequest" value="投稿">
        <form action="{{ route('comment.create') }}" method="post" id="commentRequest">{{ csrf_field() }}</form>
      </div>
    </div>
  </div>
</div>
<!-- モーダル中身 -->
<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <!-- form -->
    <form action="{{ route('post.edit') }}" method="post">
      <div class="w-100">
        <div class="modal-inner-title w-50 m-auto">
          <input type="text" name="post_title" placeholder="タイトル" class="w-100 border">
        </div>
        <div class="modal-inner-body w-50 m-auto pt-3 pb-3">
          <textarea placeholder="投稿内容" name="post_body" class="w-100 border"></textarea>
        </div>
        <div class="w-50 m-auto edit-modal-btn d-flex">
          <a class="js-modal-close btn btn-danger d-inline-block" href="">閉じる</a>
          <input type="hidden" class="edit-modal-hidden" name="post_id" value="">
          <input type="submit" class="btn btn-primary d-block" value="編集">
        </div>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
</div>
@endsection
