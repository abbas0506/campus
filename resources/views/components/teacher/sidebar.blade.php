<aside aria-label="Sidebar" id='sidebar' class="px-3">
    <div class="mt-8 font-bold text-center text-orange-300 uppercase tracking-wider">{{App\Models\Semester::find(session('semester_id'))->title()}}</div>
    <div class="text-xs text-center">{{date('M d, Y')}}</div>
    <div class="mt-12">
        <ul class="space-y-2">
            <li>
                <a href="{{url('teacher')}}" class="flex items-center p-2">
                    <i class="bi-grid"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{route('mycourses.index')}}" class="flex items-center p-2 ">
                    <i class="bx bx-book"></i>
                    <span class="ml-3">My Courses</span>
                </a>
            </li>
            <li>
                <a href="{{url('teacher/award')}}" class="flex items-center p-2 ">
                    <i class="bi bi-printer"></i>
                    <span class="ml-3">Award Lists</span>
                </a>
            </li>
        </ul>
    </div>
</aside>