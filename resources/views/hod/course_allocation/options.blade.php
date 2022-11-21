@extends('layouts.hod')

@section('page-content')

<h1 class="mt-5">Course Allocation</h1>
<div class="bread-crumb mb-3">
    Course Allocation / choose section (Step 1 out of 4)
</div>

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
            <li><u>Note </u>: Courses are allocated on section level. Pls follow following steps </li>
            <li>Choose a class</li>
            <li>Sections list will appear, choose one of them and proceed</li>
        </ul>
    </div>
    <div class="rounded md:mt-0 mt-12">

        <form action="{{route('course-allocation-options.store')}}" method='post' class="flex flex-col">
            @csrf
            <div class='flex items-center space-x-4'>
                <div class="flex flex-col grow">
                    <label for="" class="mt-5">Classes</label>
                    <select id="clas_id" name="clas_id" class="input-indigo p-2" onchange="loadSections(event)">
                        <option value="">Select a class</option>
                        @foreach($clases as $clas)
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
            <div class="flex space-x-4 justify-end">
                <a href="{{url('hod')}}" class="flex justify-center btn-indigo mt-8">Cancel</a>
                <button type="submit" class="flex justify-center btn-indigo mt-8">Next</button>
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
</script>
@endsection