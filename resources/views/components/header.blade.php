<header>
    <div class="flex flex-wrap w-full h-16 items-center justify-between">
        <div class="flex items-center">
            <a href="{{url('coordinator')}}">
                <img alt="logo" src="{{asset('/images/logo/logo.png')}}" class="w-20 md:w-24">
            </a>
            <div class="hidden md:flex text-base md:text-xl font-semibold">Examination System</div>
            <div class="hidden md:flex px-1 md:px-4">|</div>

            <a href="{{route('switch.me.view')}}" class="text-sm">{{ucfirst(session('role'))}} ({{App\Models\Semester::find(session('semester_id'))->short()}}) <i class="bx bx-chevron-down text-xs"></i></a>

        </div>

        <!-- right sided current user info -->
        <div id="current-user-area" class="flex space-x-3 items-center justify-center relative mr-8">
            <div class="hidden md:flex items-center text-sm">{{auth()->user()->name}}</div>

            @php
            $role=session('role')=='super'?'hod':session('role');
            @endphp
            <a href="{{route($role.'.notifications.index')}}" class="relative">
                <i class="bi-bell"></i>
                @if(Auth::user()->notifications_received()->unread()->count()>0)
                <div class="absolute top-0 right-0 w-2 h-2 rounded-full bg-orange-400"></div>
                @endif
            </a>

            <a href="{{url('signout/me')}}" class="hidden md:flex rounded-full bg-orange-100 text-orange-800 p-2">
                <i class="bx bx-power-off"></i>
            </a>

            <span id='menu' class="flex md:hidden">
                <i class="bx bx-menu"></i>
            </span>
        </div>
    </div>

</header>