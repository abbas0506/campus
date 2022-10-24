@extends('layouts.admin')
@section('page-content')
<div class="container px-8">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-12">
            <a href="{{route('semesters.index')}}">Semester</a>
            <span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>Edit</span>
        </h1>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full md:w-3/4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <form action="{{route('semesters.update',$semester)}}" method='post' class="flex flex-col w-full md:w-3/4">
        @csrf
        @method('PATCH')

        <h1 class="text-slate-600 text-xl">{{$semester->title()}}</h1>
        <h4 class=" flex flex-row text-sm text-green-800 bg-green-100 p-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
            </svg>

            Please clear the date, if you want to stop edit permission
        </h4>

        <div class="flex flex-col flex-1 mt-4">
            <label for="">Allow Edit Till (mm/dd/yyyy) </label>
            <input type="date" id='' name='edit_till' class="input-indigo" placeholder="Allow edit till date" value="{{$semester->edit_till}}">
        </div>
        <button type="submit" class="btn-indigo mt-3">Update</button>
    </form>

</div>

@endsection