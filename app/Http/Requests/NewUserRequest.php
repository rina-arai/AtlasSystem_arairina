<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewUserRequest extends FormRequest
{
    // 認証済みユーザーか、認可処理
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|regex:/\A[ァ-ヴー]+\z/u|max:30',
            'under_name_kana' => 'required|string|regex:/\A[ァ-ヴー]+\z/u|max:30',

            'mail_address' => 'required|string|email|max:100|unique:users',
            'sex' => 'required',

            'birth_day' => 'required|date|after:2000-01-01',

            'role' => 'required',
            'password' => 'required|alpha_num|between:8,30|confirmed',
            'password_confirmation' => 'required|alpha_num|between:8,30',
        ];
    }

    // 生年月日データの結合
    public function all($keys = null)
    {
        // all() メソッドは、リクエストの全ての入力データを取得
        $results = parent::all($keys);

        // filled()でキーが存在している、かつそれぞれの取得した値が'none'ではないとき
        if($this->filled(['old_year', 'old_month', 'old_day'])&&
        // $x!==$yは、xとyがデータ型含め等しくない
        $this->input('old_year') !== 'none' &&
        $this->input('old_month') !== 'none' &&
        $this->input('old_day') !== 'none') {
            // フォーマットの形にする
            $results['birth_day'] = $this->input('old_year') .'-'. $this->input('old_month').'-'. $this->input('old_day');
        }
        return $results;
    }

    public function messages()
    {
        return [
            'over_name.required' => '名前を入力してください',
            'over_name.max' => '10文字以下で入力してください',
            'under_name.required' => '名前を入力してください',
            'under_name.max' => '10文字以下で入力してください',
            'over_name_kana.required' => '名前を入力してください',
            'over_name_kana.regex' => 'カタカナで入力してください',
            'over_name_kana.max' => '30文字以下で入力してください',
            'under_name_kana.required' => '名前を入力してください',
            'under_name_kana.regex' => 'カタカナで入力してください',
            'under_name_kana.max' => '30文字以下で入力してください',

            'mail_address.required' => 'メールを入力してください',
            'mail_address.email' => 'メール形式で入力してください',
            'mail_address.max' => '100文字以下で入力してください',
            'mail_address.unique' => 'このアドレス既に使用されています',

            'sex.required' => '選択してください',

            'birth_day.required' => '必須項目です',
            'birth_day.after' => '2000/01/01以降の日付にしてください',
            'birth_day.date' => '正しい日付にしてください',

            'role.required' => '選択してください',

            'password.required' => 'パスワードを入力してください',
            'password.alpha_num' => '英数字のみで入力してください',
            'password.between' => '8～20で入力してください',
            'password.unique' => 'このパスワードは使えません',
            'password.confirmed' => 'パスワードが一致しません',
            'password_confirmation.required' => 'パスワードを入力してください',
            'password_confirmation.alpha_num' => '英数字のみで入力してください',
            'password_confirmation.between' => '8～20で入力してください',
        ];
    }

}
