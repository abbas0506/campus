@extends('layouts.admin')
@section('page-content')
<h1 class="mt-12"><a href="{{route('semesters.index')}}">Semester Control</a></h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">Semesters / new</div>
</div>

<div class="container md:w-3/4 mx-auto px-5">

    @if ($errors->any())
    <div class="alert-danger mt-8">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{route('semesters.store')}}" method='post' class="flex flex-col w-full mt-12">
        @csrf

        <div class="flex flex-col md:flex-row flex-wrap md:justify-between md:items-center">
            <div class="flex flex-col md:w-48 mt-3">
                <label for="">Semester Type</label>
                <select name="semester_type_id" id="" class="input-indigo p-2">
                    @foreach($semester_types as $semester_type)
                    <option value="{{$semester_type->id}}">{{$semester_type->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col mx-0 md:ml-4 mt-3">
                <label for="">Year </label>
                <input type="number" id='' name='year' class="input-indigo" placeholder="Year" value="{{now()->year}}" min=2014>
            </div>
            <div class="flex flex-col flex-1 mt-3 md:ml-4">
                <label for="">Allow Edit Till (mm/dd/yyyy) </label>
                <input type="date" id='' name='edit_till' class="input-indigo" placeholder="Allow edit till date">
            </div>
        </div>
        <div class="flex items-center justify-end mt-4 py-2">
            <button type="submit" class="btn-indigo-rounded">Save</button>
        </div>
    </form>

</div>

@endsection