@extends('layouts.internal')
@section('page-content')

<div class="container bg-slate-100">
    <!--welcome  -->
    <div class="flex flex-wrap items-center justify-between gap-y-4">
        <div class="flex flex-col flex-wrap">
            <h2>Welcome {{ $user->name }}!</h2>
            <div class="bread-crumb">
                <div>Internal</div>
                <div>/</div>
                <div>Home</div>
            </div>
        </div>
        <div class="text-slate-500">{{ today()->format('d/m/Y') }}</div>
    </div>

    <!-- pallets -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
        <a href="{{route('teacher.mycourses.index')}}" class="pallet-box">
            <div class="flex-1">
                <div class="title">My Programs</div>
                <div class="h2">{{$user->intern_programs()->where('department_id', session('department_id'))->count()}}</div>
            </div>
            <div class="ico bg-green-100">
                <i class="bi bi-book text-green-600"></i>
            </div>
        </a>

        <a href="" class="pallet-box">
            <div class="flex-1">
                <div class="title">My Students</div>
                <div class="h2">{{$user->intern_students_count()}}</div>
            </div>
            <div class="ico bg-indigo-100">
                <i class="bi bi-person-circle text-indigo-400"></i>
            </div>
        </a>
        <a href="{{route('teacher.mycourses.index')}}" class="pallet-box">
            <div class="flex-1">
                <div class="title">Pending Result</div>
                <div class="h2">{{$user->intern_course_allocations()->whereNull('submitted_at')->count()}}/{{$user->intern_course_allocations()->count()}} </div>
            </div>
            <div class="ico bg-teal-100">
                <i class="bi bi-clock text-teal-600"></i>
            </div>
        </a>
        @php
        if($user->intern_course_allocations()->count())
        $result_percentage=round($user->intern_course_allocations()->whereNotNull('submitted_at')->count()/$user->intern_course_allocations()->count()*100,0);
        else
        $result_percentage='-';
        @endphp
        <a href="" class="pallet-box">
            <div class="flex-1">
                <div class="title">Result Submission</div>
                <div class="h2"> {{$result_percentage}} %</div>
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
            <div class="p-4 bg-red-50">


            </div>

        </div>
        <!-- middle panel end -->
        <!-- right side bar starts -->
        <div class="">

            <div class="p-4 bg-sky-100">
                <h2>Profile</h2>
                <div class="flex flex-col">
                    <div class="flex text-sm mt-4">
                        <div class="w-8"><i class="bi-person"></i></div>
                        <div>{{ $user->name }}</div>
                    </div>
                    <div class="flex text-sm mt-2">
                        <div class="w-8"><i class="bi-envelope-at"></i></div>
                        <div>{{ $user->email }}</div>
                    </div>
                    <div class="flex text-sm mt-2">
                        <div class="w-8"><i class="bi-phone"></i></div>
                        <div>{{ $user->phone }}</div>
                    </div>
                    <div class="divider border-blue-200 mt-4"></div>
                    <div class="flex text-sm mt-4">
                        <div class="w-8"><i class="bi-key"></i></div>
                        <a href="{{route('edit.pw')}}" class="link">Change Password</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection