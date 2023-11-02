@extends('layouts.admin')
@section('page-content')
<div class="container">
    <h2>User Access Control</h2>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Home</a>
        <div>/</div>
        <a href="{{route('admin.user-access.index')}}">Users</a>
        <div>/</div>
        <div>Access Control</div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="flex flex-col mx-auto md:w-3/4 mt-16">
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

                    @if($user->is_active)
                    <i class="bi bi-toggle2-on text-teal-600 text-lg"></i>
                    <form action="{{route('admin.user-access.update', $user)}}" method='post'>
                        @csrf
                        @method('PATCH')
                        <button type="submmit" class="btn-red">Block User</button>
                    </form>
                    @else
                    <i class="bi bi-toggle2-off text-red-600 text-lg"></i>
                    <form action="{{route('admin.user-access.update', $user)}}" method='post'>
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