<?php

namespace App\Http\Controllers\Webpanel;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Functions\MenuControl;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Webpanel\LogsController;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;

use App\Models\Backend\MenuModel;

class MenuController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'menu';
    protected $folder = 'menu';
    protected $name_page = "รายการเมนู";

    public function datatable(Request $request)
    {
        $like = $request->Like;
        $sTable = MenuModel::where('position', 'main')->orderby('sort', 'asc')
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
            ->addColumn('change_sort', function ($row) {
                $sorts = MenuModel::orderby('sort')->where('position','main')->get();

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
            ->editColumn('action_name', function ($row) {
                $secondary = \App\Models\Backend\MenuModel::where('_id', $row->id)->get();
                $data = "<span>$row->name</span>";
                if (count($secondary) > 0) {
                    $data .= "
                    <span class='badge bg-info rounded-pill' onclick='show_submenu($row->id);' type='button'>เมนูย่อย</span>";
                }
                return $data;
            })
            ->addColumn('created', function ($row) {
                $data = date('d/m/Y', strtotime('+543 Years',strtotime($row->created)));
                return $data;
            })
            ->addColumn('action', function ($row) {
                return " <a href='$this->segment/$this->folder/$row->id' class='btn btn-sm btn-info' title='Edit'><i class='far fa-edit'></i></a>                                                
            <a href='javascript:' class='btn btn-sm btn-danger' onclick='deleteItem($row->id)' title='Delete'><i class='far fa-trash-alt'></i></a>
            ";
            })
            ->rawColumns(['action_name', 'change_sort', 'created', 'action'])
            ->make(true);
    }

    public function index(Request $request)
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'name_page' => $this->name_page,
            'rows' => MenuModel::where(['position' => 'main'])->orderby('sort', 'asc')->get(),
        ]);
    }

    public function add(Request $request)
    {
        return view("$this->prefix.pages.$this->folder.add", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'name_page' => $this->name_page,
            'main' => MenuModel::where('position', '=', 'main')->get(),
        ]);
    }

    public function edit(Request $request, $id)
    {
        return view("$this->prefix.pages.$this->folder.edit", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'name_page' => $this->name_page,
            'row' => MenuModel::find($id),
            'main' => MenuModel::where('position', '=', 'main')->get(),
        ]);
    }

    public function status($id = null)
    {
        $data = MenuModel::find($id);
        $data->status = ($data->status == 'off') ? 'on' : 'off';
        if ($data->save()) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function showsubmenu(Request $request)
    {
        $data = MenuModel::find($request->id);
        $rows = MenuModel::where(['_id'=>$data->id, 'position'=>'secondary'])->orderby('sort','asc')->get();
        return view("$this->prefix.pages.$this->folder.show_submenu", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'name_page' => $this->name_page,
            'data' => $data,
            'rows' => $rows,
        ]);
    }

    public function destroy(Request $request)
    {
        $datas = MenuModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {
                MenuModel::where('_id', $data->id)->delete();
                //update sort
                MenuModel::where('sort', '>', $data->sort)->decrement('sort');
                //destroy
                $query = MenuModel::destroy($data->id);
            }
        }

        if (@$query) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function destroy_sub(Request $request)
    {
        $datas = MenuModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {
                MenuModel::where('id', $data->id)->delete();
                //update sort
                MenuModel::where('sort', '>', $data->sort)->where('_id',$data->_id)->decrement('sort');
                //destroy
                $query = MenuModel::destroy($data->id);
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
        $data = MenuModel::find($request->id);
        $checksort = MenuModel::where('id','!=',$data->id)->where('sort',$request->sort)->first();
        if($checksort)
        {
            $new_sort = MenuModel::where('sort',$request->sort)->first();
            $new_sort->sort = $data->sort;
            $new_sort->save();
        }
        $data->sort = $request->sort;
        $data->save();
    }

    public function changesort_sub(Request $request)
    {
        $data = MenuModel::find($request->id);
        $checksort = MenuModel::where('id','!=',$data->id)->where('_id',$data->_id)->where('sort',$request->sort)->first();
        if($checksort)
        {
            $new_sort = MenuModel::where('sort',$request->sort)->where('_id',$data->_id)->first();
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
                $data = new MenuModel();
                $data->sort = 1;
                $data->created = date('Y-m-d H:i:s');
                $data->updated = date('Y-m-d H:i:s');
            } else {
                $data = MenuModel::find($id);
                $data->updated = date('Y-m-d H:i:s');
            }
            $data->name = $request->name;
            $data->_id = $request->_id;
            $data->url = $request->url;
            $data->icon = $request->icon;
            $data->position = $request->position;
            if ($data->save()) {
                DB::commit();
                if ($id == null) {
                   if($request->position == "main")
                   {
                        MenuModel::where('id', '!=', $data->id)->increment('sort');
                   }
                   else
                   {
                        MenuModel::where('id', '!=', $data->id)->where('_id',$data->_id)->increment('sort');
                   }
                }
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
