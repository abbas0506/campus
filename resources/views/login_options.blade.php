@extends('layouts.basic')

@section('content')
<section class="text-gray-600 body-font">
    <div class="container px-24 mt-16 mx-auto flex flex-wrap">

        @if ($errors->any())
        <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        <div class="flex flex-col md:flex-row items-center py-8 bg-slate-100 w-full">
            <div class="px-12 text-teal-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-20 h-20">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
            </div>
            <div>
                <h1>Welcome, {{Auth::user()->name}}!</h1>
                <ul class="list-disc text-slate-700 leading-relaxed">
                    <li>You have successfully logged into the system</li>
                    <li>Now let the system know, <u><strong><span class="text-teal-700 ">how would you like to proceed as?</span></strong></u></li>
                    <li>Please choose your role for your current activity. System will see your role privileges before displaying data. </li>
                </ul>
            </div>
        </div>


        <form action="{{route('login-options.store')}}" method='post' class="flex flex-col border border-rounded justify-center items-center w-full py-8">
            @csrf

            <div class="w-3/4">
                <label for="" class="text-base text-gray-700 text-left w-full">Role</label>
                <select id="" name="role_name" class="input-indigo p-4 w-full mb-5">
                    @foreach(Auth::user()->roles as $role)
                    <option value="{{$role->name}}">{{Str::upper($role->name)}}</option>
                    @endforeach
                </select>

                <label for="" class="text-base text-gray-700 text-left w-full">Semester</label>
                <select id="" name="semester_id" class="input-indigo p-4 w-full">
                    @foreach($semesters as $semester)
                    <option value="{{$semester->id}}">{{$semester->title()}}</option>
                    @endforeach
                </select>


                <div class="flex md:space-x-4 mt-8 justify-end items-center">
                    <a href="{{url('signout')}}" class="flex justify-center btn-indigo py-2 px-4">Cancel</a>
                    <button type="submit" class="flex justify-center btn-indigo py-2 px-4">Next</button>
                </div>

            </div>




        </form>

    </div>

</section>

@endsection