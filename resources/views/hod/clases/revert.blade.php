@extends('layouts.hod')
@section('page-content')
<h1><a href="{{route('clases.index')}}">Classes / Sections</a></h1>
<div class="bread-crumb">Classes / revert</div>

<div class="flex items-center space-x-2 mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
    </svg>
    <ul class="text-xs">
        <li>You may revert single or multiple classes at a time</li>
        <li>Click on any program and check the classes and press on revert button. (if some class gets accidently reverted, you may undo it by its promotion) </li>
    </ul>
</div>

<!-- search bar -->
<div class="flex items-center justify-end mt-8">
    <div class="flex items-center space-x-3">
        <div id="chkCount" class="flex justify-center items-center w-8 h-8 rounded-full bg-orange-100 text-slate-600">0</div>
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
<div class="flex flex-col accordion">
    @foreach($programs->sortBy('level') as $program)
    <div class="collapsible">
        <div class="head">
            <h2 class="flex items-center space-x-4">
                {{$program->short}}
                <span class="text-xs ml-4 font-thin">Classes:{{$program->clases()->count()}}</span>
            </h2>
            <i class="bx bx-chevron-down text-lg"></i>
        </div>
        <div class="body">
            @foreach($program->clases as $clas)
            <div class="flex items-center justify-between w-full even:bg-slate-100 py-1 space-x-4">
                <div class="text-sm ml-2 flex-1">{{$clas->short()}}</div>
                <div class="text-xs text-slate-400"><i class="bx bx-user"></i> ({{$clas->strength()}})</div>
                <input type="checkbox" name='chk' value="{{$clas->id}}" onclick="updateChkCount()">
            </div>
            @endforeach
        </div>
    </div>

    @endforeach

</div>
@endsection

@section('script')
<script type="text/javascript">
    function updateChkCount() {

        var chkArray = [];
        var chks = document.getElementsByName('chk');
        chks.forEach((chk) => {
            if (chk.checked) chkArray.push(chk.value);
        })
        document.getElementById("chkCount").innerHTML = chkArray.length;
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
                        url: "{{route('reversions.store')}}",
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
</script>

@endsection