@extends('layouts.hod')

@section('page-content')

<h1 class="mt-5">Course Allocation</h1>
<div class="bread-crumb mb-3">
    Course Allocation / choose option (Step 1 out of 4)
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

<div class="flex space-x-8 mt-12 ">
    <div class="p-5 w-1/2 bg-slate-100">
        <h2>Read Me</h2>
        <ul class="list-disc text-sm text-slate-500 ml-8 leading-relaxed">
            <li>Basically, you are going to choose a program and a section whose courses will be automatically fetched according to your selected scheme.</li>
            <li>Sections list will appear only after you select a program. If no section appears even after program selection, go back and define section for the class</li>
            <li>Valid schemes automatically appear in the list. If no scheme appears, go back and define new scheme </li>
            <li>When all is done, press next button to allocate courses</li>

        </ul>
    </div>
    <div class="md:w-1/2 rounded md:mt-0 mt-12">

        <form action="{{route('course-allocation-options.store')}}" method='post' class="flex flex-col">
            @csrf

            <div class="flex flex-col px-8">
                <div class="flex items-center p-3 rounded-t bg-green-100">
                    <div class="flex text-green-900 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5" />
                        </svg>

                    </div>
                    @foreach($shifts as $shift)
                    <input type="radio" name='shift_id' value="{{$shift->id}}" class="ml-5" onclick='clearSelection()' @if($shift->id==1) checked @endif ><span class="text-green-900 ml-4">{{$shift->name}}</span>
                    @endforeach
                </div>

                <label for="" class="mt-5">Program</label>
                <select id="program_id" name="program_id" class="input-indigo p-2" onchange="loadSections(event)">
                    <option value="">Select a program</option>
                    @foreach($programs as $program)
                    <option value="{{$program->id}}">{{$program->name}}</option>
                    @endforeach
                </select>
                <label for="" class="mt-5">Section <span class="text-xs text-slate-600">(Section list will appear according to selected program)</span></label>
                <select id='section_id' name="section_id" class="input-indigo p-2"></select>

                <label for="" class="mt-5">Scheme <span class="text-xs text-slate-600">(Schemes list will appear according to selected program)</span></label>
                <select id='scheme_id' name="scheme_id" class="input-indigo p-2"></select>

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
        }

        function loadSections() {
            //token for ajax call
            var token = $("meta[name='csrf-token']").attr("content");

            var program_id = $('#program_id').val();
            var shift_id = $("input[name='shift_id']:checked").val();

            $.ajax({
                type: 'POST',
                url: "fetchSectionsByProgramId",
                data: {
                    "program_id": program_id,
                    "shift_id": shift_id,
                    "_token": token,

                },
                success: function(response) {
                    //
                    $('#section_id').html(response.section_options);
                    $('#scheme_id').html(response.scheme_options);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown)
                    // Toast.fire({
                    //     icon: 'warning',
                    //     title: errorThrown
                    // });
                }
            }); //ajax end
        }
    </script>
    @endsection