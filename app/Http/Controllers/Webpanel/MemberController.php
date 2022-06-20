<?php

namespace App\Http\Controllers\Webpanel;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Functions\MenuControl;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Webpanel\LogsController;
use App\Http\Middleware\Member;
use App\Models\Backend\FoodModel;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;

use App\Models\Backend\MemberModel;

class MemberController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'member';
    protected $folder = 'member';
    protected $menu_id = '1';
    protected $name_page = "รายการสมาชิก";

    public function imageSize($find = null)
    {
        $arr = [
            'cover' => [
                'md' => ['x' => 700, 'y' => 700],
            ],
        ];
        if ($find == null) {
            return $arr;
        } else {
            switch ($find) {
                case 'cover':
                    return $arr['cover'];
                    break;
                case 'gallery':
                    return $arr['gallery'];
                    break;
                default:
                    return [];
                    break;
            }
        }
    }

    public function auth_menu()
    {
        return view("$this->prefix.alert.alert",[
            'url'=> "webpanel",
            'title' => "เกิดข้อผิดพลาด",
            'text' => "คุณไม่ได้รับสิทธิ์ในการใช้เมนูนี้ ! ",
            'icon' => 'error'
        ]); 
    }

    public function datatable(Request $request)
    {
        $like = $request->Like;
        $sTable = MemberModel::orderby('id', 'desc')
        ->when($like, function ($query) use ($like) {
            if (@$like['name'] != "") {
                $query->where('firstname', 'like', '%' . $like['name'] . '%');
                $query->orwhere('lastname', 'like', '%' . $like['name'] . '%');
            }
            if (@$like['status_active'] != "") {
                $query->where('status', $like['status_active']);
            }
        })
        ->get();
        return Datatables::of($sTable)
            ->addIndexColumn()
            ->addColumn('action_image', function ($row) {
                $data = "<img src='$row->image' style='width:100%'>";
                return $data;
            })
            ->addColumn('action_name', function ($row) {
                $data = "$row->firstname $row->lastname";
                return $data;
            })
            ->addColumn('action_username', function ($row) {
                $data = "$row->username";
                return $data;
            })
            
            ->addColumn('created', function ($row) {
                $data = date('d/m/Y', strtotime('+543 Years',strtotime($row->created)));
                return $data;
            })
            
            ->addColumn('action', function ($row) 
            {
                $data = "";
                $menu_control = Helper::menu_active($this->menu_id);
                if($menu_control->edit == "on")
                {
                    $data.= " 
                        <a href='$this->segment/$this->folder/store/$row->id' class='btn btn-sm btn-success' title='Edit'><i class='fa fa-search'></i> ดูข้อมูลร้านค้า</a>
                        <a href='$this->segment/$this->folder/$row->id' class='btn btn-sm btn-info' title='Edit'><i class='far fa-edit'></i></a>
                    ";
                }
                if($menu_control->delete == "on")
                {
                    $data.= " <a href='javascript:' class='btn btn-sm btn-danger' onclick='deleteItem($row->id)' title='Delete'><i class='far fa-trash-alt'></i></a>";  
                }
                return $data;
            })
            ->rawColumns(['action_image' ,'action_name', 'created', 'action'])
            ->make(true);
    }

    public function index(Request $request)
    {
        $menu_control = Helper::menu_active($this->menu_id);
        if($menu_control){ if($menu_control->read  == "off") { return $this->auth_menu(); } } else { return $this->auth_menu();}
        
        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'name_page' => $this->name_page,
        ]);
    }

    public function add(Request $request)
    {
        $menu_control = Helper::menu_active($this->menu_id);
        if($menu_control){ if($menu_control->add  == "off") { return $this->auth_menu(); } } else { return $this->auth_menu();}

        return view("$this->prefix.pages.$this->folder.add", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'name_page' => $this->name_page,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $menu_control = Helper::menu_active($this->menu_id);
        if($menu_control){ if($menu_control->edit  == "off") { return $this->auth_menu(); } } else { return $this->auth_menu();}

        return view("$this->prefix.pages.$this->folder.edit", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'name_page' => $this->name_page,
            'row' => MemberModel::find($id),
           
        ]);
    }

    public function status($id = null)
    {
        $data = MemberModel::find($id);
        $data->status = ($data->status == 'inactive') ? 'active' : 'inactive';
        if ($data->save()) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function destroy(Request $request)
    {
        $datas = MemberModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {
                MemberModel::where('sort', '>', $data->sort)->decrement('sort');
                $query = MemberModel::destroy($data->id);
            }
        }

        if (@$query) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    
    public function changesort(Request $request)
    {
        $data = MemberModel::find($request->id);
        $checksort = MemberModel::where('id','!=',$data->id)->where('sort',$request->sort)->first();
        if($checksort)
        {
            $new_sort = MemberModel::where('sort',$request->sort)->first();
            $new_sort->sort = $data->sort;
            $new_sort->save();
        }
        $data->sort = $request->sort;
        $data->save();
    }

    //==== Function Insert Update Delete Status Sort & Others ====
    public function insert(Request $request, $id = null)
    {
        return $this->store($request, $id = null);
    }
    public function update(Request $request, $id)
    {
        return $this->store($request, $id);
    }
    public function store($request, $id = null)
    {
        try {
            DB::beginTransaction();
            $check = $this->check_user($request,$id,$request->username);
            if($check != "yes")
            {
                return view("$this->prefix.alert.alert", [
                    'url' => "$this->segment/$this->folder",
                    'title' => "เกิดข้อผิดพลาด",
                    'text' => "$check->text ",
                ]);
                return false;
            }
            if ($id == null) {
                $data = new MemberModel();
                $data->created = date('Y-m-d H:i:s');
                $data->updated = date('Y-m-d H:i:s');
                $data->password = bcrypt($request->password);
            } else {
                $data = MemberModel::find($id);
                $data->updated = date('Y-m-d H:i:s');
                if($request->resetpassword == "on")
                {
                    $data->password = bcrypt($request->password);
                }
            }
            $data->username = $request->username;
            $data->status = $request->status_check;
            $data->firstname = $request->firstname;
            $data->lastname = $request->lastname;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->facebook = $request->facebook;
            $data->line_id = $request->line_id;
            $data->detail = $request->detail;
            $data->store_name = $request->store_name;
            
            // Image upload
            $filename = 'member_' . date('dmY-His');
            $file = $request->image;
            if ($file) 
            {
                $lg = Image::make($file->getRealPath());
                $ext = explode("/", $lg->mime())[1];
                $size = $this->imageSize();
                $lg->resize($size['cover']['md']['x'], $size['cover']['md']['y'])->stream();
                $newLG = 'upload/member/' . $filename . '.' . $ext;
                $store = Storage::disk('public')->put($newLG, $lg);
                if($store)
                {
                    $data->image = $newLG;
                }
            }
            if ($data->save()) {
                DB::commit();
      
                return view("$this->prefix.alert.success", ['url' => url("$this->segment/$this->folder")]);
            } else {
                return view("$this->prefix.alert.error", ['url' => url("$this->segment/$this->folder")]);
            }
        } catch (\Exception $e) {
            $error_log = $e->getMessage();
            $error_line = $e->getLine();
            $type_log = 'backend';
            $error_url = url()->current();
            $log_id = LogsController::save_logbackend($type_log, $error_log, $error_line, $error_url);

            return view("$this->prefix.alert.alert", [
                'url' => $error_url,
                'title' => "เกิดข้อผิดพลาดทางโปรแกรม",
                'text' => "กรุณาแจ้งรหัส Code : $log_id ให้ทางผู้พัฒนาโปรแกรม ",
                'icon' => 'error'
            ]);
        }
    }

    public function check_user(Request $request, $id = null, $email)
    {
        if ($id == null) {
            $check = MemberModel::where('username', $email)->first();
            if ($check) 
            {
                return view("$this->prefix.alert.alert", [
                    'url' => "$this->segment/$this->folder",
                    'title' => "เกิดข้อผิดพลาด",
                    'text' => "ชื่อผู้ใช้งานนี้มีอยู่ในระบบ ",
                ]);
                $check_true = "no";
            } else {
                $check_true = "yes";
            }
        } else {
            $check = MemberModel::where('username', $email)->where('id', '!=', $id)->first();
            if ($check) {
                return view("$this->prefix.alert.alert", [
                    'url' => "$this->segment/$this->folder",
                    'title' => "เกิดข้อผิดพลาด",
                    'text' => "ชื่อผู้ใช้งานนี้มีอยู่ในระบบ ",
                ]);
                $check_true = "no";
            } else {
                $check_true = "yes";
            }
        }
        return $check_true;
    }

    
    // Store
    public function store_index(Request $request,$id)
    {
        $menu_control = Helper::menu_active($this->menu_id);
        if($menu_control){ if($menu_control->read  == "off") { return $this->auth_menu(); } } else { return $this->auth_menu();}
        
        return view("$this->prefix.pages.$this->folder.store-index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'name_page' => $this->name_page,
            'member' => MemberModel::find($id),
        ]);
    }
    public function store_datatable(Request $request,$id)
    {
        $like = $request->Like;
        $sTable = FoodModel::where(['member_id'=>$id])->orderby('id', 'desc')
        ->when($like, function ($query) use ($like) {
            if (@$like['name'] != "") {
                $query->where('name', 'like', '%' . $like['name'] . '%');
            }
            if (@$like['status_active'] != "") {
                $query->where('status', $like['status_active']);
            }
        })
        ->get();
        return Datatables::of($sTable)
            ->addIndexColumn()
            ->addColumn('action_name', function ($row) {
                $data = "$row->name";
                return $data;
            })
            ->addColumn('action_price', function ($row) {
                $price = number_format($row->total_sum,2);
                $data = "$price";
                return $data;
            })
            
            ->addColumn('created', function ($row) {
                $data = date('d/m/Y', strtotime('+543 Years',strtotime($row->created)));
                return $data;
            })
            
            ->addColumn('action', function ($row) 
            {
                $data = "";
                $menu_control = Helper::menu_active($this->menu_id);
                if($menu_control->edit == "on")
                {
                    $data.= " 
                        <a href='$this->segment/food/$row->id' class='btn btn-sm btn-info' title='Edit'><i class='far fa-edit'></i></a>
                    ";
                }
                if($menu_control->delete == "on")
                {
                    // $data.= " <a href='javascript:' class='btn btn-sm btn-danger' onclick='deleteItem($row->id)' title='Delete'><i class='far fa-trash-alt'></i></a>";  
                }
                return $data;
            })
            ->rawColumns(['action_name','action_price', 'created', 'action'])
            ->make(true);
    }
    public function store_status($id = null, $ids = null)
    {
        $data = FoodModel::find($ids);
        $data->status = ($data->status == 'off') ? 'on' : 'off';
        if ($data->save()) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
}
