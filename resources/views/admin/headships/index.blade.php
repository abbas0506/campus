@extends('layouts.admin')
@section('page-content')
<h1>Headships</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Headships / all
    </div>
</div>

<div class="container w-full mx-auto mt-8">
    <div class="flex relative w-60">
        <input type="text" placeholder="Search ..." class="search-indigo w-60" oninput="search(event)">
        <i class="bi bi-search absolute right-1 top-3"></i>
    </div>
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
    <div class="flex alert-success items-center mt-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>

        {{session('success')}}
    </div>
    @endif
    <div class="text-sm mt-8">{{$departments->count()}} records found</div>
    <table class="table-auto w-full mt-2">
        <thead>
            <tr class="border-b border-slate-200">
                <th>Department</th>
                <th>HoD</th>
                <th class='text-center'>Actions</th>
            </tr>
        </thead>
        <tbody>

            @foreach($departments->sortBy('name') as $department)
            <tr class="tr border-b ">
                <td>{{Str::replace('Department of ','',$department->name)}}</td>
                <td>
                    @if($department->headship)
                    <div>{{$department->headship->user->name}}</div>
                    <div class="text-sm text-slate-400">{{$department->headship->user->email}}</div>
                    <div class="text-sm text-slate-400">{{$department->headship->department->name}}</div>
                    @endif
                </td>


                <td class="text-sm">
                    @if($department->headship)
                    <a href="{{route('headships.edit',$department)}}" class="flex justify-center btn-orange w-16 mx-auto">
                        Replace
                    </a>
                    @else
                    <a href="{{route('headships.edit', $department->id)}}" class="flex justify-center btn-teal w-16 mx-auto">
                        Assign
                    </a>
                    @endif
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>

<script type="text/javascript">
    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        var str = 0;
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }
</script>

@endsection