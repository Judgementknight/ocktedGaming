@extends('Student.student-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body class="pb-10">
    <x-student-navbar :picture="$combinedData['Student Data']['profile_picture']"/>
    <x-toast/>
    <x-student-profile "/>

    <x-student-profile :picture="$combinedData['Student Data']['profile_picture'] ?? ''" :name="$combinedData['Student Data']['student_name'] ?? ''" :rank="$combinedData['Student Data']['rank']" :totalscore="$combinedData['totalScore']"/>
    <div class="w-full h-full fixed top-0 left-0 -z-30">
        <img class="w-full h-full object-cover" src="{{asset('Teacher/bg3.jpg')}}">
    </div>
    <div class="w-full h-[50px] px-4  lg:px-10 flex items-end font1 py-3">
        <a href="{{route('welcome')}}">
            <div class="flex gap-3 hover:cursor-pointer hover:text-zinc-950 text-zinc-600">
                <img class="size-6" src="{{asset('Teacher/icons/back.png')}}">
                <p class="">Back to Dashboard</p>
            </div>
        </a>
    </div>

    <div class="px-4 lg:px-10 w-full h-[150px] gap-5 lg:gap-0 flex flex-col lg:flex-col items-center justify-center lg:justify-evenly font1">
        <div class="w-full">
            <div class="w-full md:w-[20%] h-[4px] rounded-md bg-[#2776F9]"></div>
        </div>
        <div class="justify-center text-center flex gap-5 lg:text-left flex-col w-full ">
            <div class="flex-col flex">
                <h1 class="font-bold text-3xl text-zinc-800">{{$combinedData['classroom'][0]['classroom_title']}}</h1>
                <p class="text-center lg:text-left text-md text-zinc-500 mt-2">{{$combinedData['classroom'][0]['classroom_description']}}</p>
            </div>
            <div class="flex justify-center lg:justify-start gap-2 items-center">
                    <img class="size-5" src="{{asset('Teacher/icons/group.png')}}">
                    <p class="text-zinc-600">Teacher: {{$combinedData['classroom'][0]['teacher']['teacher_name']}} </p>
            </div>
        </div>
    </div>

    <section class="mt-4">
        <div class="w-full h-[50px] px-4 lg:px-10 flex items-center gap-3 font1">
            <div class="w-[15px] h-[15px] bg-[#F59E0B] rounded-[50%]"></div>
            <p class="text-2xl font-semibold text-zinc-800">Pending Assignment</p>
        </div>

        <div class="w-full grid lg:grid-cols-3 gap-5 h-auto px-4 lg:px-10 mt-2">

            @if($pending->isNotEmpty())
                @foreach ($pending as $assignment)
                <div class="w-full h-[180px] bg-white gap-3 shadow-md relative rounded-md">
                    <div class="w-full h-[10px] bg-[#F59E0B]  rounded-t-md "></div>
                    <div class="w-full h-full flex flex-col justify-between px-2 pt-2 pb-5">
                        <div class="flex items-center justify-between">
                            <p class="text-md text-zinc-800 font-semibold text-xl">{{$assignment->assignment_title}}</p>
                            <p class="bg-[#FFCC68]/25 font-semibold px-2 py-1 text-sm rounded-xl text-[#F59E0B]">Due Soon</p>
                        </div>
                        {{-- <div class="flex items-center gap-1">
                            <img class="size-4" src="{{asset('Teacher/icons/assignment.png')}}">
                            <p class="text-md text-zinc-500">Assignment Code: {{$assignment->custom_game_assignment_code}}</p>
                        </div> --}}
                        <div class="flex items-center gap-1">
                            <img class="size-4" src="{{asset('Teacher/icons/assignment.png')}}">
                            <p class="text-md text-zinc-500">Assignment Type: {{$assignment->gameroom_type}}</p>
                        </div>
                        <div class="flex items-center gap-1">
                            <img class="size-4" src="{{asset('Teacher/icons/time.png')}}">
                            <p class="text-md text-zinc-500">Due Date: {{$assignment->due_date}}</p>
                        </div>
                        <div class="flex justify-end">
                            <a href="{{route('view-assignment', ['assignment_code' => $assignment->custom_game_assignment_code])}}">
                                <button class="px-3 py-2 bg-[#0d1b2a] font1 text-zinc-100 rounded-sm">Do Assignment</button>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
            <p class="font1 text-zinc-500 font-semibold">No Pending Assignments...</p>
            @endif
        </div>
        {{-- <a href="{{ route('view-pending') }}"> --}}
        <a href="{{ route('view-pending', ['classroom_code' => $combinedData['classroom'][0]['classroom_code']]) }}">
            <div class="w-full h-[50px] flex items-center justify-end px-4 lg:px-10 mt-2 font1 gap-1">
                <p class="hover:text-blue-500 hover:cursor-pointer">Show All</p>
                <img class="size-5 rotate-[180deg]" src="{{asset('Teacher/icons/back.png')}}">
            </div>
        </a>

    </section>



    <section class="mt-4">
        <div class="w-full h-[50px] px-4 lg:px-10 flex items-center gap-3 font1">
            <div class="w-[15px] h-[15px] bg-[#588157] rounded-[50%]"></div>
            <p class="text-2xl font-semibold text-zinc-800">Completed Assignment</p>
        </div>

        <div class="w-full grid lg:grid-cols-3 gap-5 h-auto px-4 lg:px-10 mt-2">

            @if($completed->isNotEmpty())
                @foreach ($completed as $assignment)
                <div class="w-full h-[150px] gap-3 shadow-md relative bg-white rounded-md">
                    <div class="w-full h-[10px] bg-[#588157] rounded-t-md "></div>
                    <div class="w-full h-full flex flex-col justify-between px-2 pt-2 pb-5">
                        <div class="flex items-center justify-between">
                            <p class="text-md text-zinc-800 font-semibold text-xl">{{$assignment->assignment_title}}</p>
                            <p class="bg-[#FFCC68]/25 font-semibold px-2 py-1 text-sm rounded-xl text-[#588157]">Completed</p>
                        </div>
                        <div class="flex items-center gap-1">
                            <img class="size-4" src="{{asset('Teacher/icons/assignment.png')}}">
                            <p class="text-md text-zinc-500">Assignment Code: {{$assignment->assignment_code}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <p class="font1 text-zinc-500 font-semibold">No Completed Assignments</p>
            @endif
        </div>
        {{-- <a href="{{ route('view-complete') }}"> --}}
        <a href="{{ route('view-complete', ['classroom_code' => $combinedData['classroom'][0]['classroom_code']]) }}">
            <div class="w-full h-[50px] flex items-center justify-end px-4 lg:px-10 mt-2 font1 gap-1">
                <p class="hover:text-blue-500 hover:cursor-pointer">Show All</p>
                <img class="size-5 rotate-[180deg]" src="{{asset('Teacher/icons/back.png')}}">
            </div>
        </a>
    </section>

    <section class="mt-4">
        <div class="w-full h-[50px] px-4 lg:px-10 flex items-center gap-3 font1">
            <div class="w-[15px] h-[15px] bg-[#FF0000] rounded-[50%]"></div>
            <p class="text-2xl font-semibold text-zinc-800">Overdue Assignment</p>
        </div>

        <div class="w-full grid lg:grid-cols-3 gap-5 h-auto px-4 lg:px-10 mt-2">

            @if($overdue->isNotEmpty())
                @foreach ($overdue as $assignment)
                <div class="w-full h-[150px] gap-3 relative shadow-md bg-white  rounded-md">
                    <div class="w-full h-[10px] bg-[#FF0000] rounded-t-md "></div>
                    <div class="w-full h-full flex flex-col justify-between px-2 pt-2 pb-5">
                        <div class="flex items-center justify-between">
                            <p class="text-md text-zinc-800 font-semibold text-xl">{{$assignment->assignment->assignment_title}}</p>
                            <p class="bg-[#FFCC68]/25 font-semibold px-2 py-1 text-sm rounded-xl text-[#FF0000]">Overdue</p>
                        </div>
                        <div class="flex items-center gap-1">
                            <img class="size-4" src="{{asset('Teacher/icons/assignment.png')}}">
                            <p class="text-md text-zinc-500">Assignment Code: {{$assignment->assignment->custom_game_assignment_code}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <p class="font1 text-zinc-500 font-semibold">No Overdue Assignments</p>
            @endif
        </div>
        {{-- <a href="{{ route('view-overdue') }}"> --}}
        <a href="{{ route('view-overdue', ['classroom_code' => $combinedData['classroom'][0]['classroom_code']]) }}">
            <div class="w-full h-[50px] flex items-center justify-end px-4 lg:px-10 mt-2 font1 gap-1">
                <p class="hover:text-blue-500 hover:cursor-pointer">Show All</p>
                <img class="size-5 rotate-[180deg]" src="{{asset('Teacher/icons/back.png')}}">
            </div>
        </a>
    </section>

</body>

@endsection



