@extends('layouts.hod')
@section('page-content')
<div class="container">
    <h2>Edit Program</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('programs.index')}}">Programs</a>
        <div>/</div>
        <div>Edit</div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="w-full md:w-3/4 mx-auto mt-8">
        <form action="{{route('programs.update',$program)}}" method='post' class="flex flex-col w-full mt-12">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-1  md:grid-cols-2 gap-3">
                <div class="col-span-2">
                    <label for="" class="bg-orange-200 p-1">Level</label>
                    <select name="level" id="" class="border-b mt-1 outline-none text-teal-800 font-bold">
                        <option value="16" @selected($program->level==16)>16 years</option>
                        <option value="18" @selected($program->level==18)>18 years</option>
                        <option value="21" @selected($program->level==21)>21 years</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label for="">Full Name <span class="text-red-600"> *(as per scheme of study)</span></label>
                    <input type="text" id='' name='name' class="custom-input" placeholder="Bachelor of Science in Computer Science" value="{{$program->name}}" required>
                </div>
                <div>
                    <label for="">Short Name <span class="text-sm">(if any)</span></label>
                    <input type="text" id='' name='short' class="custom-input" placeholder="For example: BSCS" value="{{$program->short}}">
                </div>
                <div>
                    <label for="">Cr. Hrs <span class="text-xs font-thin">(degree requirement)</span></label>
                    <input type="number" id='' name='cr' class="custom-input" placeholder="Credit hrs" value="{{$program->cr}}" required>
                </div>
                <div>
                    <label for="">Min Duration <span class="text-sm">(Years)</span></label>
                    <select id="" name="min_t" class="custom-input" required>
                        @foreach($durations as $duration)
                        <option value="{{$duration}}" @selected($program->min_t==$duration)>{{$duration}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="">Max Duration <span class="text-sm">(Years)</span></label>
                    <select id="" name="max_t" class="custom-input" required>
                        @foreach($durations as $duration)
                        <option value="{{$duration}}" @selected($program->max_t==$duration)>{{$duration}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-teal rounded w-32 p-2 mt-4">Update Now</button>

        </form>
    </div>

</div>

@endsection