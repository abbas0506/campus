@extends('layouts.teacher')
@section('page-content')
<div class="flex">
    <a href="{{route('mycourses.index')}}" class="text-xs text-blue-600"> <i class="bx bx-chevron-left mr-2"></i>My Courses</a>
</div>

<div class="flex flex-col items-center justify-center border border-dashed border-slate-300 bg-slate-50 p-2 mt-2">
    <div class="font-semibold text-slate-700 text-lg leading-relaxed">Enroll New Students</div>
    <div class="text-sm">{{$course_allocation->course->name}}</div>
    <div class="text-sm">{{$course_allocation->section->title()}}</div>
</div>

<div class="container w-full mx-auto mt-8">
    <div class="flex items-center flex-wrap justify-between">
        <div class="flex relative ">
            <input type="text" placeholder="Search ..." class="search-indigo" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
    </div>
    @if ($errors->any())
    <div class="alert-danger mt-8">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="flex alert-success items-center mt-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>

        {{session('success')}}
    </div>
    @endif

    <!-- Fresh students -->
    <section id="tab_fresh" class="mt-8">
        <div class="flex items-end justify-between">
            <div class="flex items-center space-x-4">
                <div class="flex items-center justify-center rounded-full bg-orange-100 w-8 h-8">
                    <span class="bx bx-group rounded-full"></span>
                </div>
                <div class="tab active">Fresh : {{$course_allocation->first_attempts->count()}}</div>
                <div class="mx-1 text-xs font-thin">|</div>
                <div class="tab" onclick="toggle('f')">Re-Appear : {{$course_allocation->reappears->count()}}</div>
            </div>
            <a href="{{route('enroll.fa', $course_allocation)}}" class="btn-teal">
                <i class="bi bi-person-add"></i>
            </a>
        </div>

        <table class="table-auto w-full mt-4">
            <thead>
                <tr class="border-b border-slate-200">
                    <th>Name</th>
                    <th>Father</th>
                    <th>Status</th>
                    <th class='text-center'>Remove</th>
                </tr>
            </thead>
            <tbody>
                @foreach($course_allocation->first_attempts_sorted() as $first_attempt)
                <tr class="tr border-b ">
                    <td class="py-2">
                        <div class="flex items-center space-x-4">
                            <div>
                                @if($first_attempt->student->gender=='M')
                                <i class="bx bx-male text-teal-600 text-lg"></i>
                                @else
                                <i class="bx bx-female text-indigo-400 text-lg"></i>
                                @endif
                            </div>
                            <div>
                                <div class="text-slate-600">{{$first_attempt->student->name}}</div>
                                <div class="text-slate-600 text-sm">
                                    {{$first_attempt->student->rollno}}
                                </div>
                            </div>

                        </div>

                    </td>
                    <td hidden>{{$first_attempt->student->gender}}</td>
                    <td class="py-2 text-slate-600 text-sm">
                        {{$first_attempt->student->father}}
                    </td>
                    <td class="text-center">Fresh</td>

                    <td>
                        @role('super')
                        <form action="{{route('first_attempts.destroy',$first_attempt)}}" method="POST" id='del_form{{$first_attempt->student->id}}' class="flex items-center justify-center">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-transparent py-2 border-0 text-red-700" onclick="del('{{$first_attempt->student->id}}')">
                                <i class="bi bi-person-dash text-lg"></i>
                            </button>
                        </form>
                        @endrole
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <!-- Reappearig students -->
    <section id='tab_reappear' class="mt-8 hidden">
        <div class="flex items-end justify-between py-2 space-x-5 ">
            <div class="flex items-center space-x-4">
                <div class="flex items-center justify-center rounded-full bg-orange-100 w-8 h-8">
                    <span class="bx bx-group rounded-full"></span>
                </div>
                <div class="tab active">Re-Appear : {{$course_allocation->reappears->count()}}</div>
                <div class="mx-1 text-xs font-thin">|</div>
                <div class="tab" onclick="toggle('r')">Fresh : {{$course_allocation->first_attempts->count()}}</div>
            </div>
            <a href="{{route('enroll.ra', $course_allocation)}}" class="btn-teal">
                <i class="bi bi-person-add"></i>
            </a>
        </div>

        <table class="table-auto w-full mt-4">
            <thead>
                <tr class="border-b border-slate-200">
                    <th>Name</th>
                    <th>Father</th>
                    <th>Status</th>
                    <th class='text-center'>Remove</th>
                </tr>
            </thead>
            <tbody>
                @foreach($course_allocation->reappears_sorted() as $reappear)
                <tr class="tr border-b ">
                    <td class="py-2">
                        <div class="flex items-center space-x-4">
                            <div>
                                @if($reappear->first_attempt->student->gender=='M')
                                <i class="bx bx-male text-teal-600 text-lg"></i>
                                @else
                                <i class="bx bx-female text-indigo-400 text-lg"></i>
                                @endif
                            </div>
                            <div>
                                <div class="text-slate-600">{{$reappear->first_attempt->student->name}}</div>
                                <div class="text-slate-600 text-sm">
                                    {{$reappear->first_attempt->student->rollno}}
                                    @if($reappear->first_attempt->student->regno)
                                    | {{$reappear->first_attempt->student->regno}}
                                    @endif
                                </div>
                            </div>

                        </div>

                    </td>
                    <td hidden>{{$reappear->first_attempt->student->gender}}</td>
                    <td class="py-2 text-slate-600 text-sm">
                        {{$reappear->first_attempt->student->father}}
                    </td>
                    <td class="text-center">Reappear</td>
                    <td>
                        <div class="flex justify-center items-center py-2">
                            @role('super')
                            <form action="{{route('reappears.destroy',$reappear)}}" method="POST" id='del_form{{$reappear->first_attempt->student->id}}' class="mt-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-transparent py-2 border-0 text-red-700" onclick="del('{{$reappear->first_attempt->student->id}}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                    </svg>
                                </button>
                            </form>
                            @endrole
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function del(formid) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                //submit corresponding form
                $('#del_form' + formid).submit();
            }
        });
    }

    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        var str = 0;
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) || $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }

    function toggle(opt) {
        if (opt == "f") {
            $("#tab_fresh").slideUp();
            $("#tab_reappear").slideDown();
        }
        if (opt == "r") {
            $("#tab_fresh").slideDown();
            $("#tab_reappear").slideUp();
        }
    }
</script>

@endsection