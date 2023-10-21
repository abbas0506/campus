@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Assessment Progress</h2>
    <div class="bread-crumb">
        <a href="{{url('hod')}}">Home</a>
        <div>/</div>
        <div>Assessment</div>
    </div>

    <!-- search -->
    <div class="flex flex-wrap items-center justify-between w-full mt-8 gap-y-4">
        <div class="relative">
            <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
            <i class="bx bx-search absolute top-2 right-2"></i>
        </div>
        <form action="{{route('hod.assessment.missing.notify')}}" class="text-sm" method="post">
            @csrf
            <button type="submit" class="btn-teal"><i class="bi-bell mr-2"></i>Send Reminder <span class="text-xs">({{$course_allocations->whereNull('submitted_at')->count()}}/{{$course_allocations->count()}})</span></button>
        </form>

    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="overflow-x-auto mt-4">
        <table class="table-fixed w-full text-sm">
            <thead>
                <tr class="text-xs">
                    <th class="w-40">Class</th>
                    <th class="w-24">Code</th>
                    <th class="w-60">Course Name</th>
                    <th class="w-16">Fresh</th>
                    <th class="w-16">Re</th>
                    <th class='w-32'>Submission</th>
                </tr>
            </thead>
            <tbody>
                @php
                $last_section_id='';
                @endphp

                @foreach($course_allocations->whereNull('submitted_at') as $course_allocation)
                <tr class="tr text-xs">
                    <td>
                        @if($last_section_id!=$course_allocation->section->id)
                        {{$course_allocation->section->title()}}
                        @endif
                    </td>
                    <td>{{$course_allocation->course->code}}</td>
                    <td class="text-left">{{$course_allocation->course->name}} <span class="text-slate-400 text-xs">{{$course_allocation->course->lblCr()}}</span> <br> <span class="text-slate-400">{{$course_allocation->teacher->name}}</span></td>
                    <td>{{$course_allocation->first_attempts->count()}}</td>
                    <td>{{$course_allocation->reappears->count()}}</td>
                    <td>Pending</td>

                </tr>

                @php
                if($last_section_id!=$course_allocation->section->id)
                $last_section_id=$course_allocation->section->id;
                @endphp

                @endforeach
            </tbody>
        </table>

        <!-- submitted results -->
        <div class="overflow-x-auto mt-4">
            <table class="table-fixed w-full text-sm">
                <thead>
                    <tr class="text-xs">
                        <th class="w-40">Class</th>
                        <th class="w-24">Code</th>
                        <th class="w-60">Course Name</th>
                        <th class="w-16">Fresh</th>
                        <th class="w-16">Re</th>
                        <th class='w-32'>Submission</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $last_section_id='';
                    @endphp


                    @foreach($course_allocations->whereNotNull('submitted_at') as $course_allocation)
                    <tr class="tr text-xs">
                        <td>
                            @if($last_section_id!=$course_allocation->section->id)
                            {{$course_allocation->section->title()}}
                            @endif
                        </td>
                        <td>{{$course_allocation->course->code}}</td>
                        <td class="text-left">{{$course_allocation->course->name}} <span class="text-slate-400 text-xs">{{$course_allocation->course->lblCr()}}</span> <br> <span class="text-slate-400">{{$course_allocation->teacher->name}}</span></td>
                        <td>{{$course_allocation->first_attempts->count()}}</td>
                        <td>{{$course_allocation->reappears->count()}}</td>
                        <td>{{$course_allocation->submitted_at}}
                            <br>
                            <div class="flex items-center justify-center mt-1 space-x-1">
                                <a href="{{route('hod.assessment.show',$course_allocation)}}" class="btn-green rounded"><i class="bi-eye"></i></a>
                                <form action="{{route('hod.assessment.unlock',$course_allocation)}}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-sky rounded"><i class="bi-unlock"></i></button>
                                </form>

                            </div>

                        </td>
                    </tr>

                    @php
                    if($last_section_id!=$course_allocation->section->id)
                    $last_section_id=$course_allocation->section->id;
                    @endphp

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection
    @section('script')
    <script>
        //code here
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

        function search(event) {
            var searchtext = event.target.value.toLowerCase();
            $('.tr').each(function() {
                if (!(
                        $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) ||
                        $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        }


        function filter(id) {
            //drop prefix courses_ from the id of course types to be filtered
            $('.filterOption').each(function() {

                // alert($(this).attr('id'))
                if ($(this).attr('id') != id)
                    $(this).removeClass('active')
                else {
                    $('#lbl_filteredBy').html($(this).html());
                    if (!$(this).hasClass('active')) {
                        $(this).addClass('active')
                    }
                }


            });
            searchtext = id;

            if (searchtext == 'all') {
                //remove filter
                $('.tr').each(function() {
                    $(this).removeClass('hidden');
                });
            } else {
                //apply filter
                $('.tr').each(function() {
                    if (!(
                            $(this).children().eq(2).prop('outerText').toLowerCase().includes(searchtext)

                        )) {
                        $(this).addClass('hidden');

                    } else {
                        $(this).removeClass('hidden');
                        console.log(searchtext + ',')
                    }

                });
            }
        }

        function toggleFilterSection() {
            $('#filterSection').slideToggle().delay(500);
        }
    </script>

    @endsection