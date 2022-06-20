<?php

namespace App\Http\Controllers\Webpanel;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Functions\MenuControl;
use App\Http\Controllers\Functions\FunctionControl;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Webpanel\LogsController;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;

use App\Models\Backend\Test_formModel;


class Test_formController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'test-form';
    protected $folder = 'test-form';
    protected $menu_id = '1';
    protected $name_page = "Test Form";

    public function auth_menu()
    {
        return view("$this->prefix.alert.alert",[
            'url'=> "webpanel",
            'title' => "เกิดข้อผิดพลาด",
            'text' => "คุณไม่ได้รับสิทธิ์ในการใช้เมนูนี้ ! ",
            'icon' => 'error'
        ]); 
    }
    public function imageSize($find = null)
    {
        $arr = [
            'cover' => [
                'md' => ['x' => 565, 'y' => 414],
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

    public function datatable(Request $request)
    {
        $like = $request->Like;
        $sTable = Test_formModel::orderby('sort', 'asc')
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
            ->addColumn('created', function ($row) {
                $data = date('d/m/Y', strtotime('+543 Years',strtotime($row->created)));
                return $data;
            })
            ->addColumn('change_sort', function ($row) {
                $sorts = Test_formModel::orderby('sort')->get();

                $html = "";
                $html.='<select id="sort_'.$row->id.'" name="sort_'.$row->id.'" class="form-select w100" onchange="changesort('.$row->id.')">';
                foreach($sorts as $s)
                {
                    $select = '';
                    if($s->sort == $row->sort){ $select = 'selected'; }
                    $html.='<option value="'.$s->sort.'" '.$select.'>'.$s->sort.'</option>';
                }
                $html.='</select>';
    
                $data = $html;
                return $data;
            })
            ->addColumn('action', function ($row) 
            {
                $data = "";
                $menu_control = Helper::menu_active($this->menu_id);
                if($menu_control->edit == "on")
                {
                    $data.= " <a href='$this->segment/$this->folder/$row->id' class='btn btn-sm btn-info' title='Edit'><i class='far fa-edit'></i></a>  ";  
                }
                if($menu_control->delete == "on")
                {
                    $data.= " <a href='javascript:' class='btn btn-sm btn-danger' onclick='deleteItem($row->id)' title='Delete'><i class='far fa-trash-alt'></i></a>";  
                }
                return $data;
            })
            ->rawColumns(['action_name', 'change_sort', 'created', 'action'])
            ->make(true);
    }

    public function index(Request $request)
    {
        // $menu_control = Helper::menu_active($this->menu_id);
        // if($menu_control){ if($menu_control->read  == "off") { return $this->auth_menu(); } } else { return $this->auth_menu();}
        
        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'name_page' => $this->name_page,
        ]);
    }

    public function add(Request $request)
    {
        // $menu_control = Helper::menu_active($this->menu_id);
        // if($menu_control){ if($menu_control->add  == "off") { return $this->auth_menu(); } } else { return $this->auth_menu();}

        return view("$this->prefix.pages.$this->folder.add", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'name_page' => $this->name_page,
        ]);
    }

    public function edit(Request $request, $id)
    {
        // $menu_control = Helper::menu_active($this->menu_id);
        // if($menu_control){ if($menu_control->edit  == "off") { return $this->auth_menu(); } } else { return $this->auth_menu();}

        return view("$this->prefix.pages.$this->folder.edit", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'name_page' => $this->name_page,
            'row' => Test_formModel::find($id),
        ]);
    }

    public function status($id = null)
    {
        $data = Test_formModel::find($id);
        $data->status = ($data->status == 'off') ? 'on' : 'off';
        if ($data->save()) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function destroy(Request $request)
    {
        $datas = Test_formModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {
                Test_formModel::where('sort', '>', $data->sort)->decrement('sort');
                $query = Test_formModel::destroy($data->id);
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
        $data = Test_formModel::find($request->id);
        $checksort = Test_formModel::where('id','!=',$data->id)->where('sort',$request->sort)->first();
        if($checksort)
        {
            $new_sort = Test_formModel::where('sort',$request->sort)->first();
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
            if ($id == null) {
                $data = new Test_formModel();
                $data->sort = 1;
                $data->status = 'on';
                $data->created = date('Y-m-d H:i:s');
                $data->updated = date('Y-m-d H:i:s');
            } else {
                $data = Test_formModel::find($id);
                $data->updated = date('Y-m-d H:i:s');
            }
            $data->name = $request->name;
            $data->detail = $request->detail;
            if($request->image != null)
            {
                $image = FunctionControl::upload_image2($request->image,'test');
            }
            if ($data->save()) {
                DB::commit();
                if($id==null){ Test_formModel::where('id','!=',$data->id)->increment('sort'); }
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

    
}
