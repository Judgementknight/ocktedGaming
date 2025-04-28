@extends('Dashboard.Pages2.layout')
@section('title')  <!-- Overriding the title with dynamic game title -->
@section('content')

{{-- <div class="fixed -z-10 w-full h-screen">
    <div class="w-full h-full bg-gradient-to-r from-[#ffffff] to-[#606c90cd] ">

    </div>
</div> --}}
<x-sidebar/>
<section class="py-10 px-10 w-full">
    <header>
        <h1 class="font1 text-6xl font-semibold text-zinc-800">OCKTED GAMING</h1>
    </header>

    <div class="hidden sm:flex w-full h-[100px]">

    </div>

    {{-- <div class="mt-5 sm:mt-0 w-full h-[200px] grid lg:grid-cols-3 items-center gap-5">

        <div class="w-full h-[150px]  rounded-2xl p-4 shadow-md border bg-background flex items-center gap-4 transition hover:shadow-lg">
            <div class="w-[40%] h-full  flex items-center justify-center">
                <div class="w-[80px] bgteal flex items-center justify-center rounded-lg h-[80px]">
                    <img class="w-[70%] h-[70%] object-cover" src="{{asset('dash/students.png')}}">
                </div>
            </div>
            <div class="w-[60%] h-full flex flex-col gap-5">
                <h1 class="font1 text-3xl text-zinc-8S00 font-bold">Total Students</h1>
                <h1 class="font1 text-5xl text-zinc-800 font-bold">23</h1>

            </div>
        </div>
        <div class="w-full h-[150px]  rounded-2xl p-4 shadow-md border bg-background flex items-center gap-4 transition hover:shadow-lg">
            <div class="w-[40%] h-full  flex items-center justify-center">
                <div class="w-[80px] bgteal flex items-center justify-center rounded-lg h-[80px]">
                    <img class="w-[70%] h-[70%] object-cover" src="{{asset('dash/bus.png')}}">
                </div>
            </div>
            <div class="w-[60%] h-full flex flex-col gap-5">
                <h1 class="font1 text-3xl text-zinc-8S00 font-bold">Total Bus</h1>
                <h1 class="font1 text-5xl text-zinc-800 font-bold">23</h1>

            </div>
        </div>
        <div class="w-full h-[150px]  rounded-2xl p-4 shadow-md border bg-background flex items-center gap-4 transition hover:shadow-lg">
            <div class="w-[40%] h-full  flex items-center justify-center">
                <div class="w-[80px] bgteal flex items-center justify-center rounded-lg h-[80px]">
                    <img class="w-[70%] h-[70%] object-cover" src="{{asset('dash/driver.png')}}">
                </div>
            </div>
            <div class="w-[60%] h-full flex flex-col gap-5">
                <h1 class="font1 text-3xl text-zinc-8S00 font-bold">Total Driver</h1>
                <h1 class="font1 text-5xl text-zinc-800 font-bold">23</h1>

            </div>
        </div>



    </div> --}}



</section>

@endsection
