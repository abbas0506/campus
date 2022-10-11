@extends('layouts.hod')
@section('page-content')
<div class="container px-8">
    <div class="flex mb-5 flex-col md:flex-row md:items-center">
        <div class="flex items-center mt-12 mb-5 md:my-10">
            <h1 class="text-indigo-500 text-xl">Fresh Enrollment</h1>
        </div>
    </div>

    <form action="{{route('enrollments.store')}}" method='post' class="flex flex-col w-full md:w-3/4">
        @csrf
        <section class="text-gray-600 body-font">
            <div class="container px-5 mx-auto">
                <div class="flex flex-wrap w-full mb-20 flex-col items-center text-center">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900">{{session('semester')->semester_type->name}} {{session('semester')->year}} / {{session('program')->short}}</h1>
                    <p class="lg:w-1/2 w-full leading-relaxed text-gray-500">Click on start to make fresh registrations</p>
                </div>
                <div class="flex flex-wrap -m-4">
                    <div class="md:w-1/2 p-4">
                        <div class="border border-gray-200 p-6 rounded-lg">
                            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Shift</h2>
                            <div class="flex item-cetner mt-3">
                                <input type="radio" name='shift_id' value="M" checked>
                                <label for="" class="ml-3">Mornig</label>
                            </div>
                            <div class="flex item-cetner mt-2">
                                <input type="radio" name='shift_id' value="E">
                                <label for="" class="ml-3">Evening</label>
                            </div>

                        </div>
                    </div>
                    <div class="md:w-1/2 p-4">
                        <div class="border border-gray-200 p-6 rounded-lg">
                            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                                </svg>
                            </div>
                            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Section</h2>
                            <div class="flex flex-col flex-1 md:mr-4 mt-3">
                                <label for="" class="text-sm text-gray-400">Choose</label>
                                <select name="section_id" id="" class="p-1 input-indigo">
                                    @foreach($sections as $section)
                                    <option value="{{$section->id}}">{{$section->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center">
                    <button type="submit" class="btn-indigo mt-4">Start Feeding</button>
                </div>

            </div>
        </section>
    </form>

</div>

<script type="text/javascript">
    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        var str = 0;
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) || $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }
</script>

@endsection