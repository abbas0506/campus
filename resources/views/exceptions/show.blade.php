@extends('layouts.basic')
@section('body')
<div class="flex justify-center items-center w-screen h-screen">
    <div class="flex tracking-wider text-slate-400 text-xl space-x-8">
        <div>400</div>
        <div>|</div>
        <div>{{$msg}}</div>
    </div>
</div>
@endsection