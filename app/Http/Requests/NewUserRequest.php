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
            'over_name_kana' => 'required|string|max:30',
            'under_name_kana' => 'required|string|max:30',
            'mail_address' => 'required|string|email|max:100|unique:users',
            'sex' => 'required',
            'birth_day' => 'required|after:2000/01/01|date',
            'role' => 'required',
            // password_confirmedという項目(confirmed)
            'password' => 'required|alpha_num|between:8,30|confirmed',
            'password_confirmation' => 'required|alpha_num|between:8,30',
        ];
    }

    public function messages()
    {
        return [
            'over_name.required' => '名前を入力してください',
            'over_name.max' => '10文字以下で入力してください',
            'under_name.required' => '名前を入力してください',
            'under_name.max' => '10文字以下で入力してください',
            'over_name_kana.required' => '名前を入力してください',
            'over_name_kana.max' => '30文字以下で入力してください',
            'under_name_kana.required' => '名前を入力してください',
            'under_name_kana.max' => '30文字以下で入力してください',

            'mail_address.required' => 'メールを入力してください',
            'mail_address.email' => 'メール形式で入力してください',
            'mail_address.max' => '100文字以下で入力してください',
            'mail_address.unique' => 'このアドレスは使えません',

            'sex.required' => '選択してください',

            'birth_day.required' => '必須項目です',
            'birth_day.max' => '2000/01/01以降の日付にしてください',
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
