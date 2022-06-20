<!doctype html>
<html lang="en">

<head>

    @include("back-end.layout.css")
</head>

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include("back-end.layout.header")

        <!-- ========== Left Sidebar Start ========== -->
        @include("back-end.layout.leftside")
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('webpanel')}}">หน้าแรก</a></li>
                            <li class="breadcrumb-item"><a href="{{url("$segment/$folder")}}">{{@$name_page}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{@$row->name}}</li>
                        </ol>
                    </nav>

                    <!-- content here -->
                    <form id="menuForm" method="post" action="" onsubmit="return check_add();">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="username">ชื่อ</label>
                                                            <input class="form-control" id="name" type="text" name="name" value="{{@$row->name}}" placeholder="ชื่อหน้าที่" autocomplete="off">
                                                            <small id="show_name" name="show_name" style="color:red;" hidden><i class="uil uil-exclamation-octagon font-size-16 text-danger me-2"></i> กรุณากรอกชื่อ</small>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" name="signup" value="Create">บันทึกข้อมูล</button>
                                            <a class="btn btn-danger" href="{{url("$segment/$folder")}}">ยกเลิก</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                    <form id="menuForm" method="post" action="{{url("$segment/$folder/menu/$row->id")}}" onsubmit="return check_add_menu();">
                        <div class="row">
                            <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="card">
                                    <div class="card-header"><b>จัดการสิทธิ์เมนู</b></div>
                                    <div class="card-body">

                                        @csrf
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">

                                                @foreach(@$menus as $m)
                                                @php
                                                $second = \App\Models\Backend\MenuModel::where('_id',$m->id)->where('status','on')->get();
                                                $role_main = \App\Models\Backend\Role_listModel::where(['role_id'=>$row->id, 'menu_id'=>$m->id])->first();
                                                @endphp
                                                <div class="row mb-1">
                                                    <div class="col-9 col-sm-9 col-md-9 col-lg-9">
                                                        <b>{{$m->name}}</b>

                                                        @if(count(@$second))
                                                        @foreach(@$second as $i => $s)
                                                        @php
                                                        $role_sub = \App\Models\Backend\Role_listModel::where(['role_id'=>$row->id, 'menu_id'=>$s->id])->first();
                                                        @endphp
                                                        <div class="row mb-2">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12" style="margin-left:20px;">
                                                                {{$s->name}}
                                                                <div class="row" style="margin-left:10px;">
                                                                    <input name="menu_id[]" value="{{$s->id}}" hidden>
                                                                    <div class="col-3 col-sm-3 col-md-3 col-lg-3"><input type="checkbox" @if(@$role_sub->read == "on") checked @endif name="read_{{$s->id}}"> อ่าน</div>
                                                                    <div class="col-3 col-sm-3 col-md-3 col-lg-3"><input type="checkbox" @if(@$role_sub->add == "on") checked @endif name="add_{{$s->id}}"> เพิ่ม</div>
                                                                    <div class="col-3 col-sm-3 col-md-3 col-lg-3"><input type="checkbox" @if(@$role_sub->edit == "on") checked @endif name="edit_{{$s->id}}"> แก้ไข</div>
                                                                    <div class="col-3 col-sm-3 col-md-3 col-lg-3"><input type="checkbox" @if(@$role_sub->delete == "on") checked @endif name="delete_{{$s->id}}"> ลบ</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                        @elseif(count(@$second) == null)
                                                        <div class="row" style="margin-left:10px;">
                                                            <input name="menu_id[]" value="{{$m->id}}" hidden>
                                                            <div class="col-3 col-sm-3 col-md-3 col-lg-3"><input type="checkbox" @if(@$role_main->read == "on") checked @endif name="read_{{$m->id}}"> อ่าน</div>
                                                            <div class="col-3 col-sm-3 col-md-3 col-lg-3"><input type="checkbox" @if(@$role_main->add == "on") checked @endif name="add_{{$m->id}}"> เพิ่ม</div>
                                                            <div class="col-3 col-sm-3 col-md-3 col-lg-3"><input type="checkbox" @if(@$role_main->edit == "on") checked @endif name="edit_{{$m->id}}"> แก้ไข</div>
                                                            <div class="col-3 col-sm-3 col-md-3 col-lg-3"><input type="checkbox" @if(@$role_main->delete == "on") checked @endif name="delete_{{$m->id}}"> ลบ</div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                @endforeach


                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" name="signup" value="Create">บันทึกข้อมูล</button>
                                            <a class="btn btn-danger" href="{{url("$segment/$folder")}}">ยกเลิก</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- end content -->



                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            @include("back-end.layout.footer")
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <!-- Script Zone -->
    @include("back-end.layout.script")
    <script>
        var fullUrl = window.location.origin + '/webpanel/menu';

        function check_add() {
            var position = $('#position').val();
            var name = $('#name').val();
            var url = $('#url').val();
            if (position == "") {
                toastr.error('กรุณาเลือกตำแหน่งเมนู');
                return false;
            }
            if (name == "") {
                toastr.error('กรุณากรอกชื่อเมนู');
                return false;
            }
            if (url == "") {
                toastr.error('กรุณากรอกลิงค์เข้าเมนู');
                return false;
            }
        }
        $('#position').on('change', function() {
            if ($('option:selected', this).val() == 'secondary') {
                $('#_id').prop('selectedIndex', 0).prop('disabled', false)
            } else {
                $('#_id').prop('disabled', true)
            }
        })
        $('#icon').on('keyup', function() {
            $('#icon-preview').find('i').removeAttr('class').addClass($(this).val());
        });
    </script>
    <!-- End Script zone -->

</body>

</html>