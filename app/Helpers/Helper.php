<?php

namespace App\helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use App\Models\Backend\TranslateModel;

use App\Models\Backend\MemberModel;

class Helper 
{
    protected $prefix = 'back-end';
    //==== Menu Active ====
    public static function auth_menu()
    {
        return view("back-end.alert.alert",[
            'url'=> "webpanel",
            'title' => "เกิดข้อผิดพลาด",
            'text' => "คุณไม่ได้รับสิทธิ์ในการใช้เมนูนี้ ! ",
            'icon' => 'error'
        ]); 
    }
    
    public static function menu_active($menu_id)
    {
        $member_id = Auth::guard('')->id();
        $member = \App\Models\Backend\User::find($member_id);
        $role = \App\Models\Backend\RoleModel::find($member->role);
        $list_role = \App\Models\Backend\Role_listModel::where(['role_id'=>$role->id, 'menu_id'=>$menu_id])->first();
        return $list_role;
    }

    public static function getRandomID($size, $table, $column_name)
    {
        $check_status = 0;
        while ($check_status == 0) 
        {
            $random_id = Helper::randomCode($size);

            $data = DB::table($table)->where("$column_name","$random_id")->get();
            if($data->count() == 0)
            {
                $check_status = 1;
            }
        }
        return $random_id;
    }

    public static function randomCode($length)
    {
        $possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghigklmnopqrstuvwxyz"; //ตัวอักษรที่ต้องการสุ่ม
        $str = "";
        while (strlen($str) < $length) {
            $str .= substr($possible, (rand() % strlen($possible)), 1);
        }
        return $str;
    }

    public static function getmember()
    {
        $data = MemberModel::find(Auth::guard('Member')->id());
        return $data;
    }

    public static function translate($id)
    {
        $lang = Session('lang');
        $data = TranslateModel::select("tb_translate.*", "name_$lang as name")->find($id);
        return $data->name;
    }


    //=====================
}