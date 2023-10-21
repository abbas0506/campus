<header>
    <div class="flex flex-wrap w-full h-16 items-center justify-between">
        <div class="flex items-center">
            <a href="{{url('internal')}}">
                <img alt="logo" src="{{asset('/images/logo/logo.png')}}" class="w-20 md:w-24">
            </a>
            <div class="hidden md:flex text-base md:text-xl font-semibold">Examination System</div>
            <div class="hidden md:flex px-1 md:px-4">|</div>
            <div class="text-sm flex items-center space-x-2">
                <div>Internal {{Str::replace('Department of', '', App\Models\Department::find(session('department_id'))->name)}}</div>
                <i class="bi bi-chevron-right text-[10px]"></i>
                @if(Auth::user()->hasRole('super'))
                <form action="{{route('switch.semester')}}" method="post" id='switchSemesterForm'>
                    @csrf
                    <select name="semester_id" id="cboSemesterId" class="font-semibold">
                        @foreach(App\Models\Semester::active()->get() as $semester)
                        <option value="{{$semester->id}}" @selected($semester->id==session('semester_id'))>{{$semester->short()}}</option>
                        @endforeach
                    </select>
                </form>
                @else
                <div>{{App\Models\Semester::find(session('semester_id'))->short()}}</div>
                @endif

            </div>
        </div>

        <!-- right sided current user info -->
        <div id="current-user-area" class="flex space-x-3 items-center justify-center relative mr-8">
            <input type="checkbox" id='toggle-current-user-dropdown' hidden>
            <label for="toggle-current-user-dropdown" class="hidden md:flex items-center">
                <div class="">{{auth()->user()->name}}</div>
                <i class="bx bx-chevron-down"></i>
            </label>

            <a href="{{route('hod.notifications.index')}}" class="relative">
                <i class="bi-bell"></i>
                @if(Auth::user()->notifications_received()->unread()->count()>0)
                <div class="absolute top-0 right-0 w-2 h-2 rounded-full bg-orange-400"></div>
                @endif
            </a>

            <div class="hidden md:flex rounded-full bg-indigo-300 text-indigo-800 p-2" id='current-user-avatar'>
                <i class="bx bx-user"></i>
            </div>

            <div class="current-user-dropdown text-sm" id='current-user-dropdown'>

                <a href="{{route('hod.changepw')}}" class="flex items-center border-b py-2 px-4">
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

</header>