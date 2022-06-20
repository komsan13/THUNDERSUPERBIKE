@php
$member_menu = \App\Models\Backend\User::find(Auth::Guard()->id());
$roles = \App\Models\Backend\RoleModel::find($member_menu->role);
$list_role = \App\Models\Backend\Role_listModel::where(['role_id' => @$roles->id])->get();

$array_role = [];

if ($list_role) {
    foreach ($list_role as $list) {
        if ($list->read == 'on') {
            array_push($array_role, $list->menu_id);
            $menu_check = \App\Models\Backend\MenuModel::find($list->menu_id);
            if ($menu_check->_id != null) {
                array_push($array_role, $menu_check->_id);
            }
        }
    }
}
@endphp

<div class="vertical-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ url('webpanel') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/tunder1-03.png')}}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/tunder1-03.png')}}" alt="" height="20">
            </span>
        </a>

        <a href="{{ url('webpanel') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/tunder1-03.png')}}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/tunder1-03.png')}}" alt="" height="35"> <b class="text-white">THUNDERSUPER<span class="text-danger">BIKE</span></b>
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">dashboard</li>

                <li><a href="{{ url('webpanel') }}"><i class="uil-home-alt"></i><span>หน้าแรก</span></a></li>

                <!-- Helper Menu -->
                <li class="menu-title">เมนูการจัดการ</li>
                @php
                    $menu = \App\Models\Backend\MenuModel::where(['position' => 'main', 'status' => 'on'])
                        ->orderBy('sort')
                        ->get();
                @endphp

                @foreach ($menu as $i => $m)
                    @php
                        $second = \App\Models\Backend\MenuModel::where('_id', $m->id)
                            ->where('status', 'on')
                            ->orderBy('sort')
                            ->get();
                    @endphp
                    @if (in_array($m->id, $array_role))
                        @php 
                            $linku = "";
                            $link_url = Route::current()->uri(); 
                            try
                            {
                                $linku = '/'.explode("/",@$link_url)[1];
                            }
                            catch (\Exception $e){
                                
                            }
                           
                            
                        @endphp
                        <li @if($linku == $m->url) class="mm-active" @endif>
                            <a href="@if (count($second) > 0) javascript:void(0); @else webpanel{!! $m->url !!} @endif" class="@if (count($second) > 0) has-arrow @endif  waves-effect">
                                <i class="{!! $m->icon !!}"></i>
                                <span>{{ $m->name }}</span>
                            </a>
                            @if (count($second) > 0)
                                <ul class="sub-menu" aria-expanded="false">
                                    @foreach ($second as $i => $s)
                                        @if (in_array($s->id, $array_role))
                                            <li @if($linku == $s->url) class="mm-active" @endif><a href="webpanel{{ $s->url }}">{{ $s->name }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
                <!-- End Helper Menu -->

                <!-- System Dev -->
                <li class="menu-title">เมนูสำหรับทีมพัฒนา</li>
                <li><a href="{{ url('webpanel/menu') }}"><i class="bx bxs-food-menu"></i><span>รายการเมนู</span></a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-share-alt"></i>
                        <span>ผู้ดูแล</span>
                    </a>
                    <ul class="sub-menu mm-collapse" aria-expanded="true">
                        <li><a href="{{ url('webpanel/role') }}">บทบาทหน้าที่</a></li>
                        <li><a href="{{ url('webpanel/user') }}">รายการผู้ดูแล</a></li>
                    </ul>
                </li>
                <!-- End system dev -->
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
