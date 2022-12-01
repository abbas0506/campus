@extends('layouts.admin')
@section('page-content')
<h1 class="mt-12">Controllership</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        <a href="{{route('controllership.index')}}">Controllership</a> / {{$controller->name}} / edit
    </div>
</div>

<div class="container w-full mx-auto mt-8">

    @if ($errors->any())
    <div class="alert-danger mt-8">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <table class="table-auto w-full mt-8">
        <thead>
            <tr class="border-b border-slate-200">
                <th>Teacher</th>
                <th>Department <span class="text-sm text-orange-700 font-thin">( basic )</span> </th>
                <th class="py-2 text-gray-600 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            @if($controller->id!=$user->id)
            <tr class="border-b tr">
                <td class="py-2">
                    <div>{{$user->name}}</div>
                    <div class="text-sm text-gray-500 font-medium">{{$user->cnic}}</div>
                    <div class="text-sm text-gray-500 font-medium">{{$user->email}}</div>
                </td>
                <td class="py-2 text-sm text-gray-500 font-medium">
                    <div>{{$user->department->name}}</div>
                </td>
                <td class="py-2 flex items-center justify-center">
                    <form action="{{route('controllership.update', $user)}}" method="POST" id='assign_form{{$user->id}}' class="mt-2 text-sm">
                        @csrf
                        @method('PATCH')
                        <input type="text" name='existing_controller_id' value='{{$controller->id}}' hidden>
                        <button type="submit" class="flex bg-green-200 text-green-800 px-3 py-2 rounded" onclick="assign('{{$user->id}}')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 icon-gray">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                            </svg>
                            assign
                        </button>
                    </form>
                </td>
            </tr>
            @endif
            @endforeach

        </tbody>
    </table>

</div>

@endsection