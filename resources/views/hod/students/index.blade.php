@extends('layouts.hod')
@section('page-content')

<h1>Student Profile</h1>
<div class="text-sm">{{session('department')->name}}</div>

<div class="flex items-center mt-12">
    <input type="text" placeholder="Search by name or roll no." class="search-indigo w-1/3" oninput="search(event)">
    <div class="flex justify-center items-center btn-teal w-8 h-8 rounded-full"><i class="bx bx-search"></i></div>
</div>


<div class="flex flex-row w-full mt-8 font-semibold py-1">
    <div class="w-1/6">Roll No</div>
    <div class="w-1/3">Name</div>
    <div class="w-1/3">Father</div>
    <div>Class</div>
</div>

<div class="flex flex-row w-full even:bg-slate-100 py-1">
    <a href="" class="w-1/5">Roll NO</a>
    <div class="w-2/5">Name s/o father</div>
    <div>Class</div>
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