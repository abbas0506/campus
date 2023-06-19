@extends('layouts.hod')
@section('page-content')
<h1>Students</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Students / All
    </div>
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

    <div class="flex items-center justify-between font-thin text-slate-600 mt-8 mb-4">
        <div class="flex items-center space-x-4">
            <div class="flex items-center bg-teal-300 px-2">
                <i class="bx bx-male-female mr-2"></i>{{$department->students()->count()}}
            </div>
            <i class="bx bx-chevrons-right"></i>
            <div class="flex items-center">
                <i class="bx bx-male"></i>0
            </div>
            <div class="flex items-center">
                <i class="bx bx-female"></i>0
            </div>
        </div>



    </div>

    <!-- registered students -->
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>Name / Father</th>
                <th>Roll No</th>
                <th>CNIC/Phone</th>
                <th>Class</th>
                <th>Semester #</th>
                <th>Status</th>
                <th>CGPA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($department->students()->sortBy('rollno') as $student)
            <tr class="tr">
                <td>
                    <div class="flex items-center space-x-4">
                        <div>
                            @if($student->gender=='M')
                            <i class="bx bx-male text-blue-600 text-lg"></i>
                            @else
                            <i class="bx bx-female text-teal-600 text-lg"></i>
                            @endif
                        </div>
                        <div>
                            <div class="text-slate-800">{{$student->name}}</div>
                            <div class="text-slate-400 text-sm">{{$student->father}}
                            </div>
                        </div>
                    </div>

                </td>
                <td class="text-center">{{$student->rollno}}</td>
                <td class="text-center">
                    <div>{{$student->cnic}}</div>
                    <div>{{$student->phone}}</div>
                </td>

                <td class="text-center">{{$student->semester_no}}</td>
                <td class="text-center">status</td>
                <td class="text-center">{{$student->section->clas->short()}}</td>
                <td class="text-center">{{$student->cgpa()}}</td>

            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- not registered -->

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
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) || $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext) || $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }
</script>

@endsection