@extends('layouts.basic')

@section('content')

<div class="flex flex-col-reverse md:flex-row items-center w-screen md:h-screen">
    <div class="flex flex-col md:w-1/3 m-auto text-center">
        <h1 class="text-2xl md:text-4xl font-medium text-indigo-900 mb-1">Login As</h1>
        <p class="mb-6 leading-relaxed text-slate-500 mt-3">Please select one of the following available roles</p>

        @if ($errors->any())
        <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{route('login-options.store')}}" method='post' class="flex flex-col w-full">
            @csrf
            <div class="flex md:space-x-8 mt-4">
                <div class="flex flex-col flex-1 bg-slate-100 p-5">
                    <label for="" class="text-lg text-gray-600 text-left">Role Options</label>
                    <select id="" name="role_name" class="input-indigo p-2 mt-3">
                        @foreach(Auth::user()->roles as $role)
                        <option value="{{$role->name}}">{{Str::upper($role->name)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex w-full md:space-x-4">
                <a href="{{url('signout')}}" class="flex flex-1 justify-center btn-indigo mt-8">Quit</a>
                <button type="submit" class="flex flex-1 justify-center btn-indigo mt-8">Next</button>
            </div>

        </form>

    </div>
</div>
@endsection