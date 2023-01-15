@extends('layouts.hod')
@section('page-content')
<h1 class="mt-12"><a href="{{url('clases')}}"> Classes</a></h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        {{$section->title()}} / import
    </div>
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

    @if(session('success'))
    <div class="flex alert-success items-center mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>
        {{session('success')}}
    </div>
    @endif
    <form action="{{route('students.import')}}" method="POST" enctype="multipart/form-data" class="flex flex-col w-full">
        @csrf

        <div class="flex flex-col border rounded-sm bg-gray-100 p-3 mt-12">
            <label for="" class="">Please select an excel file</label>
            <input type="file" name='file' class="mt-3">

        </div>

        <div class="flex items-center justify-end mt-4 py-2">
            <button type="submit" class="btn-indigo-rounded">Import</button>
        </div>
    </form>

</div>

@endsection