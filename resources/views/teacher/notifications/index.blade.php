@extends('layouts.teacher')
@section('page-content')

<div class="container">
    <h2>Notifications</h2>
    <div class="bread-crumb">
        <a href="{{url('teacher')}}">Home</a>
        <div>/</div>
        <div>Notifications</div>
    </div>

    <!-- search -->
    <div class="flex relative w-full md:w-1/3 mt-8">
        <input type="text" id='searchby' placeholder="Search ..." class="search-indigo w-full" oninput="search(event)">
        <i class="bx bx-search absolute top-2 right-2"></i>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="flex flex-wrap items-center justify-between mt-4">
        <div class="text-sm  text-gray-500 mt-8 mb-1">{{$notifications->count()}} records found</div>
    </div>
    <div class="overflow-x-auto mt-4">
        <table class="table-fixed w-full">
            <thead>
                <tr>
                    <th class="w-32">From</th>
                    <th class="w-60">Message</th>
                    <th class="w-24">@</th>
                    <th class="w-24">Action</th>
                </tr>
            </thead>
            <tbody>

                @php
                $sr=1;
                @endphp

                @foreach($notifications->sortByDesc('created_at') as $notification)
                <tr class="tr">
                    <td class="text-left">{{$notification->sender->name}}
                        <br>
                        <span class="text-slate-800">{{$notification->sender->email}}</span>
                    </td>
                    <td class="text-left">{{$notification->message}}</td>
                    <td>{{$notification->created_at}}</td>
                    <td>
                        <form action="{{route('teacher.notifications.update', $notification)}}" method="post">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-teal text-xs">Ok</button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function delme(formid) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
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

    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        var str = 0;
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) || $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }
</script>

@endsection