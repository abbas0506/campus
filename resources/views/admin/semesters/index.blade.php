@extends('layouts.admin')
@section('page-content')
<div class="container">
    <h2>Semesters</h2>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Home</a>
        <div>/</div>
        <div>Semesters</div>
    </div>


    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="mt-8">
        <div class="flex items-center flex-wrap justify-between">
            <!-- search -->
            <div class="flex relative w-full md:w-1/3 mt-8">
                <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
                <i class="bx bx-search absolute top-2 right-2"></i>
            </div>
            <form method='post' action="{{route('admin.semesters.store')}}">
                @csrf
                <button type="submit" class="btn-indigo">Add New Semester</button>
            </form>
        </div>
        <table class="table-auto w-full mt-8">
            <thead>
                <tr class="border-b border-slate-200">
                    <th>Code</th>
                    <th>Semester</th>
                    <th>Year</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>

                @foreach($semesters->sortByDesc('status') as $semester)
                <tr class="tr border-b text-center ">
                    <td class="py-2 text-slate-600">{{$semester->short()}}</td>
                    <td class="py-2 text-slate-600">{{$semester->semester_type->name}}</td>
                    <td class="py-2 text-slate-600">{{$semester->year}}</td>
                    <td>
                        <a href="{{route('admin.semesters.edit', $semester)}}" class="flex justify-center">
                            @if($semester->status==1)
                            <i class="bi bi-toggle2-on text-teal-600 text-lg"></i>
                            @else
                            <i class="bi bi-toggle2-off text-red-600 text-lg"></i>
                            @endif
                        </a>

                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <script type="text/javascript">
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
            var str = 0;
            $('.tr').each(function() {
                if (!(
                        $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        }
    </script>

    @endsection