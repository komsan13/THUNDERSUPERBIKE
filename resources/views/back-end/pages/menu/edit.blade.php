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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">

                                    <form id="menuForm" method="post" action="" onsubmit="return check_add();">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="position">ตำแหน่ง</label>
                                                        <select class="form-control" name="position" id="position">
                                                            <option value="" hidden>กรุณาเลือก</option>
                                                            <option value="main" @if($row->position == "main") selected @endif>เมนูหลัก</option>
                                                            <option value="secondary" @if($row->position == "secondary") selected @endif>เมนูย่อย</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="position">เป็นเมนูย่อยของเมนู :</label>
                                                            <select class="form-control" name="_id" id="_id" @if($row->position == "main") disabled selected @endif>
                                                                <option value="" hidden>กรุณาเลือก</option>
                                                                @if($main)
                                                                @foreach($main as $i => $c)
                                                                <option value="{{$c->id}}" @if($c->id == $row->_id) selected @endif>{{$c->name}}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label" for="icon">Icon</label> :
                                            <small class="text-muted"><a href="{{url("$segment/$folder/icon")}}" target="_blank">Box Icons</a></small>

                                            <div class="input-group">
                                                <div class="input-group-text"><span id="icon-preview"><i @if($row->icon != null) class="{{@$row->icon}}" @endif ></i></span></div>
                                                <input class="form-control" id="icon" name="icon" value="{{@$row->icon}}" type="text" placeholder="icon" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label" for="username">ชื่อเมนู</label>
                                            <input class="form-control" id="name" type="text" name="name" value="{{@$row->name}}" placeholder="กรุณากรอกชื่อเมนู" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label" for="url">ลิงค์เมนู</label>
                                            <input class="form-control" id="url" type="text" name="url" value="{{@$row->url}}" placeholder="กรุณากรอกลิงค์แสดงผลเมนูเช่น /menu" autocomplete="off">
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" name="signup" value="Create">บันทึกข้อมูล</button>
                                            <a class="btn btn-danger" href="{{url("$segment/$folder")}}">ยกเลิก</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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