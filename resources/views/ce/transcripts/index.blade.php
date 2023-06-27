@extends('layouts.controller')
@section('page-content')
<div class="flex">
    <a class="text-xs text-blue-600"> <i class="bi bi-clock mr-2"></i>{{\Carbon\Carbon::now()}}</a>
</div>

<div class="flex flex-col items-center justify-center border border-dashed border-slate-300 bg-slate-50 p-2 mt-2">
    <div><i class="bi bi-printer text-4xl"></i></div>
    <div class="font-semibold text-slate-700 text-lg leading-relaxed">Student Transcript</div>
</div>

<div class="flex items-center mt-12">
    <input type="text" id='searchby' placeholder="Search by name or roll no." class="search-indigo w-1/3">
    <div class="flex justify-center items-center btn-teal w-8 h-8 rounded-full" onclick='search()'><i class="bx bx-search"></i></div>
</div>


<div class="flex flex-row w-full mt-8 font-semibold bg-slate-100 py-1">
    <div class="w-1/4">Roll No</div>
    <div class="w-1/4">Name</div>
    <div class="w-1/4">Father</div>
    <div class="1/4">Class</div>
</div>
<div id='tbody' class="text-sm text-slate-600">
    <div class="mt-4 text-teal-800 animate-bounce text-md">Type a few letters from the student's name or roll no. Press on search icon; result will be shown here</div>
</div>


@endsection

@section('script')
<script type="text/javascript">
    function search() {
        var token = $("meta[name='csrf-token']").attr("content");

        var searchby = $('#searchby').val();
        if (searchby == '') {
            Swal.fire({
                icon: 'warning',
                title: "Nothing to search",
            });
        } else {
            //show sweet alert and confirm submission
            $.ajax({
                type: 'POST',
                url: "{{url('searchAllByRollNoOrName')}}",
                data: {
                    "searchby": searchby,
                    "_token": token,

                },
                success: function(response) {
                    $('#tbody').html(response.result)

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'warning',
                        title: errorThrown
                    });
                }
            }); //ajax end
        }
    }
</script>

@endsection