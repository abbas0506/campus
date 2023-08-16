<header>
    <div class="flex flex-wrap w-full h-16 items-center justify-between">
        <div class="flex items-center">
            <a href="{{url('hod')}}">
                <img alt="logo" src="{{asset('/images/logo/logo.png')}}" class="w-20 md:w-24">
            </a>
            <div class="hidden md:flex text-base md:text-xl font-semibold">Examination System</div>
            <div class="hidden md:flex px-1 md:px-4">|</div>
            <div class="text-sm flex items-center space-x-2">
                <div>HOD {{Str::replace('Department of', '', App\Models\Department::find(session('department_id'))->name)}}</div>
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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mx-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </label>

            <div class="hidden md:flex rounded-full bg-indigo-300 text-indigo-800 p-2" id='current-user-avatar'>
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" class="w-5 h-5" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <!-- <img src="{{asset('/images/logo/logo-light.png')}}" alt="" class="rounded-full w-10 h-10"> -->
            </div>

            <div class="current-user-dropdown text-sm" id='current-user-dropdown'>

                <a href="{{route('hod.changepw')}}" class="flex items-center border-b py-2 px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4 mr-3 -rotate-90">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                    </svg>
                    Change Password
                </a>
                <a href="{{url('signout')}}" class="flex items-center border-b py-2 px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    Sign Out
                </a>
            </div>
            <span id='menu' class="flex md:hidden">
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                </svg>
            </span>
        </div>
    </div>

</header>