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

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">เพิ่มข้อมูล</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{url("")}}">หน้าแรก</a></li>
                                        <li class="breadcrumb-item"><a href="{{url("$segment/$folder")}}">{{@$name_page}}</a></li>
                                        <li class="breadcrumb-item active">เพิ่มข้อมูล</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

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
                                                            <input class="form-control" id="name" type="text" name="name" placeholder="ชื่อหน้าที่" autocomplete="off">
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
            var name = $('#name').val();
            if (name == "") {
                toastr.error('กรุณากรอกชื่อเมนู');
                $('#show_name').attr('hidden', false);
                return false;
            }
        }
    </script>
    <!-- End Script zone -->

</body>

</html>