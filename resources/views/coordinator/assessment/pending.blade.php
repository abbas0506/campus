@extends('layouts.coordinator')
@section('page-content')

<div class="container">
    <h2>Assessment Progress</h2>
    <div class="bread-crumb">
        <a href="{{url('coordinator')}}">Home</a>
        <div>/</div>
        <div>Assessment</div>
    </div>

    <!-- search -->
    <div class="relative mt-4 md:w-1/3">
        <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
        <i class="bx bx-search absolute top-2 right-2"></i>
    </div>
    <div class="flex flex-wrap items-center justify-between w-full mt-8 gap-y-4">
        <div class="flex items-center space-x-4 text-slate-600">
            <a href="{{route('coordinator.assessment.submitted')}}" class="tab">Submitted ({{$department->current_allocations()->submitted()->count()}})</a>
            <p class="tab active">Pending ({{$department->current_allocations()->pending()->count()}})</p>
        </div>
        <form action="{{route('coordinator.assessment.missing.notify')}}" class="text-sm" method="post">
            @csrf
            <button type="submit" class="btn-teal"><i class="bi-bell mr-2"></i>Send Reminder ({{$department->current_allocations()->pending()->count()}})</button>
        </form>

    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif
    <!-- pending assessments -->
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
                    <th class='w-8'></th>
                </tr>
            </thead>
            <tbody>
                @php
                $last_section_id='';
                @endphp

                @foreach($department->current_allocations()->pending()->get() as $course_allocation)
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
                    <td>
                        <form action="{{route('coordinator.assessment.missing.notify.single')}}" class="text-sm" method="post">
                            @csrf
                            <input type="hidden" name="course_allocation_id" value="{{$course_allocation->id}}">
                            <button type="submit" class="text-teal-500 hover:text-orange-500"><i class="bi-bell"></i></button>
                        </form>
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