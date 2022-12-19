@extends('layouts.hod')

@section('page-content')

<h1 class="mt-12">Course Allocation</h1>
<div class="bread-crumb mb-3">Choose section & go next </div>

@if ($errors->any())
<div class="bg-red-100 text-red-700 text-sm p-5 mb-5 w-full">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="flex flex-col w-3/4 mx-auto mt-12 ">
    <div class="p-5 bg-slate-100">
        <h2>How to allocate courses?</h2>
        <ul class="list-disc text-sm text-slate-500 ml-8 leading-relaxed">
            <li>Choose a section & go next</li>
            <li>Follow the instructions on next page</li>
        </ul>
    </div>
    <div class="rounded md:mt-0 mt-12">

        <form action="{{route('course-allocation-options.store')}}" method='post' class="flex flex-col" onsubmit="return validate(event)">
            @csrf
            <div class='flex items-center space-x-4'>
                <div class="flex flex-col grow">
                    <label for="" class="mt-3">Classes</label>
                    <select id="clas_id" name="clas_id" class="input-indigo p-2" onchange="loadSections(event)">
                        <option value="">Select a class</option>
                        @foreach($clases->where('status',1) as $clas)
                        <option value="{{$clas->id}}">{{$clas->title()}}</option>
                        @endforeach
                    </select>

                </div>

                <div class="flex flex-col">
                    <label for="" class="mt-3">Section <span class='text-xs px-2 text-indigo-600'>(for course allocation)</span></label>
                    <select id='section_id' name="section_id" class="input-indigo p-2"></select>
                </div>
            </div>
            <span class="text-xs text-orange-700 pl-2">*Sections will appear only after you select a class</span>
            <div class="flex justify-end mt-4">
                <button type="submit" class="flex items-center justify-center btn-indigo px-2">
                    Next
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>
                </button>
            </div>
    </div>
    </form>

</div>

@endsection

@section('script')
<script lang="javascript">
    function clearSelection() {
        $('#program_id').val("");
        $('#section_id').val("");
        $('#scheme_id').val("");
    }

    function loadSections() {
        //token for ajax call
        var token = $("meta[name='csrf-token']").attr("content");

        var clas_id = $('#clas_id').val();
        var shift_id = $("input[name='shift_id']:checked").val();

        $.ajax({
            type: 'POST',
            url: "fetchSectionsByClas",
            data: {
                "clas_id": clas_id,
                "_token": token,

            },
            success: function(response) {
                //
                $('#section_id').html(response.section_options);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'warning',
                    title: errorThrown
                });
            }
        }); //ajax end
    }

    function validate(event) {
        var validated = true;
        var clas_id = $('#clas_id').val()
        var section_id = $('#section_id').val()

        if (clas_id == '' || section_id == '') {

            event.preventDefault();
            validated = false;

            Swal.fire({
                icon: 'warning',
                title: 'Required input missing!',
                showConfirmButton: false,
                timer: 1500,
            })

        }
        return validated;

    }
</script>
@endsection