@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Courses</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <div>Courses</div>
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

    <div class="flex flex-wrap items-center justify-between mt-4">
        <div class="text-sm  text-gray-500" id='lbl_filteredBy'>{{$courses->count()}} records found</div>
        <div class="flex items-center space-x-4">
            <div onclick="toggleFilterSection()" class="hover:cursor-pointer"><i class="bi-filter pr-2"></i>Filter</div>
            <a href="{{route('courses.create')}}" class="btn-indigo">
                Add New
            </a>
        </div>
    </div>

    <div id="filterSection" class="hidden border border-slate-200 p-4 mt-4">
        <div class="grid grid-col-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <div id='all' class="filterOption active" onclick="filter('all')">
                <span class="desc">All</span>
                <span class="ml-1 text-sm text-slate-600">
                    ({{$courses->count()}})
                </span>
            </div>
            @foreach($course_types as $course_type)

            <div id='{{$course_type->id}}' class="filterOption" onclick="filter('{{$course_type->id}}')">
                <span class="desc">{{$course_type->name}}</span>
                <span class="ml-1 text-sm text-slate-600">
                    ({{App\Models\Course::type($course_type->id)->deptt(session('department_id'))->count()}})
                </span>
            </div>
            @endforeach
        </div>
    </div>
    <div class="overflow-x-auto mt-4">
        <table class="table-fixed w-full">
            <thead>
                <tr class="border-b border-slate-200">
                    <th class="w-24">Code</th>
                    <th class="w-60">Course Name</th>
                    <th class="w-32">Type</th>
                    <th class="w-24">Cr Hrs.</th>
                    <th class="w-24">Marks</th>
                    <th class='w-24'>Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach($courses->sortByDesc('id') as $course)
                <tr class="tr border-b ">
                    <td class="text-center">{{$course->code}}</td>
                    <td class="">
                        <div>{{$course->name}}</div>
                        <div class="text-slate-400">{{$course->short}}</div>
                    </td>
                    <td class="hidden">{{$course->course_type->id}}</td>
                    <td class="text-center">{{$course->course_type->name}}</td>

                    <td class="text-center">{{$course->creditHrsLabel()}}</td>
                    <td class="text-center">
                        {{$course->marks_theory}} + {{$course->marks_practical}}
                    </td>

                    <td>
                        <div class="flex justify-center items-center space-x-3">
                            <a href="{{route('courses.edit', $course)}}">
                                <i class="bi bi-pencil-square text-green-600"></i>
                            </a>
                            @role('super')
                            <form action="{{route('courses.destroy',$course)}}" method="POST" id='del_form{{$course->id}}'>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-transparent p-0 border-0" onclick="delme('{{$course->id}}')">
                                    <i class="bi bi-trash3 text-red-600"></i>
                                </button>
                            </form>
                            @endrole
                        </div>
                    </td>
                </tr>
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