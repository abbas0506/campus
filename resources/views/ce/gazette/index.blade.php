@extends('layouts.controller')
@section('page-content')
<h1>Gazette | Step 1</h1>

<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">Choose Department</div>

</div>
<div class="flex items-center space-x-2 mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
    </svg>
    <ul class="text-xs">
        <li>Select a semester</li>
        <li>Select a department</li>
        <li></li>
    </ul>
</div>

<div class="flex flex-row space-x-8">
    <div class="flex flex-column">
        <form method='post' action="{{url('ce-gazette')}}" class="mt-3">
            @csrf
            @method('POST')

            <label for="" class="text-base text-gray-700 text-left w-full">Semester</label>
            <select id="semester_id" name="semester_id" class="input-indigo px-4 py-3 w-full mb-3">
                @foreach($semesters->sortDesc() as $semester)
                <option value="{{$semester->id}}">{{$semester->short()}}</option>
                @endforeach
            </select>

            <label for="" class="text-base text-gray-700 text-left w-full">Select a department</label>
            <select id="department_id" name="department_id" class="input-indigo px-4 py-3 w-full" required>
                <option value="">Select a department</option>
                @foreach($departments as $department)
                <option value="{{$department->id}}">{{$department->name}}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-teal rounded mt-4 py-2 px-4">Submit</button>
        </form>
    </div>
</div>
@endsection