<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Auth;
use DB;

class PostsController extends Controller
{
    public function show(Request $request){
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::get();
        // インスタンスの作成 → new
        $like = new Like;
        $post_comment = new Post;

        if(!empty($request->keyword)){
            $posts = Post::with('user', 'postComments')
            ->where('post_title', 'like', '%'.$request->keyword.'%')
            ->orWhere('post', 'like', '%'.$request->keyword.'%')->get();
        }else if($request->category_word){
            $sub_category = $request->category_word;
            $posts = Post::with('user', 'postComments')->get();
        }else if($request->like_posts){ // いいねした投稿を押したとき
            // 認証ユーザーがいいねした投稿を取得
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
            ->whereIn('id', $likes)->get();
        }else if($request->my_posts){ // 自分の投稿を押したとき
            $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->get();
        }else if($request->sub_category){ // サブカテゴリー選択
            // $request->sub_categoryの値が'sub_category'値がと一致しているコレクションを取得
            $sub_category = SubCategory::where('sub_category',$request->sub_category)->first();
            // 特定のカテゴリーに分類されるpostのidを取得し、配列に変換
            // pluckメソッドは指定したキーの全コレクション値を取得、toArrayメソッドで配列に変換する
            $sub_categories = $sub_category->posts->pluck('id')->toArray();
            $posts = Post::with('user', 'postComments')
            ->whereIn('id', $sub_categories)->get();
        }

        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    // 新規投稿
    public function postCreate(PostFormRequest $request){

            $sub_category = $request->post_category_id;
            $post_get = Post::create([
                'user_id' => Auth::id(),
                'post_title' => $request->post_title,
                'post' => $request->post_body
            ]);
            $post = Post::findOrFail($post_get->id);
            $post->subCategories()->attach($sub_category);

            return redirect()->route('post.show');

    }

    // 投稿編集
    public function postEdit(Request $request){

        // バリデーションルール定義
        $rules =[
            'post_title' => 'required|string|max:100',
            'post_body' => 'required|string|max:5000',
        ];
        // エラー時メッセージ
        $messages =[
            'post_title.required' => '※タイトルは必須項目です。',
            'post_title.max' => '※タイトルは100文字以内で記入してください。',
            'post_body.required' => '※投稿内容は必須項目です。',
            'post_body.max' => '※投稿内容は5000文字以内で記入してください。',
        ];

        $this->validate($request, $rules, $messages);

        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    // 投稿削除
    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }

    // メインカテゴリー追加
    public function mainCategoryCreate(Request $request){

        // dd($request);
        // バリデーションルール定義
        $rules =[
            'main_category' => 'required|string|max:100|unique:main_categories',
        ];
        // エラー時メッセージ
        $messages =[
            'main_category.required' => '※必須項目です。',
            'main_category.max' => '※100文字以内で記入してください。',
            'main_category.unique' => '※既に使われています。',
        ];
        $this->validate($request, $rules, $messages);

        MainCategory::create(['main_category' => $request->main_category]);
        return redirect()->route('post.input');
    }

    // サブカテゴリー追加
    public function subCategoryCreate(Request $request){

        // バリデーションルール定義
        $rules =[
            'sub_category' => 'required|string|max:100|unique:sub_categories',
            'main_category_id' => 'required',
        ];
        // エラー時メッセージ
        $messages =[
            'sub_category.required' => '※必須項目です。',
            'sub_category.max' => '※100文字以内で記入してください。',
            'sub_category.unique' => '※既に使われています。',
            'main_category_id.required' => '※必須項目です。',
        ];
        $this->validate($request, $rules, $messages);
        SubCategory::create([
            'sub_category' => $request->sub_category,
            'main_category_id' => $request->main_category_id
        ]);
        return redirect()->route('post.input');
    }

    // コメント投稿
    public function commentCreate(Request $request){

        // バリデーションルール定義
        $rules =[
            'comment' => 'required|string|max:2500',
        ];
        // エラー時メッセージ
        $messages =[
            'comment.required' => '※必須項目です。',
            'comment.max' => '※コメントは2500文字以内で記入してください。',
        ];

        $this->validate($request, $rules, $messages);

        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }
}
