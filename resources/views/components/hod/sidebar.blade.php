<aside aria-label="Sidebar" id='sidebar'>
    <div class="mt-8 font-bold text-center text-orange-300 uppercase tracking-wider">{{App\Models\Semester::find(session('semester_id'))->title()}}</div>
    <div class="text-xs text-center">{{date('M d, Y')}}</div>
    <div class="mt-12">
        <ul class="space-y-2">
            <li>
                <a href="{{url('hod')}}" class="flex items-center p-2">
                    <i class="bi-house"></i>
                    <span class="ml-3">Home</span>
                </a>
            </li>
            <li>
                <a href="{{route('hod.clases.index')}}" class="flex items-center p-2">
                    <i class="bi-people"></i>
                    <span class="ml-3">Current Classes</span>
                </a>
            </li>
            <li>
                <a href="{{route('hod.students.index')}}" class="flex items-center p-2">
                    <i class="bi bi-person-circle"></i>
                    <span class="ml-3">Student Profile</span>
                </a>
            </li>
            <li>
                <a href="{{route('hod.semester-plan.index')}}" class="flex items-center p-2">
                    <i class="bi-calendar2-event"></i>
                    <span class="ml-3">Semester Plan</span>
                </a>
            </li>
            <li>
                <a href="{{route('hod.assessment.submitted')}}" class="flex items-center p-2">
                    <i class="bi-clipboard2-pulse"></i>
                    <span class="ml-3">Assessment</span>
                </a>
            </li>
            <li>
                <a href="{{url('hod/printable')}}" class="flex items-center p-2">
                    <i class="bi bi-printer"></i>
                    <span class="ml-3">Print / Download</span>
                </a>
            </li>
            <li class="md:hidden border-t border-dashed">
                <a href="{{route('signout')}}" class="flex items-center p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
                    </svg>
                    <span class="ml-3">Logout</span>
                </a>
            </li>

        </ul>
    </div>
</aside>