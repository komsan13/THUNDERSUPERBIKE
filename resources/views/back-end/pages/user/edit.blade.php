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
                            <li class="breadcrumb-item"><a href="{{asset('webpanel')}}">หน้าแรก</a></li>
                            <li class="breadcrumb-item"><a href="{{url("$segment/$folder")}}">{{@$name_page}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{@$row->name}}</li>
                        </ol>
                    </nav>
                    <!-- end page title -->

                    <!-- content here -->
                    <form id="menuForm" method="post" action="" onsubmit="return check_add();">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">


                                        @csrf

                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="role">ระดับ</label>
                                                            <select class="form-control" name="role" id="role">
                                                                <option value="">กรุณาเลือก</option>
                                                                @if(@$roles)
                                                                @foreach(@$roles as $role)
                                                                <option value="{{$role->id}}" @if($row->role == $role->id) selected @endif>{{$role->name}}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="status">สถานะ</label>
                                                            <select class="form-control" name="status_check" id="status_check">
                                                                <option value="" hidden>กรุณาเลือก</option>
                                                                <option value="pending" @if($row->status == "pending") selected @endif>รอดำเนินการ</option>
                                                                <option value="inactive" @if($row->status == "inactive") selected @endif>ปิดการใช้งาน</option>
                                                                <option value="active" @if($row->status == "active") selected @endif>ใช้งาน</option>
                                                                <option value="banned" @if($row->status == "banned") selected @endif>ระงับการใช้งาน</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="username">ชื่อ</label>
                                                            <input class="form-control" id="name" type="text" name="name" value="{{$row->name}}" placeholder="ชื่อ-นามสกุล" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="username">ชื่อผู้ใช้งาน</label>
                                                            <input class="form-control" id="username" type="text" name="username" value="{{$row->email}}" placeholder="ชื่อผู้ใช้งาน" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="checkbox" id="resetpassword" name="resetpassword"> เปลี่ยนรหัสผ่าน
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="password">รหัสผ่าน</label>
                                                            <div class="input-group col-mb-6">
                                                                <input type="password" id="password" class="form-control" name="password" placeholder="รหัสผ่าน" autocomplete="off" disabled>
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <span class="card-link show_pass"><i class="far fa-eye" data-id="password"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="confirm_password">ยืนยันรหัสผ่าน</label>
                                                            <div class="input-group col-mb-6">
                                                                <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="ยืนยันรหัสผ่าน" autocomplete="off" disabled>
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <span class="card-link show_pass_confirm"><i class="far fa-eye" data-id="confirm_password"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
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
        function check_add() {
            var role = $('#role').val();
            var status_check = $('#status_check').val();
            var name = $('#name').val();
            var username = $('#username').val();
            var password = $('#password').val();
            var confirm_password = $('#confirm_password').val();
            var resetpassword = $('#resetpassword').val();

            if (role == "") {
                toastr.error('กรุณาเลือกระดับของผู้ใช้งานนี้');
                return false;
            }
            if (status_check == "") {
                toastr.error('กรุณาเลือกสถานะการใช้งาน');
                return false;
            }
            if (name == "" || username == "") {
                toastr.error('กรุณากรอกข้อมูลให้ครบถ้วนก่อนบันทึกรายการ');
                return false;
            }
            if (password != confirm_password) {
                toastr.error('กรุณากรอกรหัสผ่านให้เหมือนกัน');
                return false;
            }
        }
        //== Script Ajax Regular ==
        $('#resetpassword').change(function() {
            if ($(this).prop("checked") == true) {
                $('#password').attr('disabled', false);
                $('#confirm_password').attr('disabled', false);
            } else if ($(this).prop("checked") == false) {
                $('#password').attr('disabled', true);
                $('#confirm_password').attr('disabled', true);
                $('#password').val(null);
                $('#confirm_password').val(null);
            }
        });

        $('.show_pass').click(function() {
            var password = $('#password').attr('type');
            if (password == "password") {
                $('#password').attr('type', 'text');
            } else {
                $('#password').attr('type', 'password');
            }
        });


        $('.show_pass_confirm').click(function() {
            var confirm_password = $('#confirm_password').attr('type');
            if (confirm_password == "password") {
                $('#confirm_password').attr('type', 'text');
            } else {
                $('#confirm_password').attr('type', 'password');
            }
        });
    </script>
    <!-- End Script zone -->

</body>

</html>