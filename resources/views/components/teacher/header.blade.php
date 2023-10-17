<!-- header -->
<header>
    <div class="flex flex-col w-screen">
        <div class="flex items-center justify-between">
            <div class="flex items-center py-1">
                <a href="{{url('hod')}}">
                    <img alt="logo" src="{{asset('/images/logo/logo.png')}}" class="w-20 md:w-24">
                </a>
                <div class="hidden md:flex text-xl font-semibold">Examination System</div>
                <div class="px-4">|</div>
                <div class="text-sm flex items-center space-x-2">
                    <div>Teacher</div>
                    <form action="{{route('switch.semester')}}" method="post" id='switchSemesterForm'>
                        @csrf
                        <select name="semester_id" id="cboSemesterId" class="px-2 font-semibold">
                            @foreach(App\Models\Semester::active()->get() as $semester)
                            <option value="{{$semester->id}}" @selected($semester->id==session('semester_id'))>{{$semester->short()}}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            <!-- right sided current user info -->
            <div id="current-user-area" class="flex space-x-3 items-center justify-center relative mr-8">
                <input type="checkbox" id='toggle-current-user-dropdown' hidden>
                <label for="toggle-current-user-dropdown" class="hidden md:flex items-center">
                    <div class="text-slate-600">{{auth()->user()->name}}</div>
                    <i class="bx bx-chevron-down"></i>
                </label>

                <div class="hidden md:flex rounded-full bg-indigo-300 text-indigo-800 p-2" id='current-user-avatar'>
                    <i class="bx bx-user"></i>
                </div>

                <div class="current-user-dropdown text-sm" id='current-user-dropdown'>
                    <a href="{{route('teacher.changepw')}}" class="flex items-center border-b py-2 px-4">
                        <i class="bx bx-key -rotate-45 mr-3"></i>
                        Change Password
                    </a>
                    <a href="{{url('signout')}}" class="flex items-center border-b py-2 px-4">
                        <i class="bx bx-log-out mr-3"></i>
                        Sign Out
                    </a>
                </div>
                <span id='menu' class="flex md:hidden">
                    <i class="bx bx-menu"></i>
                </span>
            </div>
        </div>

    </div>
</header>