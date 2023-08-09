@extends('layouts.hod')
@section('page-content')

<div class="container">
    <h2>Students</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <div>Students</div>
        <div>/</div>
        <div>Search</div>
    </div>

    <!-- search -->
    <div class="flex items-center mt-8">
        <input type="text" id='searchby' placeholder="Search by name or roll no." class="search-indigo w-full md:w-1/2">
        <div class="flex justify-center items-center btn-teal w-8 h-8 rounded-full" onclick='search()'><i class="bx bx-search"></i></div>
    </div>


    <div class="overflow-x-auto mt-8">
        <table class="table-fixed w-full">
            <thead>
                <tr>
                    <th class="w-48">Roll No</th>
                    <th class="w-60">Name</th>
                    <th class="w-60">Father</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
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
                    url: "{{url('searchByRollNoOrName')}}",
                    data: {
                        "searchby": searchby,
                        "_token": token,

                    },
                    success: function(response) {
                        $('tbody').html(response.result)

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