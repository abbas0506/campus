@extends('layouts.teacher')
@section('page-content')
<div class="container bg-slate-100">
    <!--welcome  -->
    <div class="flex items-center">
        <div class="flex-1">
            <h2>Welcome {{ Auth::user()->name }}!</h2>
            <div class="bread-crumb">
                <div>Teacher</div>
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
                <div class="title">Courses</div>
                <div class="h2">{{$user->allocations()->count()}}</div>
            </div>
            <div class="ico bg-green-100">
                <i class="bi bi-book text-green-600"></i>
            </div>
        </a>
        <a href="{{route('teacher.mycourses.index')}}" class="pallet-box">
            <div class="flex-1">
                <div class="title">Credit Hrs</div>
                <div class="h2">{{$user->allocations()->sum('cr')}}</div>
            </div>
            <div class="ico bg-teal-100">
                <i class="bi bi-clock text-teal-600"></i>
            </div>
        </a>

        <a href="" class="pallet-box">
            <div class="flex-1">
                <div class="title">Students</div>
                <div class="h2">?</div>
            </div>
            <div class="ico bg-indigo-100">
                <i class="bi bi-person-circle text-indigo-400"></i>
            </div>
        </a>
        <a href="" class="pallet-box">
            <div class="flex-1">
                <div class="title">Results</div>
                <div class="h2"> %</div>
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

                <h2>Important Features of ES V5.0 </h2>
                <ul class="list-disc pl-4 text-sm">
                    <li><u>Responsive</u> - app is easy to use on small screens as well </li>
                    <li><u>Single login</u> - for all open/authorized semesters. You may switch to other semesters easily (option available on header)</li>
                    <li><u>Dashboard</u> - provides you quick access to your profile info, passowrd change option, courses and their results' status </li>
                    <li><u>Page navigation</u> - links help you to navigate across pages. (highlighted in blue color)</li>
                    <li><u>Results</u> - of whole class can be fed at once. No need to submit data one by one.</li>
                    <li><u>Award lists</u> - are available in .xlsx and .pdf formats. Pdf version consists of 30 students per page. </li>
                </ul>
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