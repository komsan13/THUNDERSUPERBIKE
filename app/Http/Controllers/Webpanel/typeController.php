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

use App\Models\Backend\typeModel;
use App\Models\Backend\MenuModel;

class typeController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'type';
    protected $folder = 'type';
    protected $name_page = "รายการประเภทรถ";

    public function datatable(Request $request)
    {
        $like = $request->Like;
        $sTable = typeModel::orderby('id', 'asc')
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
            ->editColumn('action_name', function ($row) {
                $data = $row->name;
                return $data;
            })
            ->addColumn('created', function ($row) {
                $data = date('d/m/Y', strtotime('+543 Years', strtotime($row->created)));
                return $data;
            })
            ->addColumn('action', function ($row) {
                return " <a href='$this->segment/$this->folder/$row->id' class='btn btn-sm btn-info' title='Edit'><i class='far fa-edit'></i></a>                                                
            <a href='javascript:' class='btn btn-sm btn-danger' onclick='deleteItem($row->id)' title='Delete'><i class='far fa-trash-alt'></i></a>
            ";
            })
            ->rawColumns(['action_name', 'created', 'action'])
            ->make(true);
    }

    public function index(Request $request)
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'name_page' => $this->name_page,
        ]);
    }
}
