@extends('layouts.controller')
@section('page-content')
<div class="container px-8">
    <div class="flex items-center">
        <h1 class="text-indigo-500 text-xl py-12">HODs <span class="text-gray-300 mx-3">|</span><span class='text-gray-600 text-sm'>New</span> </h1>
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
    <form action="{{route('hods.store')}}" method='post' class="flex flex-col w-full md:w-3/4">
        @csrf
        <label for="" class="text-sm text-gray-400">Fetch data from department</label>
        <select name="department_id" id="" class="input-indigo p-2">
            <option value="">Click here</option>
            @foreach($departments as $department)
            <option value="{{$department->id}}">{{$department->name}}</option>
            @endforeach
        </select>

        <div class="relative mt-4">
            <input type="text" placeholder="Type here to search by name or cnic" class="search-indigo w-full" oninput="search(event)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute right-1 top-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>

        <table class="table-auto w-full mt-4">
            <thead>
                <tr class="border-b border-slate-200">
                    <th class="py-2 text-gray-600 text-left">Name</th>
                    <th class="py-2 text-gray-600 text-left">Email</th>
                    <th class="py-2 text-gray-600 justify-center">Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach($hods->sortByDesc('id') as $hod)
                <tr>
                    <td class="py-2">{{$hod->name}}</td>
                    <td class="py-2">{{$hod->email}}</td>
                    <td class="py-2 flex items-center justify-center">
                        <a href="{{route('hods.edit', $hod)}}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600 mr-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </a>
                        <form action="{{route('hods.destroy',$hod)}}" method="POST" id='del_form{{$hod->id}}' class="mt-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-transparent p-0 border-0" onclick="delme('{{$hod->id}}')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-red-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

        <label for="" class="text-sm text-gray-400 mt-3">Choose from existing</label>
        <select name="user_id" id="" class="input-indigo p-2">
            <option value="">Select a person</option>
            @foreach($users as $user)
            <option value="{{$user->id}}">{{$user->name}}</option>
            @endforeach
        </select>
        <div class="flex items-center text-gray-600 border-b border-t border-dashed border-indigo-800 bg-indigo-100 mt-12 mb-5 p-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-6 6m0 0l-6-6m6 6V9a6 6 0 0112 0v3" />
            </svg>
            Add New <span class="text-sm ml-4">(only if the person does not exist in above list)</span>
        </div>

        <label for="" class="text-sm text-gray-400">Name</label>
        <input type="text" id='name' name='name' class="input-indigo" placeholder="Enter name">

        <label for="" class="text-sm text-gray-400 mt-3">Email</label>
        <input type="text" id='email' name='email' class="input-indigo" placeholder="Enter email address">

        <button type="submit" class="btn-indigo mt-4">Save</button>
    </form>

</div>

@endsection