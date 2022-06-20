<!doctype html>
<html lang="en">

<head>
    @include("back-end.layout.css")
</head>

<body data-sidebar="dark">
    <div id="layout-wrapper">
        @include("back-end.layout.header")
        @include("back-end.layout.leftside")
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('webpanel') }}">หน้าแรก</a></li>
                            <li class="breadcrumb-item active" aria-current="page">dashboard </li>
                        </ol>
                    </nav>
                    <!-- end page title -->

                    <!-- content here -->
                    {{-- <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end mt-2 icon-demo-content">
                                        <i class="uil-chat-bubble-user"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">0</span></h4>
                                        <p class="text-muted mb-0"><b>จำนวนสมาชิกทั้งหมด</b></p>
                                    </div>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>10.51%</span> ตั้งแต่สัปดาห์ที่ผ่านมา</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end mt-2 icon-demo-content">
                                        <i class="uil-shopping-cart-alt"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">0</span></h4>
                                        <p class="text-muted mb-0"><b>จำนวนยอดสั่งซื้อทั้งหมด</b></p>
                                    </div>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> ตั้งแต่สัปดาห์ที่ผ่านมา</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end mt-2 icon-demo-content">
                                        <i class="uil-money-stack"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">0</span></h4>
                                        <p class="text-muted mb-0"><b>รายได้ทั้งหมด</b></p>
                                    </div>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> ตั้งแต่สัปดาห์ที่ผ่านมา</p>
                                </div>
                            </div>
                        </div>
                    </div> --}}


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
    <!-- End Script zone -->

</body>

</html>