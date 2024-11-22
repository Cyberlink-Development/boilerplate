<div class="flex flex-col h-full fixed gap-[1rem] bg-[#2a2185]">
    <div class="navigation  w-[300px]">
        <a href="{{route('admin.dashboard')}}" class="relative flex text-[#fff] no-underline w-full flex flex-col">
            @if($site_settings)
                @if(!empty($site_settings->logo))
                    <img src="{{asset('template-assets/images/'.$site_settings->logo)}}" alt="" class="h-[3.8rem] bg-white border-b-[1px] border-r-[1px] border-[#2a2185]">
                @elseif(!empty($site_settings->site_name))
                    <span class="title p-[1rem] pb-[.5rem] text-[1.5rem] text-nowrap border-b border-gray-100 ">{{ $site_settings->site_name }}</span>
                @endif
            @else
                @if(File::exists('admin/images/default/logo.png'))
                    <img src="{{asset('admin/images/default/logo.png')}}" alt="" class="h-[3.8rem] bg-white border-b-[1px] border-r-[1px] border-[#2a2185]">
                @else
                    <span class="title p-[1rem] pb-[.5rem] text-[1.5rem] text-nowrap border-b border-gray-100 ">{{ config('app.name') }}</span>
                @endif
            @endif
        </a>
    </div>
    <div class="navigation w-[300px] bg-[#2a2185] border-l-[10px] border-[#2a2185] transition duration-500 overflow-x-hidden overflow-y-hidden">
        <ul class=" top-0 left-0 w-full h-screen scrollbar-change">
            <li class="relative w-full mb-[1rem] list-none rounded-l-[30px] hover:bg-[#fff] hidden">
            </li>
            <li class="relative w-full mt-[2rem] mb-[1rem] list-none rounded-l-[30px] hover:bg-[#fff] {{Route::currentRouteName() == 'admin.dashboard' ? 'menu-active' : ''}}">
                <a href="{{route('admin.dashboard')}}" class="relative flex text-[#fff] no-underline w-full ">
                    <span class="icon">
                        <ion-icon name="home-outline"></ion-icon>
                    </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>

            @can('roles_index')
                <li class="relative w-full mb-[1rem] list-none rounded-l-[30px] hover:bg-[#fff] {{Request::segment(2) == 'roles' ? 'menu-active' : ''}}">
                    <a href="{{ route('roles.index') }}" class="relative flex text-[#fff] no-underline w-full ">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Manage Roles</span>
                    </a>
                </li>
            @endcan

            @can('permissions_index')
                <li class="relative w-full mb-[1rem] list-none rounded-l-[30px] hover:bg-[#fff] {{Request::segment(2) == 'permissions' ? 'menu-active' : ''}}">
                    <a href="{{ route('permissions.index') }}" class="relative flex text-[#fff] no-underline w-full ">
                        <span class="icon">
                            <ion-icon name="key-outline"></ion-icon>
                        </span>
                        <span class="title">Manage Permissions</span>
                    </a>
                </li>
            @endcan

            @can('roles_and_permissions')
                <li class="relative w-full mb-[1rem] list-none rounded-l-[30px] hover:bg-[#fff] {{Request::segment(2) == 'rolesandpermisisons' ? 'menu-active' : ''}}">
                    <a href="{{ route('rolesandpermissions.index') }}" class="relative flex text-[#fff] no-underline w-full ">
                        <span class="icon">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                        </span>
                        <span class="title">Roles And Permissions</span>
                    </a>
                </li>
            @endcan

            @can('admins_index')
                <li class="relative w-full mb-[1rem] list-none rounded-l-[30px] hover:bg-[#fff] {{Request::segment(2) == 'manage-admins' ? 'menu-active' : ''}}">
                    <a href="{{route('manage-admins.index')}}" class="relative flex text-[#fff] no-underline w-full ">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Manage Admins</span>
                    </a>
                </li>
            @endcan

            @can('site_settings')
                <li class="relative w-full mb-[1rem] list-none rounded-l-[30px] hover:bg-[#fff] {{Request::segment(2) == 'site-settings' ? 'menu-active' : ''}}">
                    <a href="{{route('site-settings.index')}}" class="relative flex text-[#fff] no-underline w-full ">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Site Settings</span>
                    </a>
                </li>
            @endcan

            <li class="relative w-full mb-[1rem] list-none rounded-l-[30px] hover:bg-[#fff]">
                <a href="{{route('logout')}}">
                    <span class="icon">
                        <ion-icon name="log-out-outline"></ion-icon>
                    </span>
                    <span class="title">Sign Out</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<style>
    .navigation ul li.menu-active{
        background-color: var(--white);
        border-top-left-radius: 30px;
        border-bottom-left-radius: 30px;
    }
    .navigation ul li.menu-active a {
        color: var(--blue);
    }
    .navigation ul li.menu-active a::before {
    content: "";
    position: absolute;
    right: 0;
    top: -50px;
    width: 50px;
    height: 50px;
    background-color: transparent;
    border-radius: 50%;
    box-shadow: 35px 35px 0 10px var(--white);
    pointer-events: none;
    }
    .navigation ul li.menu-active a::after {
    content: "";
    position: absolute;
    right: 0;
    bottom: -50px;
    width: 50px;
    height: 50px;
    background-color: transparent;
    border-radius: 50%;
    box-shadow: 35px -35px 0 10px var(--white);
    pointer-events: none;
    }
</style>
