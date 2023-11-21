@extends('layouts.controller')
@section('page-content')
<div class="container">
    <h2>Student Transcript</h2>
    <div class="bread-crumb">
        <a href="{{url('controller')}}">Home</a>
        <div>/</div>
        <div>Transcripts</div>
    </div>

    <!-- search -->
    <div class="flex relative w-full md:w-1/3 mt-8">
        <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full">
        <div class="flex justify-center items-center btn-teal w-8 h-8 rounded-full" onclick='search()'><i class="bx bx-search"></i></div>
        <!-- <i class="bx bx-search absolute top-2 right-2"></i> -->
    </div>
    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="flex flex-row w-full mt-8 font-semibold bg-slate-100 py-1">
        <div class="w-1/4">Roll No</div>
        <div class="w-1/4">Name</div>
        <div class="w-1/4">Father</div>
        <div class="1/4">Class</div>
    </div>
    <div id='tbody' class="text-sm text-slate-600">
        <div class="mt-4 text-teal-800 animate-bounce text-md">Type a few letters from the student's name or roll no. Press on search icon; result will be shown here</div>
    </div>

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
                url: "{{url('/controller/searchAllByRollNoOrName')}}",
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