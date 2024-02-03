<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ url('') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="35">
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo-dark.png" alt="" height="20">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ url('') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="35">
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo-light.png" alt="" height="20">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">

                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ ($link=='home' || $link == '') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="ri-home-line"></i> <span data-key="t-home">Home</span>
                    </a>
                </li>

                @foreach($header_menu_sidebar as $v_header)
                    <li class="menu-title">
                        <span data-key="t-{{ Str::slug($v_header , '-') }}">{{ $v_header }}</span>
                    </li>
                    @foreach($menu_sidebar['menus'] as $v_menu)
                        @if($v_header==$v_menu['menu_header'])
                            @if(!empty($v_menu['menu_name']) && $v_menu['link'] == "#")
                                @if($v_menu['sub']['submenu'])
                                    <li class="nav-item">
                                        <a class="nav-link menu-link " href="#{{ Str::slug($v_menu['menu_name'] , '-') }}" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="{{ Str::slug($v_menu['menu_name'] , '-') }}">
                                            <i class="{{$v_menu['icon']}}"></i> 
                                            <span data-key="t-{{ Str::slug($v_menu['menu_name'] , '-') }}">{{$v_menu['menu_name']}}</span>
                                        </a>

                                        <div class="collapse menu-dropdown {{$v_menu['active']}}" id="{{ Str::slug($v_menu['menu_name'] , '-') }}">
                                            <ul class="nav nav-sm flex-column">
                                                @foreach($v_menu['sub']['submenu'] as $v_sub_menu)
                                                <li class="nav-item">
                                                    <a href="{{ ($v_sub_menu['is_eksternal']=='Ya') ? url($v_sub_menu['link']) : $v_sub_menu['link'] }}" target="{{ ($v_sub_menu['is_newtab']=='Ya') ? '_blank' : '_self'}}"  class="nav-link {{$v_sub_menu['sub_active']}}" data-key="t-{{$v_sub_menu['link']}}"> 
                                                        {{$v_sub_menu['menu_name']}}
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                            @else
                            <!-- Menu tunggal -->
                            <li class="nav-item">
                                <a href="{{ ($v_menu['is_eksternal']=='Ya') ? url($v_menu['link']) : $v_menu['link'] }}" target="{{ ($v_menu['is_newtab']=='Ya' ? '_blank' : '_self' ) }}" class="nav-link menu-link {{ ($link==$v_menu['link']) ? 'active' : '' }}">
                                    <i class="{{$v_menu['icon']}}"></i>
                                    <span>{{$v_menu['menu_name']}}</span>
                                </a>
                            </li>
                            @endif
                        @endif
                    @endforeach
                @endforeach

                <li class="menu-title"><span data-key="t-menu">Pengaturan</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ ($link=='personal' || $link == '') ? 'active' : '' }}" href="{{ route('personal') }}">
                        <i class="ri-user-settings-line"></i> <span data-key="t-personal">Personal</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
