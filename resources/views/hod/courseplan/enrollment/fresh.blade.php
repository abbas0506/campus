@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Enroll Fresh Students</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('hod.courseplan.index')}}">Semester Plan</a>
        <div>/</div>
        <a href="{{route('hod.courseplan.edit', $course_allocation)}}">{{$course_allocation->course->name}}</a>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="flex flex-col items-center justify-center border border-dashed border-slate-300 bg-slate-50 p-2 mt-6">
        <h2>{{$course_allocation->course->name}}</h2>
        <div class="text-sm">{{$course_allocation->section->title()}}</div>
    </div>


    <input type="hidden" name='course_allocation_id' value='{{$course_allocation->id}}'>

    <div class="flex items-center flex-wrap justify-between mt-6">
        <div class="flex relative w-60">
            <input type="text" placeholder="Search ..." class="search-indigo w-60" oninput="search(event)">
            <i class="bi bi-search absolute right-1 top-3"></i>
        </div>

        <form action="{{route('hod.enroll.fresh.post')}}" method="post">
            @csrf
            <input type="hidden" name='course_allocation_id' value='{{$course_allocation->id}}'>
            @foreach($unregistered as $student)
            <input type="checkbox" class="ids" id='{{$student->id}}' name='ids[]' value='{{$student->id}}' hidden>
            @endforeach
            <button type="submit" class="btn-teal">
                Enroll Fresh <span class="ml-2">(</span><span id='chkCount' class="">0</span>/{{$unregistered->count()}})
            </button>
        </form>

    </div>

    <div class="overflow-x-auto w-full mt-6">
        <table class="table-fixed w-full">
            <thead>
                <tr>
                    <th class="w-8"><input type="checkbox" id='chkAll' onclick='chkAll()'></th>
                    <th class="w-8"></th>
                    <th class="w-60">Name</th>
                    <th class="w-60">Father</th>
                </tr>
            </thead>
            <tbody>
                @foreach($unregistered as $student)
                <tr class="tr">
                    <td>
                        <input type="checkbox" name='chk' value='{{$student->id}}' onclick="updateChkCount()">
                    </td>
                    <td>
                        @if($student->gender=='M')
                        <i class="bx bx-male text-teal-600 text-lg"></i>
                        @else
                        <i class="bx bx-female text-indigo-400 text-lg"></i>
                        @endif
                    </td>
                    <td>
                        <div class="text-left">{{$student->name}}</div>
                        <div class="text-left">{{$student->rollno}}</div>
                    </td>
                    <td class="text-slate-600 text-sm">{{$student->father}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script>
    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        var str = 0;
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(2).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }

    function chkAll() {
        $('.tr').each(function() {
            if (!$(this).hasClass('hidden'))
                $(this).children().find('input[type=checkbox]').prop('checked', $('#chkAll').is(':checked'));

        });
        $(".ids").each(function() {
            $(this).prop('checked', $('#chkAll').is(':checked'));
        });

        updateChkCount()
    }

    function updateChkCount() {

        var chks = document.getElementsByName('chk');
        var checked_count = 0;
        chks.forEach((chk) => {
            $('#' + chk.value).prop('checked', chk.checked)
            if (chk.checked) checked_count++;
        })
        $('#chkCount').html(checked_count);
    }
</script>

@endsection