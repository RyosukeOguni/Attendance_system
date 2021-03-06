<?php

namespace App\Http\Controllers;

use App\User;
use App\School;
use app\Library\BaseClass;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Maatwebsite\Excel\Facades\Excel;

class UserManagerController extends Controller
{
    // 利用者一覧表示
    public function index(Request $request)
    {
        // 所属校で利用者の表示を絞る
        if ($request->has('school_id')) {
            $school_id = $request->school_id;
        } else {
            $school_id = 0;
        }

        // 所属校で利用者の表示を絞る
        if (empty($school_id)) {
            $users = User::with('school')->paginate(10);
        } else {
            $users = User::schoolIdEqual($school_id)->with('school')->paginate(10);
        }

        $param = [
            'users' => $users,
            'schoolselect' => BaseClass::schoolSelect(),
            'school_id' =>  $school_id,
        ];
        return view('admin.user_index', $param);
    }

    // 利用者登録画面
    public function register(Request $request)
    {
        $param = [
            'schoolselect' => BaseClass::schoolSelect(),
        ];
        return view('admin.user_register', $param);
    }

    // 利用者登録処理
    public function store(UserRequest $request)
    {
        // すべてのリクエスト内容を取得
        $form = $request->all();
        // リクエスト内容から不要な '_token'を取り除く
        unset($form['_token']);
        // Modelクラスを生成して、Form内容を一括（fill）で入力し、DBに保存（save）する
        $user = new User;
        $user->fill($form)->save();
        $title = '新規利用者登録完了';

        $param = [
            'user' => $user,
            'title' => $title,
        ];
        return view('admin.user_successful', $param);
    }

    // 利用者情報変更画面
    public function edit(Request $request)
    {
        $user = User::where('id', $request->id)->first();

        $param = [
            'user' => $user,
            'schoolselect' => BaseClass::schoolSelect(),
        ];
        return view('admin.user_edit', $param);
    }

    // 利用者情報変更処理
    public function update(UserRequest $request)
    {
        $user = User::where('id', $request->id)->first();
        // すべてのリクエスト内容を取得
        $form = $request->all();
        // リクエスト内容から不要な '_token'を取り除く
        unset($form['_token']);
        $user->fill($form)->save();
        $title = '利用者情報変更完了';

        $param = [
            'user' => $user,
            'title' => $title,
        ];
        return view('admin.user_successful', $param);
    }

    // 利用者情報削除
    public function delete(Request $request)
    {
        // クエリのUserIDのレコードをソフトデリート
        $user = User::where('id', $request->id)->first();
        $user->delete();
        $title = '利用者登録削除完了';

        $param = [
            'user' => $user,
            'title' => $title,
        ];
        return view('admin.user_successful', $param);
    }

    // 削除した利用者を表示
    public function deleteindex(Request $request)
    {

        if ($request->has('school_id')) {
            $school_id = $request->school_id;
        } else {
            $school_id = 0;
        }

        // ソフトデリートしたUserレコードを表示
        if (empty($school_id)) {
            $users = User::onlyTrashed()->with('school')->paginate(10);
        } else {
            $users = User::onlyTrashed()->schoolIdEqual($school_id)->with('school')->paginate(10);
        }

        $param = [
            'users' => $users,
            'schoolselect' => BaseClass::schoolSelect(),
            'school_id' =>  $school_id,
        ];
        return view('admin.user_delete', $param);
    }

    // ソフトデリートした削除した利用者を復活させる
    public function revival(Request $request)
    {
        if ($request->id) {
            User::whereIn('id', $request->id)->restore();
        }
        return  redirect('user/deleteindex');
    }

    // ソフトデリートした削除した利用者を完全削除する
    public function truedelete(Request $request)
    {
        if ($request->id) {
            User::whereIn('id', $request->id)->forceDelete();
        }
        return  redirect('user/deleteindex');
    }
}
