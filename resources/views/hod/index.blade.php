@extends('layouts.hod')
@section('page-content')
<div class="container bg-slate-100">
    <!--welcome  -->
    <div class="flex items-center">
        <div class="flex-1">
            <h2>Welcome {{ Auth::user()->name }}!</h2>
            <div class="bread-crumb">
                <div>HOD</div>
                <div>/</div>
                <div>Home</div>
            </div>
        </div>
        <div class="text-slate-500">{{ today()->format('d/m/Y') }}</div>
    </div>

    <!-- pallets -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
        <a href="{{url('students')}}" class="pallet-box">
            <div class="flex-1">
                <div class="title">Students</div>
                <div class="h2">{{$department->students()->count()}}</div>
            </div>
            <div class="ico bg-green-100">
                <i class="bi bi-person-circle text-green-600"></i>
            </div>
        </a>
        <a href="{{url('teachers')}}" class="pallet-box">
            <div class="flex-1">
                <div class="title">Teachers</div>
                <div class="h2">{{$department->teachers()->count()}} </div>
            </div>
            <div class="ico bg-indigo-100">
                <i class="bi bi-person-workspace text-indigo-400"></i>
            </div>
        </a>
        <a href="" class="pallet-box">
            <div class="flex-1 ">
                <div class="title">Course Allocations</div>
                <div class="h2">{{$department->current_allocations()->count()}}</div>
            </div>
            <div class="ico bg-teal-100">
                <i class="bi bi-card-checklist text-teal-600"></i>
            </div>
        </a>
        <a href="" class="pallet-box">
            <div class="flex-1">
                <div class="title">Result Submission</div>
                <div class="h2">
                    @if($department->current_allocations()->count()>0)
                    {{$department->current_allocations()->submitted()->count()}}/{{$department->current_allocations()->count()}} ({{round( $department->current_allocations()->submitted()->count()/$department->current_allocations()->count(),1)}} %)
                    @endif
                </div>

            </div>
            <div class="ico bg-sky-100">
                <i class="bi bi-graph-up text-sky-600"></i>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 mt-8 gap-6">
        <!-- middle panel  -->
        <div class="md:col-span-2">
            <!-- update news  -->
            <div class="p-4 bg-slate-50">
                <h2>Students</h2>
                <div class="divider mt-4 border-slate-200"></div>
                <div class="grid grid-cols-3 mt-2">
                    <div>
                        <label class="text-xs text-slate-600">Active</label>
                        <p>{{$department->students()->active()->count()}}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-600">Frozen</label>
                        <p>{{$department->students()->frozen()->count()}}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-600">Struck Off</label>
                        <p>{{$department->students()->struckoff()->count()}}</p>
                    </div>
                </div>
            </div>

        </div>
        <!-- middle panel end -->
        <!-- right side bar starts -->
        <div class="">
            <div class="bg-sky-100 p-4">
                <div class="flex items-center space-x-2">
                    <i class="bi-tools text-sm"></i>
                    <h2>Basic Configuration</h2>
                </div>
                <div class="divider mt-4 border-sky-200"></div>
                <div class="flex items-center justify-between mt-2 text-sm">
                    <div class="flex items-center">
                        <i class="bi bi-award w-8"></i>
                        <a href="{{route('hod.programs.index')}}" class="link">Programs</a>
                    </div>
                    <div>{{$department->programs->count()}}</div>
                </div>
                <div class="flex items-center justify-between mt-2 text-sm">
                    <div class="flex items-center">
                        <i class="bi-book w-8"></i>
                        <a href="{{route('hod.courses.index')}}" class="link">Courses</a>
                    </div>
                    <div>{{$department->courses->count()}}</div>
                </div>
                <div class="flex items-center justify-between mt-2 text-sm">
                    <div class="flex items-center">
                        <i class="bi-database-gear w-8"></i>
                        <a href="{{route('hod.schemes.index')}}" class="link">Schemes</a>
                    </div>
                    <div>{{$department->schemes()->count()}}</div>
                </div>
                <div class="flex items-center justify-between mt-2 text-sm">
                    <div class="flex items-center">
                        <i class="bi-person-workspace w-8"></i>
                        <a href="{{route('hod.teachers.index')}}" class="link">Teachers</a>
                    </div>
                    <div>{{$department->teachers()->count()}}</div>
                </div>

            </div>

            <div class="mt-4 bg-white p-4">
                <h2>Profile</h2>
                <div class="flex flex-col">
                    <div class="flex text-sm mt-4">
                        <div class="w-8"><i class="bi-person"></i></div>
                        <div>{{ Auth::user()->name }}</div>
                    </div>
                    <div class="flex text-sm mt-2">
                        <div class="w-8"><i class="bi-envelope-at"></i></div>
                        <div>{{ Auth::user()->email }}</div>
                    </div>
                    <div class="flex text-sm mt-2">
                        <div class="w-8"><i class="bi-phone"></i></div>
                        <div>{{ Auth::user()->phone }}</div>
                    </div>
                    <div class="divider border-blue-200 mt-4"></div>
                    <div class="flex text-sm mt-4">
                        <div class="w-8"><i class="bi-key"></i></div>
                        <a href="{{route('passwords.edit')}}" class="link">Change Password</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection