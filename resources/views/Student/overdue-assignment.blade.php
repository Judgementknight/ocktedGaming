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
        <a href="{{ route('view-classroom-assignment', ['classroom_code' => $combinedData['classroom'][0]['classroom_code']]) }}">
            <div class="flex gap-3 hover:cursor-pointer hover:text-zinc-950 text-zinc-600">
                <img class="size-6" src="{{asset('Teacher/icons/back.png')}}">
                <p class="">Back to Dashboard</p>
            </div>
        </a>
    </div>

    <div class="px-4 lg:px-10 w-full h-[50px] gap-5 lg:gap-0 flex flex-col lg:flex-col items-center justify-center lg:justify-evenly font1">
        <div class="w-full">
            <div class="w-full md:w-[20%] h-[4px] rounded-md bg-[#2776F9]"></div>
        </div>
        {{-- <div class="justify-center text-center flex gap-5 lg:text-left flex-col w-full ">
            <div class="flex-col flex">
                <h1 class="font-bold text-3xl text-zinc-800">{{$combinedData['classroom'][0]['classroom_title']}}</h1>
                <p class="text-center lg:text-left text-md text-zinc-500 mt-2">{{$combinedData['classroom'][0]['classroom_description']}}</p>
            </div>
            <div class="flex justify-center lg:justify-start gap-2 items-center">
                    <img class="size-5" src="{{asset('Teacher/icons/group.png')}}">
                    <p class="text-zinc-600">Teacher: {{$combinedData['classroom'][0]['teacher']['teacher_name']}} </p>
            </div>
        </div> --}}
    </div>

    <section class="mt-4">
        <div class="flex md:flex-row flex-col justify-between items-center px-4 lg:px-10">
            <div class="w-full h-[50px]  flex items-center gap-3 font1">
                <div class="w-[15px] h-[15px] bg-[#FF0000] rounded-[50%]"></div>
                <p class="text-2xl font-semibold text-zinc-800">Overdue Assignment</p>
            </div>
            <div class="font1 w-full flex md:justify-end">
                <p class="bg-[#f25c54] border-[1px] border-[#e63946] rounded-[20px] w-auto h-auto p-2">Total Overdue: {{ $count }}</p>
            </div>
        </div>

        <div class="w-full grid lg:grid-cols-3 gap-5 h-auto px-4 lg:px-10 mt-5">

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
    </section>

</body>

@endsection



