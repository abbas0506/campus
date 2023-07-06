@extends('layouts.admin')
@section('page-content')
<h1><a href="{{route('user-access.index')}}">Users Access</a></h1>
<div class="bread-crumb">{{$user->name}} / edit</div>
<div class="flex items-center justify-center w-full h-full">

    @if ($errors->any())
    <div class="alert-danger mt-8">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex flex-col w-full md:w-3/4">
        <h2 class="text-lg">{{$user->name}}</h2>
        <p>{{$user->department->name}}</p>
        <hr class="my-3">
        <p><i class="bi bi-envelope-at mr-2"></i>{{$user->email}}</p>
        <p><i class="bi bi-phone mr-2"></i>{{$user->phone}}</p>
        <p><i class="bi bi-person-vcard mr-2"></i>{{$user->cnic}}</p>
        <hr class="my-3">

        <div class="flex justify-between items-center">
            <div class="flex items-center w-full">
                <label class="mr-2">Current Status:</label>
                <div class="flex flex-1 justify-between items-center">

                    @if($user->status==1)
                    <i class="bi bi-toggle2-on text-teal-600 text-lg"></i>
                    <form action="{{route('user-access.update', $user)}}" method='post'>
                        @csrf
                        @method('PATCH')
                        <button type="submmit" class="btn-red">Block User</button>
                    </form>
                    @else
                    <i class="bi bi-toggle2-off text-red-600 text-lg"></i>
                    <form action="{{route('user-access.update', $user)}}" method='post'>
                        @csrf
                        @method('PATCH')
                        <button type="submmit" class="btn-teal">Activate User</button>
                    </form>
                    @endif
                </div>

            </div>
        </div>


    </div>

</div>

@endsection