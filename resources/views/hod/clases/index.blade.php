@extends('layouts.hod')
@section('page-content')
<h1>Classes / Sections</h1>
<div class="bread-crumb">Classes & Sections / all</div>

<div class="flex items-center space-x-2 mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
    </svg>
    <ul class="text-xs">
        <li>Class will be deleted only if it has no student (i.e. empty class)</li>
        <li>Section delete option is not available on this page. It is available on section page itself. (click on section label)</li>
    </ul>
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
@if(session('error'))
<div class="flex items-center alert-danger mt-8">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
    </svg>
    {{session('error')}}
</div>
@endif

<!-- search bar -->
<!-- <div class="flex items-center justify-end mt-8">
    <div class="flex items-center space-x-3">
        <a href="{{route('promotions.index')}}" class="flex items-center text-sm btn-teal px-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />
            </svg>
            <span class="ml-1">Promote</span>
        </a>
        <a href="{{route('reversions.index')}}" class="flex items-center text-sm btn-red px-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
            </svg>
            <span class="ml-1">Revert</span>
        </a>
    </div>

</div> -->
<!-- records found -->
<div class="text-xs font-thin text-slate-600 mt-8 mb-1">{{$programs->count()}} programs found</div>

<!-- classes & section detail -->
<section>
    <div class="flex flex-col accordion">
        @foreach($programs->sortBy('level') as $program)
        <div class="collapsible">
            <div class="head">
                <h2 class="flex items-center space-x-4">
                    {{$program->short}}
                    <span class="text-xs ml-4 font-thin">Classes:{{$program->clases()->count()}}</span>
                    <span class="text-xs ml-4 font-thin">Sections:{{$program->sections()->count()}}</span>
                    <div class="flex items-center space-x-1">
                        <span class="bx bx-user text-[12px] text-slate-500"></span>
                        <span class="text-xs font-thin">{{$program->students()->count()}}</span>
                    </div>

                </h2>
                <i class="bx bx-chevron-down text-lg"></i>
            </div>
            <div class="body">
                @foreach($program->clases as $clas)
                <div class="flex items-center w-full border-b py-1 space-x-4">
                    <div class="flex items-center justify-between w-1/2 md:w-1/4">
                        <div class="text-sm">{{$clas->short()}}</div>
                        <div class="text-xs text-slate-400"><i class="bx bx-user"></i> ({{$clas->strength()}})</div>
                    </div>
                    <div class="flex items-center justify-center space-x-2">
                        <a href="{{route('clases.edit', $clas)}}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 text-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </a>
                        <form action="{{route('clases.destroy',$clas)}}" method="POST" id='del_form{{$clas->id}}'>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:zoom-sm hover:text-red-800" onclick="delme('{{$clas->id}}')" @disabled($clas->strength()>0)>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-10 gap-2">
                        @foreach($clas->sections as $section)
                        <a href="{{route('sections.show',$section)}}" class='flex justify-center items-center bg-teal-100 hover:bg-teal-600 hover:text-slate-100 w-16'>
                            {{$section->name}} <span class="ml-1 text-xs">({{$section->students->count()}})</span>
                        </a>
                        @endforeach
                        <form action="{{route('sections.store')}}" method="post" class='flex justify-center items-center border border-dashed border-slate-200 bg-teal-50 text-teal-800 hover:bg-teal-100 w-16'>
                            @csrf
                            <input type="text" name="clas_id" value="{{$clas->id}}" hidden>
                            <button type='submit'>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
                <div class="w-full mt-2">
                    @if($program->schemes->count()>0)
                    <a href="{{route('clases.append',$program)}}" class="flex items-center btn-teal px-2 text-xs float-left">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                        Add New Class
                    </a>
                    @else
                    <a href="{{route('schemes.append',$program)}}" class="flex items-center btn-teal text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                        Define Scheme
                    </a>
                    @endif

                </div>

            </div>
        </div>

        @endforeach

    </div>

</section>

@endsection
@section('script')
<script type="text/javascript">
    function delme(formid) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "It will be highly destructive!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                //submit corresponding form
                $('#del_form' + formid).submit();
            }
        });
    }
</script>

@endsection