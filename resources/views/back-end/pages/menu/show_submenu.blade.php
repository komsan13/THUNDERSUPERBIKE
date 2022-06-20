<div class="modal-header py-3 px-4 border-bottom-0">
    <h5 class="modal-title" id="modal-title">เมนู {{$data->name}}</h5>

    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>

</div>
<div class="modal-body p-4">

    <div class="table-responsive">
        <div class="show_table">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width:5%">ลำดับ</th>
                        <th style="width:30%">ชื่อเมนูย่อย</th>
                        <th class="text-center" style="width:15%">ลำดับ</th>
                        <th class="text-center" style="width:10%">สถานะ</th>
                        <th class="text-center" style="width:20%">วันที่สร้าง</th>
                        <th class="text-center" style="width:10%">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @if($rows)
                    @php $i=0; @endphp
                    @foreach($rows as $row)
                    @php $i++; @endphp
                    <tr>
                        <th class="text-center">{{@$i}}</th>
                        <td>{{@$row->name}}</td>
                        <td>
                            @php $sorts = \App\Models\Backend\MenuModel::where('_id',$row->_id)->orderby('sort')->get(); @endphp
                            <select id="sort_{{$row->id}}" name="sort_{{$row->id}}" class="form-select w100" onchange="changesort_sub('{{$row->id}}')">
                                @foreach($sorts as $s)
                                <option value="{{$s->sort}}" @if($s->sort == $row->sort) selected @endif>{{$s->sort}}</option>
                                @endforeach
                            </select>

                        </td>
                        <td class="text-center">
                            <input type="checkbox" id="customSwitchsizemd{{@$row->id}}" data-id="{{@$row->id}}" onclick="status('{{@$row->id}}');" switch="bool" @if($row->status == "on") checked @endif />
                            <label for="customSwitchsizemd{{@$row->id}}" data-on-label="เปิด" data-off-label="ปิด"></label>
                        </td>
                        <td class="text-center">{{date('d/m/Y',strtotime('+543 Years',strtotime($row->created)))}}</td>
                        <td class="text-center">
                            <a href="{{url("$segment/$folder/$row->id")}}" class="btn btn-sm btn-info" title="Edit"><i class='far fa-edit'></i></a>
                            <a href="javascript:" class="btn btn-sm btn-danger" onclick="deleteItem_sub('{{$row->id}}')" title="Delete"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @endif


                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 text-end">
            <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">ปิด</button>
        </div>
    </div>

</div>
