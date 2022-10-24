@extends('layouts.basic')

@section('content')
<section class="text-gray-600 body-font">
    <div class="container p-24 mx-auto flex flex-wrap">

        @if ($errors->any())
        <div class="bg-red-100 text-red-700 text-sm py-3 px-5 mb-5 w-full">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="flex flex-wrap w-full">
            <div class="md:w-1/2 md:pr-10 md:py-6">
                <div class="flex relative pb-12">
                    <div class="h-full w-4 absolute inset-0 flex items-center justify-center">
                        <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
                    </div>
                    <div class="flex-shrink-0 w-4 h-4 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-10">
                    </div>
                    <div class="flex-grow pl-4">
                        <h2 class="font-bold title-font text-sm text-gray-900 mb-1 tracking-wider">SELECT YOUR ROLE</h2>
                        <p class="leading-relaxed">In case of multiple roles, you may select any role to sign in as.</p>
                    </div>
                </div>

                <div class="flex relative pb-12">
                    <div class="h-full w-4 absolute inset-0 flex items-center justify-center">
                        <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
                    </div>
                    <div class="flex-shrink-0 w-4 h-4 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-10">
                    </div>
                    <div class="flex-grow pl-4">
                        <h2 class="font-bold title-font text-sm text-gray-900 mb-1 tracking-wider">SELECT SEMESTER</h2>
                        <p class="leading-relaxed">Normally, current semester's data will be available. However, if your desired semester is not listed, contact admin!</p>
                    </div>
                </div>
                <div class="flex relative pb-12">
                    <div class="flex-shrink-0 w-4 h-4 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-10">
                    </div>
                    <div class="flex-grow pl-4">
                        <h2 class="font-bold title-font text-sm text-gray-900 mb-1 tracking-wider">NEXT</h2>
                        <p class="leading-relaxed">Click on next to manipulate the selected semester's data</p>
                    </div>
                </div>

            </div>
            <div class="md:w-1/2 object-cover object-center rounded-lg md:mt-0 mt-12">

                <form action="{{route('login-options.store')}}" method='post' class="flex flex-col border border-rounded">
                    @csrf

                    <div class="flex flex-col">
                        <div class="flex items-center p-3 bg-green-200">
                            <div class="p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                            </div>
                            <div class="flex flex-col text-green-900 p-2">
                                <h2 class="font-bold">{{Auth::user()->name}} </h2>
                                How would you like to sign in?
                            </div>

                        </div>

                        <div class="flex flex-col p-8">
                            <label for="" class="text-base text-gray-700 text-left mt-3">Role</label>
                            <select id="" name="role_name" class="input-indigo p-2">
                                @foreach(Auth::user()->roles as $role)
                                <option value="{{$role->name}}">{{Str::upper($role->name)}}</option>
                                @endforeach
                            </select>

                            <label for="" class="text-base text-gray-700 text-left mt-3">Semester</label>
                            <select id="" name="semester_id" class="input-indigo p-2">
                                @foreach($semesters as $semester)
                                <option value="{{$semester->id}}">{{$semester->title()}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="border-b"></div>
                        <div class="px-8 py-4">
                            <div class="flex md:space-x-4 justify-end items-center">
                                <a href="{{url('signout')}}" class="flex justify-center btn-indigo">Cancel</a>
                                <button type="submit" class="flex justify-center btn-indigo">Next</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection