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
                    <form id="menuForm" method="post" action="" onsubmit="return check_add();" enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="form-group col-12 col-xs-12 col-md-12 col-lg-12 col-xl-12">
                                                <h6>รูปภาพ</h6>
                                                <img src="@if(@$row->image == null) {{url("noimage.jpg")}} @else {{$row->image}} @endif" class="img-thumbnail" id="preview">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-12 col-xs-12 col-md-12 col-lg-12 col-xl-12">
                                                <small class="help-block">*รองรับไฟล์ <strong class="text-danger">(jpg, jpeg, png)</strong> เท่านั้น</small>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="image" id="image">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-body">
                                        

                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="username"><span style="color:red;">*</span> ชื่อ <span class="badge bg-soft-danger font-size-12">TH</span></label>
                                                    <input type="text" id="name" name="name" class="form-control" value="" placeholder="กรุณากรอกข้อมูล">
                                                    <small id="show_name" name="show_name" style="color:red;" hidden><i class="uil uil-exclamation-octagon font-size-16 text-danger me-2"></i> กรุณากรอกข้อมูล</small>
                                                </div>
                                            </div>
                                           
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="username"><span style="color:red;">*</span> รายละเอียด <span class="badge bg-soft-danger font-size-12">TH</span></label>
                                                    <textarea name="detail" id="detail" class="form-control" cols="5" rows="5"></textarea>
                                                    <small id="show_detail" name="show_detail" style="color:red;" hidden><i class="uil uil-exclamation-octagon font-size-16 text-danger me-2"></i> กรุณากรอกข้อมูล</small>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="card-footer text-end">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" name="signup" value="Create">บันทึกข้อมูล</button>
                                    <a class="btn btn-danger" href="{{url("$segment/$folder")}}">ยกเลิก</a>
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
        $("#image").on('change', function() {
            var $this = $(this)
            const input = $this[0];
            const fileName = $this.val().split("\\").pop();
            $this.siblings(".custom-file-label").addClass("selected").html(fileName)
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result).fadeIn('fast');
                }
                reader.readAsDataURL(input.files[0]);
            }
        });

        function check_add() {
            var name = $('#name').val();
            var detail = $('#detail').val();

            if(name == ""){ $('#show_name').attr('hidden', false); }else { $('#show_name').attr('hidden', true); }
            if(detail == ""){ $('#show_detail').attr('hidden', false); }else { $('#show_detail').attr('hidden', true); }
            if (name == "" || detail == "" ) {
                toastr.error('กรุณากรอกข้อมูลที่มี * ให้ครบถ้วน');
                return false;
            }
        }

        CKEDITOR.config.allowedContent = true;
        CKEDITOR.replace('detail', {
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',
            // customConfig: '/ckeditor/configedit.js',
            // language: 'th',
        });
    </script>
    <!-- End Script zone -->

</body>

</html>