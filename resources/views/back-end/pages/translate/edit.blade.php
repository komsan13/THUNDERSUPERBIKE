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
                                <h4 class="mb-0">{{@$row->name_th}}</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{url("")}}">หน้าแรก</a></li>
                                        <li class="breadcrumb-item"><a href="{{url("$segment/$folder")}}">{{@$name_page}}</a></li>
                                        <li class="breadcrumb-item active">{{@$row->name_th}}</li>
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
                            
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="username"><span style="color:red;">*</span> ชื่อ <span class="badge bg-soft-danger font-size-12">TH</span></label>
                                                    <input type="text" id="name_th" name="name_th" class="form-control" value="{{$row->name_th}}" placeholder="กรุณากรอกข้อมูล">
                                                    <small id="show_name_th" name="show_name_th" style="color:red;" hidden><i class="uil uil-exclamation-octagon font-size-16 text-danger me-2"></i> กรุณากรอกข้อมูล</small>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="username">ชื่อ <span class="badge bg-soft-success font-size-12">EN</span></label>
                                                    <input type="text" id="name_en" name="name_en" class="form-control" value="{{$row->name_en}}" placeholder="กรุณากรอกข้อมูล">
                                                    <small id="show_name_en" name="show_name_en" style="color:red;" hidden><i class="uil uil-exclamation-octagon font-size-16 text-danger me-2"></i> กรุณากรอกข้อมูล</small>
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
        var fullUrl = window.location.origin + window.location.pathname;
       
        function check_add() {
            var name = $('#name').val();
            var food_category_id = $('#food_category_id').val();
            var member_id = $('#member_id').val();
            var price = $('#price').val();

            if(name == ""){ $('#show_name').attr('hidden', false); }else { $('#show_name').attr('hidden', true); }
            if(food_category_id == ""){ $('#show_food_category_id').attr('hidden', false); }else { $('#show_food_category_id').attr('hidden', true); }
            if(member_id == ""){ $('#show_member_id').attr('hidden', false); }else { $('#show_member_id').attr('hidden', true); }
            if(price == ""){ $('#show_price').attr('hidden', false); }else { $('#show_price').attr('hidden', true); }

            if (name == "" || food_category_id == "" || member_id == "" || price == "") {
                toastr.error('กรุณากรอกข้อมูลที่มี * ให้ครบถ้วน');
                return false;
            }
        }

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
        

        CKEDITOR.config.allowedContent = true;
        CKEDITOR.replace('detail_th', {
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',
            // customConfig: 'ckeditor/configedit.js',
            // language: 'th',
        });

        CKEDITOR.replace('detail_en', {
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',
            // customConfig: 'ckeditor/configedit.js',
            // language: 'th',
        });

        $('.deleteGallery').click(function() {
            const id = [$(this).data('id')],
                row = $(this).data('row');
            deleteGallery(id, row);

        });
       
        function deleteGallery(id, row)
        {
            Swal.fire({

                title: "ยืนยันลบ",
                text: "คุณแน่ใจใช่หรือไม่?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch('webpanel/news/gallery/destroy?id=' + id)
                        .then(response => response.json())
                        .then(data => {
                            $.each(id, function(i, v) {
                                $('#gallery' + v).remove()
                            })
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Request failed: ${error}`)
                        })
                }
            });
        }
    </script>
    <!-- End Script zone -->

</body>

</html>