@extends('layouts.teacher')
@section('page-content')
<h1 class="mt-12"><a href="{{route('mycourses.index')}}">My Courses</a></h1>
<div class="flex flex-col flex-1 text-sm text-slate-800 py-3">
    <div class="font-bold">{{$course_allocation->course->name}}</div>
    <div>{{$course_allocation->section->title()}}</div>
</div>

<div class="container w-full mx-auto mt-8">
    <div class="flex items-center flex-wrap justify-between">
        <div class="flex relative ">
            <input type="text" placeholder="Search ..." class="search-indigo" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
        <div class="flex items-center text-sm space-x-4">
            @if($course_allocation->strength()>0)
            <a href="{{route('formative.edit', $course_allocation)}}" class="flex items-center px-4 py-2 btn-teal" id='btnStartFeeding'>
                Formative
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
            </a>
            <a href="{{route('summative.edit', $course_allocation)}}" class="flex items-center px-3 py-2 btn-indigo" id='btnStartFeeding'>
                Summative
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
            </a>
            @endif
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

    <input type="text" id='course_allocation_id' value="{{$course_allocation->id}}" class="hidden">

    <!-- Fresh students -->
    <section id='sxnEnrolled' class="mt-4">
        <div class="flex items-center py-2">
            <div>Fresh Students</div>
            <div class="text-xs ml-3 text-slate-600">({{$course_allocation->first_attempts->count()}} records found)</div>
            <!-- enroll fresh -->
            <a href="{{route('enroll.fa', $course_allocation)}}" class="ml-8 btn-red">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
            </a>
            <div class="text-slate-600 text-xs ml-1">(Enroll Fresh Student)</div>
        </div>

        <table class="table-auto w-full">
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
                                <div class="bg-indigo-500 w-2 h-2 rounded-full"></div>
                                @else
                                <div class="bg-green-500 w-2 h-2 rounded-full"></div>
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
                        <form action="{{route('first_attempts.destroy',$first_attempt)}}" method="POST" id='del_form{{$first_attempt->student->id}}' class="flex items-center justify-center">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-transparent py-2 border-0 text-red-700" onclick="del('{{$first_attempt->student->id}}')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

                <!-- Re-appear cases -->
                <tr>
                    <td class="text-red-800 text-sm py-3 border-0" colspan="8">
                        <div class="flex items-center">
                            <div>*Re-appearing Students</div>
                            <div class="text-xs ml-3 text-slate-600">({{$course_allocation->reappears->count()}} records found)</div>
                            <!-- add new reappear -->
                            <a href="{{route('enroll.ra', $course_allocation)}}" class="ml-8 btn-red">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </a>
                            <div class="text-slate-600 text-xs ml-1">(Enroll Old Student)</div>
                        </div>
                    </td>
                </tr>
                @foreach($course_allocation->reappears_sorted() as $reappear)
                <tr class="tr border-b ">
                    <td class="py-2">
                        <div class="flex items-center space-x-4">
                            <div>
                                @if($reappear->first_attempt->student->gender=='M')
                                <div class="bg-indigo-500 w-2 h-2 rounded-full"></div>
                                @else
                                <div class="bg-green-500 w-2 h-2 rounded-full"></div>
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
                            <form action="{{route('reappears.destroy',$reappear)}}" method="POST" id='del_form{{$reappear->first_attempt->student->id}}' class="mt-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-transparent py-2 border-0 text-red-700" onclick="del('{{$reappear->first_attempt->student->id}}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

</div>

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
</script>

@endsection