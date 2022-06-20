<!doctype html>
<html lang="en">

<head>

    @include("back-end.layout.css")
    <style>
    tbody, td, tfoot, th, thead, tr {
        border: 1px solid #eff2f7;
    }
    </style>
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
                                <h4 class="mb-0"></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{url("")}}">หน้าแรก</a></li>
                                        <li class="breadcrumb-item active">{{@$name_page}}</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!-- content here -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">{{@$name_page}}</h4>
                                    <p class="card-title-desc"> คุณสามารถเพิ่มลบแก้ไขหรือจัดการเมนูได้</p>

                                    <div class="mb-3 row">
                                        <div class="col-xl-3">
                                            <select class="form-select myLike" name="status_active" id="status_active">
                                                <option value="">ทั้งหมด</option>
                                                <option value="on">ใช้งาน</option>
                                                <option value="off">ไม่ใช้งาน</option>
                                            </select>

                                        </div>
                                        <div class="col-xl-3">
                                            <input class="form-control myLike" type="text" placeholder="ค้นหา : ชื่อ" name="name" autocomplete="off">
                                        </div>
                                        <div class="col-xl-6 text-end">
                                            <a class="btn btn-success waves-effect waves-light" href="{{url("$segment/$folder/add")}}"><i class="bx bx-plus font-size-16 align-middle mr-1"></i> เพิ่มข้อมูล</a>
                                        </div>
                                    </div>

                                    <table id="data-table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>




                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end content -->



                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            @include("back-end.layout.footer")
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <div class="modal fade" id="show_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">

            </div>
        </div>
    </div>

    <!-- Script Zone -->
    @include("back-end.layout.script")
    <script>
        // var fullUrl = window.location.origin + '/webpanel/member';
        var fullUrl = window.location.origin + window.location.pathname;
        console.log(fullUrl);
        var oTable;
        $(function() {
            oTable = $('#data-table').DataTable({
                "sDom": "<'row'<'col-sm-12' tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
                processing: true,
                serverSide: true,
                stateSave: true,
                scroller: true,
                scrollCollapse: true,
                scrollX: true,
                ordering: true,
                bInfo: true,

                // scrollY: ''+($(window).height()-370)+'px',
                iDisplayLength: 25,
                ajax: {
                    url: fullUrl + "/datatable",
                    data: function(d) {
                        d.Like = {};
                        $('.myLike').each(function() {
                            if ($.trim($(this).val()) && $.trim($(this).val()) != '0') {
                                d.Like[$(this).attr('name')] = $.trim($(this).val());
                            }
                        });
                        oData = d;
                    },
                    method: 'POST'
                },
                columns: [ 
                    {data: 'DT_RowIndex',    title :'#',    className: 'text-center w5'}, // 0
                    {data: 'action_name',    title :'<center>ชื่อ</center>',    className: 'text-left w40'}, // 1
                    {data: 'change_sort',    title :'ลำดับ',    className: 'text-center w10'}, // 2
                    {data: 'created',    title :'วันที่สร้าง',    className: 'text-center w10'}, // 2
                    {data: 'status',    title :'สถานะ',    className: 'text-center w10', orderable: false, searchable: false}, // 3
                    {data: 'action',    title :'จัดการ',    className: 'text-center w20', orderable: false, searchable: false}, // 4

                ],
                rowCallback: function(nRow, aData, dataIndex) {

                    var status = '';
                    if (aData['status'] == "on") {
                        status = 'checked';
                    }

                    $('td:eq(4)', nRow).html('' +
                        '<input type="checkbox" id="customSwitchsizemd' + aData["id"] + '" data-id="' + aData["id"] + '" onclick="status(' + aData["id"] + ');" switch="bool" ' + status + ' />' +
                        '<label for="customSwitchsizemd' + aData["id"] + '" data-on-label="เปิด" data-off-label="ปิด"></label>'
                    ).addClass('input');

                }
            });
            $('.myWhere,.myLike,.myCustom,#onlyTrashed').on('change', function(e) {
                oTable.draw();
            });
        });

        function status(ids) {
            const $this = $(this),
                id = ids;
            $.ajax({
                type: 'get',
                url: fullUrl + '/status/' + id,
                success: function(res) {
                    if (res == false) {
                        $(this).prop('checked', false)
                    }
                }
            });
        }

        function deleteItem(ids) {
            const id = [ids];
            if (id.length > 0) {
                destroy(id)
            }
        }

        function destroy(id) {
            Swal.fire({
                title: "ลบข้อมูล",
                text: "คุณต้องการลบข้อมูลใช่หรือไม่?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch(fullUrl + '/destroy?id=' + id)
                        .then(response => response.json())
                        .then(data => location.reload())
                        .catch(error => {
                            Swal.showValidationMessage(`Request failed: ${error}`)
                        })
                }
            });
        }

        function dragsort(id, from, to) {
            $.ajax({
                url: fullUrl + '/dragsort',
                type: 'post',
                data: {
                    id: id,
                    from: from,
                    to: to,
                    _token: $('input[name="_token"]').val()
                },
                dataType: 'json',
                success: function(data) {}
            })
        }

        function changesort(id)
        {
            var sort = $('#sort_'+id).val();
            $.ajax({
                type: "post",
                url: fullUrl+"/changesort",
                data:{
                    sort:sort,
                    id:id
                },
                success:function(data)
                {
                    location.reload();
                }
            });
        }
        
    </script>
    <!-- End Script zone -->

</body>

</html>