@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>New Program</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('hod.programs.index')}}">Programs</a>
        <div>/</div>
        <div>New</div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="w-full md:w-3/4 mx-auto mt-8">
        <form action="{{route('hod.programs.store')}}" method='post' class="flex flex-col w-full">
            @csrf
            <div class="grid grid-cols-1  md:grid-cols-2 gap-3">
                <div class="col-span-2">
                    <label for="" class="bg-orange-200 p-1">Level</label>
                    <select name="level" id="" class="border-b mt-1 outline-none text-teal-800 font-bold">
                        <option value="16">16 years</option>
                        <option value="18">18 years</option>
                        <option value="21">21 years</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label for="">Full Name <span class="text-red-600"> *(as per scheme of study)</span></label>
                    <input type="text" id='' name='name' class="custom-input" placeholder="Bachelor of Science in Computer Science" required>
                </div>
                <div>
                    <label for="">Short Name <span class="text-sm">(if any)</span></label>
                    <input type="text" id='' name='short' class="custom-input" placeholder="For example: BSCS">
                </div>
                <div>
                    <label for="">Cr. Hrs <span class="text-xs font-thin">(degree requirement)</span></label>
                    <input type="number" id='' name='cr' class="custom-input" placeholder="Credit hrs" required>
                </div>
                <div>
                    <label for="">Min Duration <span class="text-sm">(Years)</span></label>
                    <select id="" name="min_t" class="custom-input" required>
                        @foreach($durations as $duration)
                        <option value="{{$duration}}">{{$duration}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="">Max Duration <span class="text-sm">(Years)</span></label>
                    <select id="" name="max_t" class="custom-input" required>
                        @foreach($durations as $duration)
                        <option value="{{$duration}}">{{$duration}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Intake Semester</label>
                    <select id='intake' name="intake" class="custom-input">
                        <option value="1">1st Semester</option>
                        <option value="5">5th Semester</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-teal rounded w-32 p-2 mt-4">Create Now</button>

        </form>
    </div>

</div>

@endsection