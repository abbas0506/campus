@extends('layouts.hod')
@section('page-content')
<h1 class="mt-12"><a href="{{route('clases.index')}}">Classes</a></h1>
<div class="bread-crumb">Classes / promote or revert</div>

<div class="flex items-center space-x-2 mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
    </svg>
    <ul class="text-xs">
        <li>You may promote single or multiple classes at a time</li>
        <li>While promoting any class, make sure, senior classes will be promoted first. (duplication will be rejected, if any)</li>
    </ul>
</div>

<!-- search bar -->
<div class="flex items-center justify-between mt-8">
    <div class="relative">
        <input type="text" placeholder="Search here" class="search-indigo w-full md:w-80" oninput="search(event)">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
    </div>

    <div class="flex items-center space-x-3">
        <div id="chkCount" class="flex justify-center items-center w-8 h-8 rounded-full bg-orange-100 text-slate-600">0</div>
        <button class="flex items-center text-sm btn-teal px-2" onclick="promote()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />
            </svg>
            <span class="ml-1">Promote</span>
        </button>
        <button class="flex items-center text-sm btn-red px-2" onclick="revert()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
            </svg>

            <span class="ml-1">Revert</span>
        </button>
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
@if(session('error'))
<div class="flex items-center alert-danger mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
    </svg>
    {{session('error')}}
</div>
@endif
<div class="text-xs  text-slate-600 mt-4 mb-1">{{$programs->count()}} programs found</div>
<table class="table-auto w-full">
    <thead>
        <tr>
            <th>Porgram</th>
            <th>Shift</th>
            <th>Classes</th>
            <th><input type="checkbox" id='chkAll' onclick="chkAll()"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($programs as $program)
        <tr class="tr{{$program->id}} tr">
            <td rowspan='{{$program->promotable_clases->count()+1}}'>{{$program->name}}</td>
        </tr>
        @foreach($program->promotable_clases as $clas)
        <tr class="tr{{$program->id}} chk">
            <td>{{$clas->shift->name}}</td>
            <td>{{$clas->subtitle()}}</td>
            <td class="text-center"><input type="checkbox" name='chk' value="{{$clas->id}}" onclick="updateChkCount()"></td>
        </tr>
        @endforeach
        @endforeach

    </tbody>
</table>
</section>

@endsection

@section('script')
<script type="text/javascript">
    function search(event) {
        var searchtext = event.target.value.toLowerCase();

        var classesToShow = [];
        $('.tr').each(function() {
            if ($(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext)) {
                var matched = $(this).attr('class').split(' ');
                classesToShow.push(matched[0]);
            }
        });
        var toShow = classesToShow;
        var rowid;
        $('tbody tr').each(function() {
            rowid = $(this).attr('class').split(' ')

            if ($.inArray(rowid[0], toShow) >= 0) {
                $(this).removeClass('hidden')

            } else
                $(this).addClass('hidden')
        });

    }

    function chkAll() {
        $('.chk').each(function() {
            if (!$(this).hasClass('hidden'))
                $(this).children().find('input[type=checkbox]').prop('checked', $('#chkAll').is(':checked'));

        });
        updateChkCount()
    }

    function updateChkCount() {

        var chkArray = [];
        var chks = document.getElementsByName('chk');
        chks.forEach((chk) => {
            if (chk.checked) chkArray.push(chk.value);
        })
        document.getElementById("chkCount").innerHTML = chkArray.length;
    }

    function promote() {

        var token = $("meta[name='csrf-token']").attr("content");
        var ids_array = [];
        var chks = document.getElementsByName('chk');
        chks.forEach((chk) => {
            if (chk.checked) ids_array.push(chk.value);
        })

        if (ids_array.length == 0) {
            Swal.fire({
                icon: 'warning',
                title: "Nothing to promote",
            });
        } else {
            //show sweet alert and confirm submission
            Swal.fire({
                title: 'Are you sure?',
                text: "Selected classes will be promoted to next semester!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, promote now'
            }).then((result) => { //if confirmed    
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: "{{route('clases.promote')}}",
                        data: {
                            "ids_array": ids_array,
                            "_token": token,

                        },
                        success: function(response) {
                            //
                            alert(response.msg)
                            // Swal.fire({
                            //     icon: 'success',
                            //     title: response.msg,
                            // });
                            // //refresh content after deletion
                            // location.reload();
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert(errorThrown)
                            // Swal.fire({
                            //     icon: 'warning',
                            //     title: errorThrown
                            // });
                        }
                    }); //ajax end
                }
            })
        }
    }


    function revert() {

        var token = $("meta[name='csrf-token']").attr("content");
        var ids_array = [];
        var chks = document.getElementsByName('chk');
        chks.forEach((chk) => {
            if (chk.checked) ids_array.push(chk.value);
        })

        if (ids_array.length == 0) {
            Swal.fire({
                icon: 'warning',
                title: "Nothing to revert",
            });
        } else {
            //show sweet alert and confirm submission
            Swal.fire({
                title: 'Are you sure?',
                text: "Selected classes will be reverted to previous semester!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, demote now'
            }).then((result) => { //if confirmed    
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: "{{route('clases.revert')}}",
                        data: {
                            "ids_array": ids_array,
                            "_token": token,

                        },
                        success: function(response) {
                            //

                            Swal.fire({
                                icon: 'success',
                                title: response.msg,
                            });
                            //refresh content after deletion
                            location.reload();
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Swal.fire({
                                icon: 'warning',
                                title: errorThrown
                            });
                        }
                    }); //ajax end
                }
            })
        }
    }

    function switchTo(opt) {
        if (opt == 'morning') {
            $('#morning').show()
            $('#selfsupport').hide()

        } else {
            $('#morning').hide()
            $('#selfsupport').show()
        }
    }
</script>

@endsection