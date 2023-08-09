@extends('layouts.hod')
@section('page-content')

<h1><a href="{{route('programs.index')}}">Programs</a></h1>
<div class="bread-crumb">New program </div>

<div class="container md:w-3/4 mx-auto px-5">

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <form action="{{route('programs.store')}}" method='post' class="flex flex-col w-full mt-12">
        @csrf

        <div class="flex flex-col w-1/2">
            <label for="">Level</label>
            <select name="level" id="" class="border-b mt-1 outline-none text-teal-800 font-bold">
                <option value="16">16 years</option>
                <option value="18">18 years</option>
                <option value="21">21 years</option>
            </select>
        </div>
        <div class="flex flex-col mt-4">
            <label for="">Full Name <span class="text-red-600"> *(as per scheme of study)</span></label>
            <input type="text" id='' name='name' class="custom-input" placeholder="Bachelor of Science in Computer Science" required>
        </div>
        <div class="flex flex-col md:flex-row items-center md:space-x-4">
            <div class="flex flex-col grow">
                <label for="" class='mt-3'>Short Name <span class="text-sm">(if any)</span></label>
                <input type="text" id='' name='short' class="custom-input" placeholder="For example: BSCS">
            </div>
            <div class="flex flex-col">
                <label for="" class='mt-3'>Cr. Hrs <span class="text-xs font-thin">(degree requirement)</span></label>
                <input type="number" id='' name='cr' class="custom-input" placeholder="Credit hrs" required>
            </div>
        </div>

        <div class="flex space-x-4">
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Min Duration <span class="text-sm">(Years)</span></label>
                <select id="" name="min_t" class="custom-input p-2" required>
                    @foreach($durations as $duration)
                    <option value="{{$duration}}">{{$duration}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col flex-1">
                <label for="" class='mt-3'>Max Duration <span class="text-sm">(Years)</span></label>
                <select id="" name="max_t" class="custom-input p-2" required>
                    @foreach($durations as $duration)
                    <option value="{{$duration}}">{{$duration}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4 py-2">
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>

    </form>

</div>

@endsection