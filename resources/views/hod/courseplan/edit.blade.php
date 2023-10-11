@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Edit Course Allocation</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{url('courseplan')}}">Course Allocation</a>
        <div>/</div>
        <div>Edit</div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <h1 class='text-red-600 mt-8'>{{$course_allocation->section->title()}}</h1>
    <h2 class='mt-4'>Slot # {{$course_allocation->slot_option->slot->slot_no}} ({{$course_allocation->slot_option->course_type->name}})</h2>

    <div class="p-4 border border-dashed bg-white relative mt-4">
        <div class="absolute top-2 right-2 flex flex-row items-center space-x-2">

            @if(Auth::user()->hasRole('super') || !$course_allocation->first_attempts()->exists())
            <form action="{{route('courseplan.destroy',$course_allocation)}}" method="POST" id='del_form{{$course_allocation->id}}'>
                @csrf
                @method('DELETE')
                <button type="submit" class="" onclick="delme('{{$course_allocation->id}}')">
                    <i class="bx bx-trash hover:text-red-600"></i>
                </button>
            </form>
            @endif

        </div>

        <label for="" class="text-xs">Course</label>
        <div class="flex flex-wrap">
            <div class="w-24">{{$course_allocation->course->code }}</div>
            <div class="">{{$course_allocation->course->name }} <span class="text-slate-400 text-xs">{{ $course_allocation->course->lblCr() }}</span></div>
        </div>
    </div>
    <div class="p-4 border border-dashed bg-white relative mt-4">
        <a href="{{route('courseplan.teachers',$course_allocation)}}" class="absolute top-2 right-2"><i class="bx bx-pencil"></i></a>
        <label for="" class="text-xs">Allocated Teacher</label>
        @if($course_allocation->teacher()->exists())
        <div>{{$course_allocation->teacher->name }}</div>
        @else
        <div class="text-slate-400 text-xs">(blank)</div>
        @endif
    </div>
    <!-- enrollment -->
    <div class="p-4 border border-dashed bg-white relative mt-4">
        <label for="" class="text-xs">Enrollment</label>
        @if($course_allocation->first_attempts()->exists())
        <div class="flex items-center gap-x-4">
            <div> <a href="{{route('hod.enroll.fresh', $course_allocation)}}" class="link">Fresh</a> <span class="text-slate-400 ml-2">({{$course_allocation->first_attempts->count()}})</span></div>
            <div>|</div>
            <div><a href="{{route('hod.enroll.reappear', $course_allocation)}}" class="link">Reappear</a><span class="text-slate-400 ml-2">({{$course_allocation->reappears->count()}})</span></div>
        </div>
    </div>

    @else
    <div class="text-slate-400 text-xs">(blank)</div>
    @endif

    <div class="overflow-x-auto w-full">
        <table class="table-fixed w-full mt-4">
            <thead>
                <tr class="border-b border-slate-200">
                    <th class="w-60">Name</th>
                    <th class="w-48">Father</th>
                    <th class="w-24">Status</th>
                    <th class='text-center w-24'>Remove</th>
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
                        <form action="{{route('hod.first-attempts.destroy',$first_attempt)}}" method="POST" id='del_form{{$first_attempt->student->id}}' class="flex items-center justify-center">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-transparent py-2 border-0 text-red-700" onclick="del('{{$first_attempt->student->id}}')">
                                <i class="bi bi-person-dash text-lg"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- reappearing -->
        @if($course_allocation->reappears()->exists())
        <h2>Re-appearing Students</h2>
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
        @endif
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(2).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }

    function delme(formid) {

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
</script>
@endsection