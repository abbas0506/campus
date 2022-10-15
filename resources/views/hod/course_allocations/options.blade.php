@extends('layouts.hod')

@section('page-content')
<section class="text-gray-600 body-font">
    <div class="container p-16 mx-auto flex flex-wrap">

        @if ($errors->any())
        <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="flex flex-wrap w-full">
            <div class="md:w-1/2 md:pr-10 md:py-6">
                <div class="flex relative pb-12">
                    <div class="h-full w-10 absolute inset-0 flex items-center justify-center">
                        <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
                    </div>
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                    </div>
                    <div class="flex-grow pl-4">
                        <h2 class="font-medium title-font text-sm text-gray-900 mb-1 tracking-wider">STEP 1</h2>
                        <p class="leading-relaxed">Select shift and program. If programs' list empty, go back and add new programs</p>
                    </div>
                </div>

                <div class="flex relative pb-12">
                    <div class="h-full w-10 absolute inset-0 flex items-center justify-center">
                        <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
                    </div>
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                        </svg>

                    </div>
                    <div class="flex-grow pl-4">
                        <h2 class="font-medium title-font text-sm text-gray-900 mb-1 tracking-wider">STEP 2</h2>
                        <p class="leading-relaxed">Select a section. Initially, sections' list will be empty. Section list will be available only if you have already defined some section for the selected program and shift(i.e class)</p>
                    </div>
                </div>
                <div class="flex relative pb-12">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 1.953l-7.108 4.062A1.125 1.125 0 013 16.81V8.688zM12.75 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 1.953l-7.108 4.062a1.125 1.125 0 01-1.683-.977V8.688z" />
                        </svg>
                    </div>
                    <div class="flex-grow pl-4">
                        <h2 class="font-medium title-font text-sm text-gray-900 mb-1 tracking-wider">NEXT</h2>
                        <p class="leading-relaxed">Go to course allocation page</p>
                    </div>
                </div>

            </div>
            <div class="md:w-1/2 object-cover object-center rounded-lg md:mt-0 mt-12">

                <form action="{{route('course-allocation-options.store')}}" method='post' class="flex flex-col border border-rounded">
                    @csrf

                    <div class="flex flex-col mt-4 p-8">
                        <div class="flex items-center p-3 rounded bg-green-200">
                            <div class="flex text-green-900 ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5" />
                                </svg>

                            </div>
                            @foreach($shifts as $shift)
                            <input type="radio" name='shift_id' value="{{$shift->id}}" class="ml-5" onclick='loadSections()' @if($shift->id==1) checked @endif ><span class="text-green-900 ml-4">{{$shift->name}}</span>
                            @endforeach
                        </div>

                        <label for="" class="text-lg text-slate-800 text-left mt-5">Program</label>
                        <select id="program_id" name="program_id" class="input-indigo p-2" onchange="loadSections(event)">
                            <option value="">Select a program</option>
                            @foreach($programs as $program)
                            <option value="{{$program->id}}">{{$program->name}}</option>
                            @endforeach
                        </select>
                        <label for="" class="text-lg text-slate-800 text-left mt-5">Section <span class="text-xs text-slate-600">(Section list will appear according to selected program)</span></label>
                        <select id='section_id' name="section_id" class="input-indigo p-2"></select>

                        <div class="flex md:space-x-4 justify-end">
                            <a href="{{url('hod')}}" class="flex justify-center btn-indigo mt-8">Cancel</a>
                            <button type="submit" class="flex justify-center btn-indigo mt-8">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<script lang="javascript">
    function loadSections() {
        var token = $("meta[name='csrf-token']").attr("content");
        // var program_id = event.target.value;
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
                // alert(response.section_options)
                $('#section_id').html(response.section_options);
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