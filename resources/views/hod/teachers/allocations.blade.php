@extends('layouts.hod')
@section('page-content')
<div class="responsive-container">
    <h2>Teacher Allocations</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <a href="{{route('hod.teachers.index')}}">Teachers</a>
        <div>/</div>
        <div>Allocations</div>
    </div>

    <div class="w-full mx-auto">
        <div class="flex items-center space-x-4 text-slate-600 mt-8">
            <a href="{{route('hod.teachers.index')}}" class="tab">All</a>
            <p class="tab active">Having Allocations</p>
        </div>
        <!-- search -->
        <div class="flex relative w-full md:w-1/3 mt-8">
            <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
            <i class="bx bx-search absolute top-2 right-2"></i>
        </div>
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="overflow-x-auto mt-4 w-full">
            <table class="table-fixed w-full">
                <thead>
                    <tr>
                        <th class="w-32"> <i class="bx bx-group"></i> Teacher : {{$teachers->count()}}</th>
                        <th class="w-12">Cr</th>
                        <th class="w-48">Morning</th>
                        <th class="w-48">Evenig</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($teachers as $teacher)
                    <tr class="tr text-xs">
                        <td class="text-left md:pl-4">
                            <a href="{{ route('hod.teachers.show',$teacher) }}" class="link">{{$teacher->name}}</a>
                            <br>
                            {{$teacher->phone}} (@if($teacher->is_regular)Regular @else Visiting @endif)
                        </td>
                        <td>{{$teacher->course_allocations()->shift(1)->sumOfCr()}}+{{$teacher->course_allocations()->shift(2)->sumOfCr()}}</td>
                        <td>
                            @foreach($teacher->course_allocations()->shift(1)->get() as $course_allocation )
                            <div class="text-xs text-left">{{$course_allocation->course->code}} <span class="text-slate-400">({{ $course_allocation->course->lblCr()}})</span>, {{$course_allocation->course->name}}</div>
                            <div class="text-xs"></div>
                            @endforeach
                        </td>
                        <td>
                            @foreach($teacher->course_allocations()->shift(2)->get() as $course_allocation )
                            <div class="text-xs text-left">{{$course_allocation->course->code}} <span class="text-slate-400">({{ $course_allocation->course->lblCr()}})</span>, {{$course_allocation->course->name}}</div>
                            <div class="text-xs"></div>
                            @endforeach
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
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