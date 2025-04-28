@extends('TeacherDashboard.teacher-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body>
    <x-teacher-navbar />
    <x-toast/>
    <div class="w-full h-full fixed top-0 left-0 -z-30">
        <img class="w-full h-full object-cover" src="{{asset('Teacher/bg3.jpg')}}">
    </div>


    <div id="nav-tab" class="w-full h-[22%] fixed bottom-[-18%] bg-white/0 shadow-xl transition-all duration-200 ease-linear rounded-tl-lg rounded-tr-lg font1 z-50 md:hidden">
       <div id="open-nav-tab" class="flex items-center justify-center hover:cursor-pointer transition-all duration-200 rotate-0"><img src="{{ asset('Teacher/icons/collapse.png') }}" class="size-6"></div>

            <div class="w-full h-[10px] bg-[#2A6DF4] rounded-tl-lg rounded-tr-lg">
            </div>

            <div class="w-full h-[70%] grid grid-cols-2 gap-5 p-3 bg-white">
                <div class="w-full h-[50px] bg-white rounded-md shadow-lg relative">
                    <div id="overview-btn"  class="w-full h-full bg-white absolute z-10 rounded-md flex items-center justify-center hover:cursor-pointer">
                        <p>Overview Tab</p>
                    </div>
                    <div class="w-full h-full bg-black translate-x-1 translate-y-1 rounded-md absolute"></div>
                </div>
                <div class="w-full h-[50px] bg-white rounded-md shadow-lg relative">
                    <div id="student-btn" class="w-full h-full bg-white absolute z-10 rounded-md flex items-center justify-center hover:cursor-pointer">
                        <p>Student Tab</p>

                    </div>
                    <div class="w-full h-full bg-black translate-x-1 translate-y-1 rounded-md absolute"></div>
                </div>
                <div class="w-full h-[50px] bg-white rounded-md shadow-lg relative">
                    <div id="gameroom-btn" class="w-full h-full bg-white absolute z-10 rounded-md flex items-center justify-center hover:cursor-pointer">
                        <p>Gameroom Tab</p>

                    </div>
                    <div class="w-full h-full bg-black translate-x-1 translate-y-1 rounded-md absolute"></div>
                </div>
                <div class="w-full h-[50px] bg-white rounded-md shadow-lg relative">
                    <div id="assignment-btn" class="w-full h-full bg-white absolute z-10 rounded-md flex items-center justify-center hover:cursor-pointer">
                        <p>Assignment Tab</p>

                    </div>
                    <div class="w-full h-full bg-black translate-x-1 translate-y-1 rounded-md absolute"></div>
                </div>
            </div>


    </div>


    <div class="w-full h-[30px] mt-5 px-5 lg:px-10 flex items-center justify-between font1">
        <div class="flex items-center">
            <a href="{{route('ockted')}}">
                <div class="w-[30px] h-[30px] rounded-[50%] transition-all ease-in duration-200 hover:cursor-pointer hover:bg-pink-500 flex items-center justify-center">
                    <img src="{{asset('Teacher/icons/back.png')}}" class="w-[75%] h-[75%]">
                </div>
            </a>
        </div>
        <div class="">

            <div class="flex items-center gap-2 transition-all group ease-in duration-200 hover:cursor-pointer" onclick="copyGameroomLink(this)" data-link="{{$combinedData['Class Room Link']}}">
                <p id="copy-text" class="hidden text-[#2A6DF4] font-semibold">copied!</p>
                <img src="{{asset('Teacher/icons/copy.png')}}" class="size-6">
                <p class="font-medium text-[#4A4A4A] text-sm group-hover:text-black">Copy Gameroom Link</p>
            </div>

        </div>
    </div>
    <div class="mt-5 lg:mt-5 font1 lg:px-10 px-5 flex flex-col lg:flex-row gap-3 w-full lg:justify-between h-[120px] lg:h-[100px]">
        <div class="flex flex-col gap-3 w-full justify-start ">
            <p class="text-2xl lg:text-4xl font-extrabold">{{$combinedData['Class Room'][0]['classroom_title']}}</p>
            <p class="text-xl text-zinc-600 font-medium">{{$combinedData['Class Room'][0]['classroom_description']}}</p>
        </div>
        <div class="w-full flex items-start justify-start lg:justify-end ">
            <p class="text-md lg:text-2xl text-[#4A4A4A]">Class {{$combinedData['Class Room'][0]['class_level']}}</p>
        </div>
    </div>

    <div class="w-full hidden h-[50px] md:flex items-center justify-center lg:px-10 px-5 font1">
        <div class="w-full lg:w-[75%] flex justify-between items-center font-bold text-[#4A4A4A]">
            <div id="overview-btn" class="hover:cursor-pointer flex w-full gap-2 items-center h-full">
                <div class="">
                    <img src="{{asset('Teacher/icons/overview.png')}}" class="size-6">
                </div>
                <div class="">
                    <p class="">Overview</p>
                    <div id="add-border-overview"  class="block border-b-2 border-black"></div>
                </div>
            </div>
            <div id="student-btn" class="hover:cursor-pointer flex w-full gap-2 items-center h-full">
                <div class="">
                    <img src="{{asset('Teacher/icons/students.png')}}" class="size-6">
                </div>
                <div class="">
                    <p  class="">Students</p>
                    <div id="add-border-student" class="hidden border-b-2 border-black"></div>
                </div>
            </div>

            <div id="gameroom-btn" class="hover:cursor-pointer flex w-full gap-2 items-center h-full">
                <div class="">
                    <img src="{{asset('Teacher/icons/game.png')}}" class="size-6">
                </div>
                <div class="">
                    <p  class="">Game Room</p>
                    <div id="add-border-gameroom" class="hidden border-b-2 border-black"></div>
                </div>
            </div>

            {{-- <div id="add-game-assignment-btn" class="hover:cursor-pointer flex w-full gap-2 items-center h-full">
                <div class="">
                    <img src="{{asset('Teacher/icons/game.png')}}" class="size-6">
                </div>
                <div class="">
                    <p  class="">Games</p>
                    <div id="add-border-game-assignment" class="hidden border-b-2 border-black"></div>
                </div>
            </div> --}}

            <div id="assignment-btn" class="hover:cursor-pointer flex w-full gap-2 items-center h-full">
                <div class="">
                    <img src="{{asset('Teacher/icons/assignmentmenu.png')}}" class="size-6">
                </div>
                <div class="">
                    <p  class="">Assignment</p>
                    <div id="add-border-assignment" class="hidden border-b-2 border-black"></div>
                </div>
            </div>
        </div>
    </div>




    <div id="overview-tab" class="flex-col mt-5">
        <div class="px-2 lg:px-10 w-full mt-5 lg:mt-10">
            <p class="text-xl  font-bold text-zinc-800">Overview</p>
        </div>
        <div class="w-full h-[150px] lg:h-[200px] flex items-center justify-center px-2 mt-2 lg:mt-0 lg:px-10">
            <div class="w-full lg:w-[80%] h-full  grid grid-cols-1 lg:grid-cols-3 items-center justify-between gap-2  lg:gap-5 font1">

                <div class="w-full h-[120px] lg:h-[150px] flex flex-col items-start  rounded-lg border-l-[8px] border-[#2A6DF4] p-3">
                    <div class="w-full">
                        <p class="text-md lg:text-2xl font-semibold">Students</p>
                    </div>
                    <div class="w-full">
                        <p class="text-sm lg:text-xl text-[#6b6969]">Total Enrolled</p>
                    </div>
                    <div class="w-full flex items-center gap-1 lg:gap-5 mt-3">
                        <img src="{{asset('Teacher/icons/group-blue.png')}}" class="size-10 lg:size-12">
                        <p class="text-md lg:text-3xl font-bold">{{$combinedData['Total Student']}}</p>
                    </div>
                </div>

                <div class="w-full h-[120px] lg:h-[150px] flex flex-col items-start rounded-lg border-l-[8px] border-[#316CE2] p-3">
                    <div class="w-full">
                        <p class="text-md lg:text-2xl font-semibold">Game Room</p>
                    </div>
                    <div class="w-full">
                        <p class="text-sm lg:text-xl text-[#6b6969]">Total Created</p>
                    </div>
                    <div class="w-full flex items-center gap-1 lg:gap-5 mt-3">
                        <img src="{{asset('Teacher/icons/game2.png')}}" class="size-10 lg:size-12">
                        <p class="text-md lg:text-3xl font-bold">{{$combinedData['Total Game Room']}}</p>
                    </div>
                </div>

                <div class="w-full h-[120px] lg:h-[150px] flex flex-col items-start rounded-lg border-l-[8px] border-[#316CE2] p-3">
                    <div class="w-full">
                        <p class="text-md lg:text-2xl font-semibold">Assignment</p>
                    </div>
                    <div class="w-full">
                        <p class="text-sm lg:text-xl text-[#6b6969]">Total Created</p>
                    </div>
                    <div class="w-full flex items-center gap-1 lg:gap-5 mt-3">
                        <img src="{{asset('Teacher/icons/assignment-green.png')}}" class="size-10 lg:size-12">
                        <p class="text-md lg:text-3xl font-bold">{{$totalAssignmentCount}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="student-tab" class="hidden mt-5">
        <div class="w-full h-[60vh] mt-5 lg:px-10 px-2 font1">
            <h1 class="text-xl font-bold">Students ({{$combinedData['Total Student']}})</h1>
            {{-- <div class="w-full flex flex-col gap-2 h-[55vh] overflow-hidden overflow-y-scroll"> --}}
            <div class="w-full flex flex-col gap-2 h-auto">


                @if (isset($combinedData['Student in Room']['students']) && count($combinedData['Student in Room']['students']) > 0)
                    @foreach ($combinedData['Student in Room']['students'] as $key=>$student)
                        <div class="w-full bg-white rounded-lg py-3 px-2 lg:px-5 hover:border-b-2 hover:border-zinc-300 h-[80px] flex items-center justify-between">
                            <div class="flex gap-3">
                                <div class="w-[60px] h-[60px] rounded-[50%] bg-pink-300">
                                    <img src="{{$student['profile_picture']}}" class="h-full w-full object-cover rounded-[50%]">
                                </div>
                                <div class="flex flex-col gap-2">
                                    <p class="font-bold">{{$student['student_name']}}</p>
                                    <p class="text-zinc-400 text-sm font-semibold">Student ID: {{$student['student_id']}}</p>
                                </div>
                            </div>
                            <div class="flex gap-7">
                                <div class="flex flex-col">
                                    <p class="text-zinc-400">Completed</p>
                                    <div class="flex items-center justify-center gap-2">
                                        <img src="{{asset('Teacher/icons/badge.png')}}" class="size-6">
                                        <p class="font-semibold">3</p>
                                    </div>
                                </div>
                                <div class="items-center justify-center hidden lg:flex">
                                    <p class="bg-[#4BE79E] w-full px-3 py-1 rounded-xl font-bold">{{$student['student_status']}}</p>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-zinc-500 font-semibold p-7">NO STUDENTS...</p>
                @endif



            </div>
        </div>
    </div>

    <div id="gameroom-tab" class="hidden mt-5">
        <div class="flex lg:flex-row flex-col justify-between  items-center w-full mt-10 lg:px-10 px-2 font1">
            <div class="w-full">
                <h1 class="text-xl lg:text-2xl font-bold">Gameroom ({{$combinedData['Total Game Room']}})</h1>
            </div>
            <div class="mt-3 lg:mt-0 w-full flex flex-col lg:flex-row items-center gap-3 justify-center lg:justify-end ">
                <div id="add-gameroom-btn" class="bg-[#2A6DF4] text-white px-5 py-3 rounded-[5px] flex items-center gap-2 font1 hover:cursor-pointer">
                    <img class="size-4 lg:size-6" src="{{asset('Teacher/icons/add.png')}}">
                    <h1 class="text-xs lg:text-base">Add Custom Game </h1>
                </div>
            </div>
        </div>



            <div class="w-full h-[50vh] overflow-hidden overflow-y-scroll lg:px-10 px-2 font1">
                <div class="px-5 lg:px-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 w-full mt-8 gap-5 font1 text-zinc-600">
                    @if (isset($combinedData['Game Room']) && count($combinedData['Game Room']) > 0)
                       @foreach ($combinedData['Game Room'] as $key=>$game )
                       <a href="{{route('view-gameroom', ['gameroom_code' => $game['gameroom_code']])}}">
                           <div class="w-full h-[230px] bg-white lg:h-[150px] p-5 rounded-lg relative transition-all duration-200 ease-linear hover:-translate-y-2 hover:cursor-pointer">
                               <div class="absolute  w-[50px] h-[50px] top-[-5%] lg:top-[-13%] z-10 left-[-5%] rotate-6">
                                   <img class="w-full h-full" src="{{asset('Teacher/icons/assignment-logo.png')}}">
                               </div>
                               <div class="absolute w-full rounded-t-lg h-[15px] left-0 top-0" style="background-color: {{$game['gameroom_color']}}"></div>
                               <div class="w-full flex flex-col lg:flex-row  lg:justify-between lg:items-center mt-3">
                                   <h1 class="text-2xl font-semibold text-zinc-900">{{$game['gameroom_type']}}</h1>
                               </div>
                               {{-- <div class="w-full flex flex-col lg:flex-row gap-4 lg:items-center mt-4">
                                   <div class="flex items-center gap-2">
                                   <img class="size-4" src="{{asset('Teacher/icons/assignment.png')}}">
                                   <p>5/25 students completed</p>
                                   </div>
                               </div> --}}
                               <div class="w-full mt-3">
                                   <h1 class="text-md">Game Room ID: {{$game['gameroom_code']}}</h1>
                               </div>
                           </div>
                       </a>
                       @endforeach
                    @else
                        <p class="text-zinc-500 font-semibold">NO GAMEROOM...</p>
                    @endif

                </div>
            </div>
    </div>

    <div id="add-game-assignment-tab" class="hidden mt-5">
        <div class="flex lg:flex-row flex-col justify-between  items-center w-full mt-10 lg:px-10 px-2 font1">
            <div class="w-full">
                <h1 class="text-xl lg:text-2xl font-bold">Available Games({{$totalGames}})</h1>
            </div>
        </div>

            <div class="w-full h-auto lg:px-10 px-2 font1">
                <div class="px-5 lg:px-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 w-full mt-8 gap-5 font1 text-zinc-600">
                    @if (isset($combinedData['Game Data']) && count($combinedData['Game Data']) > 0)
                       @foreach ($combinedData['Game Data'] as $key=>$game )
                       <form action="{{route('create-game-assignment')}}" method="POST">
                        @csrf
                           <div class="w-full h-auto -z-10 lg:h-[150px] bg-zinc-200 px-2 pt-5 rounded-lg relative transition-all duration-200 ease-linear hover:-translate-y-2 hover:cursor-pointer">
                               <div class="absolute  w-[50px] h-[50px] top-[-5%] lg:top-[-13%] z-10 left-[-5%] rotate-6">
                                   <img class="w-full h-full" src="{{asset('Teacher/icons/assignment-logo.png')}}">
                               </div>
                               <div class="w-full h-full flex flex-col md:flex-row gap-3">
                                <div class="w-[50%]  flex items-center justify-center md:w-[30%] h-full rounded-md">
                                    <img class="w-full  h-full object-cover rounded-md " src="{{$game->game_banner}}">
                                </div>
                                <div class="flex flex-row md:flex-col">
                                    <div class="w-full h-[150px]">
                                        <p class="text-xl">{{$game->game_title}}</p>
                                        <p class="text-md">{{$game->game_description}}</p>
                                        {{-- <p class="text-md">{{$game->game_code}}</p> --}}

                                    </div>
                                    <div class="w-[80%] lg:w-auto h-fit flex justify-end">
                                        <p
                                        id="open-game-assignment-modal"
                                        class="hover:cursor-pointer transition-all duration-200 ease-linear hover:text-white px-1 hover:bg-zinc-800 text-lg text-zinc-950 font-bold"
                                        data-game-code="{{ $game->game_code }}"
                                        >
                                            Assign Game
                                        </p>
                                    </div>
                                </div>
                               </div>
                           </div>
                        </form>
                       @endforeach
                    @else
                        <p class="text-zinc-500 font-semibold">NO GAMEROOM...</p>
                    @endif

                </div>
            </div>
    </div>

                                    {{-- <div id="game-assignment-modal" class="hidden w-full h-screen fixed top-0 bg-zinc-700 bg-opacity-50 justify-center items-center px-3 font1 font-medium z-50">
                                        <div class="w-[500px] h-[350px] bg-[#fffcf2] rounded-lg">
                                            <div class="h-[50px] w-full rounded-t-lg bg-[#05668d] flex items-center justify-between px-2">
                                                <h1 class="text-xl text-zinc-200 font-semibold">Add Game Room</h1>
                                                <img src="{{asset('Teacher/icons/cross.png')}}" class="size-10 hover:cursor-pointer" id="cross-btn1">
                                            </div>
                                            <form action="{{route('create-game-assignment')}}" method="POST">
                                                <div class="w-full p-4">
                                                    <div class="w-full flex flex-col mt-3">
                                                        <label class="font-bold text-xl">Due Date</label>
                                                        <input type="date" name="due_date">
                                                    </div>
                                                    <input type="hidden" name="game_code" id="modal-game-code">
                                                    <div class="w-full flex items-center justify-center mt-3 h-[80px]">
                                                        <button type="submit" class="bg-[#05668d] px-3 p-1 text-zinc-200 font-medium rounded-sm">Add Game Room</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div> --}}


    <div id="assignment-tab" class="hidden mt-5">
        <div class="flex justify-between  items-center w-full mt-10 lg:px-10 px-2 font1">
            <div class="w-full">
                <h1 class="text-xl lg:text-2xl font-bold">Assignments ({{$totalAssignmentCount}})</h1>
            </div>
        </div>



            <div class="w-full h-[50vh] overflow-hidden overflow-y-scroll lg:px-10 px-2 font1">
                <div class="px-5 lg:px-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 w-full mt-8 gap-5 font1 text-zinc-600">

                    @php
                    // turn both into collections, merge them
                    $all = collect($combinedData['Assignments'] ?? [])
                        ->merge($combinedData['Game Assignment'] ?? []);
                    @endphp

                    @if($all->isEmpty())
                        <p class="text-zinc-500 font-semibold">NO Assignment…</p>
                    @else
                        @foreach($all as $assignment)
                            @php
                                // unify your code & counts into common variables
                                $code       = $assignment->custom_game_assignment_code
                                            ?? $assignment->game_assignment_code;
                                $title      = $assignment->assignment_title;
                                $due        = $assignment->due_date;
                                $completed  = $assignment->completed_students ?? 0;
                                // if one side didn’t carry total_students, fall back
                                $total      = $assignment->total_students
                                            ?? $combinedData['Total Student']
                                            ?? 0;
                            @endphp
                                <a href="{{ route('view-assignment-details', ['assignment_code' => $code]) }}">
                                    <div class="w-full h-[230px] lg:h-[200px] bg-white p-5 rounded-lg relative transition-all duration-200 ease-linear hover:-translate-y-2 hover:cursor-pointer">
                                        <div class="absolute  w-[50px] h-[50px] top-[-5%] lg:top-[-13%] z-10 left-[-5%] rotate-6">
                                            <img class="w-full h-full" src="{{asset('Teacher/icons/assignment-logo.png')}}">
                                        </div>
                                        <div class="w-full flex flex-col lg:flex-row  lg:justify-between lg:items-center mt-3">
                                            <h1 class="text-2xl font-semibold text-zinc-900">{{ $title }}</h1>
                                        </div>
                                        <div class="w-full flex flex-col mt-4">
                                            <div class="flex items-center gap-2">
                                                <img class="size-4" src="{{asset('Teacher/icons/time.png')}}">
                                                <p>Due Date: {{ $due }}</p>
                                            </div>
                                            <div class="w-full flex flex-col lg:flex-row gap-4 lg:items-center mt-4">
                                                <div class="flex items-center gap-2">
                                                <img class="size-4" src="{{asset('Teacher/icons/assignment.png')}}">
                                                <p>{{ $completed }}/{{ $total }} students completed</p>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="w-full mt-3">
                                            <h1 class="text-md">Assignment ID: {{ $code }}</h1>
                                        </div>
                                    </div>
                                </a>

                        @endforeach
                    @endif
                </div>
            </div>
    </div>

    <div id="gameroom-modal" class="hidden w-full h-screen fixed top-0 bg-zinc-700 bg-opacity-50 justify-center items-center px-3 font1 font-medium z-50">
        <div class="w-[500px] h-auto bg-white rounded-lg">
            <div class="h-[50px] w-full rounded-t-lg bg-[#05668d] flex items-center justify-between px-2">
                <h1 class="text-xl text-zinc-200 font-semibold">Add Game Room</h1>
                <img src="{{asset('Teacher/icons/cross.png')}}" class="size-10 hover:cursor-pointer" id="cross-btn">
            </div>
            <form action="{{route('create-gameroom')}}" method="POST">
                @csrf
                <div class="w-full p-4">
                    <div class="w-full flex flex-col mt-3">
                        <label class="font-bold text-xl">Select Game</label>
                        <select id="input-1" name="gameroom_type" class="w-full h-[50px] border-b-2 border-zinc-300 mt-2">
                            <option active >Select Game Type</option>
                            <option value="Multiple Choice Question">MCQ</option>
                            <option value="Guess The Picture">Guess The Picture</option>
                            <option value="Numbers">Numbers</option>
                        </select>
                        <p id="error-1" class="text-sm text-red-400 hidden">Select a Game!</p>
                    </div>

                    <div class="gap-4 mt-3 w-full">
                        <label class="font-bold text-xl">Select Color</label>
                        <div class="flex gap-5 items-center justify-center mt-2">
                            <label class="cursor-pointer">
                                <input id="input-2" type="radio" name="gameroom_color" value="#a4dded" class="hidden peer">
                                <div class="w-[50px] h-[50px] rounded-[50%] bg-[#a4dded] peer-checked:ring-4 ring-black"></div>
                            </label>
                            <label class="cursor-pointer">
                                <input id="input-2" type="radio" name="gameroom_color" value="#eb8ca8" class="hidden peer">
                                <div class="w-[50px] h-[50px] rounded-[50%] bg-[#eb8ca8] peer-checked:ring-4 ring-black"></div>
                            </label>
                            <label class="cursor-pointer">
                                <input id="input-2" type="radio" name="gameroom_color" value="#ee7674" class="hidden peer">
                                <div class="w-[50px] h-[50px] rounded-[50%] bg-[#ee7674] peer-checked:ring-4 ring-black"></div>
                            </label>
                            <label class="cursor-pointer">
                                <input id="input-2" type="radio" name="gameroom_color" value="#f3dc7f" class="hidden peer">
                                <div class="w-[50px] h-[50px] rounded-[50%] bg-[#f3dc7f] peer-checked:ring-4 ring-black"></div>
                            </label>
                        </div>
                        <p id="error-2" class="text-sm text-red-400 hidden">Select a color!</p>
                    </div>

                    <div class="w-full flex items-center justify-center mt-3 h-[80px]">
                        <button onclick="checkValidation(event)" type="submit" class="bg-[#05668d] px-3 p-1 text-zinc-200 font-medium rounded-sm">Add Game Room</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const error1 = document.getElementById('error-1');
        const error2 = document.getElementById('error-2');


        const input1 = document.getElementById('input-1');
        const input2 = document.querySelectorAll('input[name="gameroom_color"]'); // Get all radio buttons for color selection

        function checkValidation(event) {
            let isValid = true;


         // Validate Class Level (input-3)
            if (input1.value === "" || input1.value === null || input1.value === "Select Game Type") {
                error1.classList.remove('hidden');
                error1.textContent = 'Select a Game!'; // Update error message for clarity
                isValid = false;
            } else {
                error1.classList.add('hidden');
            }

            // Validate Classroom Color (input-4)
            let colorSelected = false;
            input2.forEach((input) => {
                if (input.checked) {
                    colorSelected = true;
                }
            });

            if (!colorSelected) {
                error2.classList.remove('hidden');
                isValid = false;
            } else {
                error2.classList.add('hidden');
            }

            // If validation fails, prevent form submission
            if (!isValid) {
                event.preventDefault();
            }
        }

        // Attach the validation function to the form's submit event
        const form = document.querySelector('form');
        form.addEventListener('submit', checkValidation);
    </script>


<script>
    const overviewButton = document.querySelectorAll('#overview-btn');
    const studentButton = document.querySelectorAll('#student-btn');
    const gameroomButton = document.querySelectorAll('#gameroom-btn');
    const assignmentButton = document.querySelectorAll('#assignment-btn');
    const gameAssignmentButton = document.querySelectorAll('#add-game-assignment-btn');

    const addBorderOverview = document.getElementById('add-border-overview');
    const addBorderStudent = document.getElementById('add-border-student');
    const addBorderGameroom = document.getElementById('add-border-gameroom');
    const addBorderAssignment = document.getElementById('add-border-assignment');
    const addBorderGameAssignment = document.getElementById('add-border-game-assignment');


    const overviewTab = document.getElementById('overview-tab');
    const studentTab = document.getElementById('student-tab');
    const gameroomTab = document.getElementById('gameroom-tab');
    const assignmentTab = document.getElementById('assignment-tab');
    const addGameAssignmentTab = document.getElementById('add-game-assignment-tab');

    overviewButton.forEach(overbutton => {
        overbutton.addEventListener('click', function(){
            overviewTab.classList.add('flex');
            overviewTab.classList.remove('hidden');

            studentTab.classList.add('hidden');
            gameroomTab.classList.add('hidden');
            assignmentTab.classList.add('hidden');
            addGameAssignmentTab.classList.add('hidden');

            addBorderOverview.classList.remove('hidden');
            addBorderOverview.classList.add('block');
            addBorderStudent.classList.add('hidden');
            addBorderGameroom.classList.add('hidden');
            addBorderAssignment.classList.add('hidden');
            addBorderGameAssignment.classList.add('hidden');
        });
    });

    studentButton.forEach(studentbtn => {
        studentbtn.addEventListener('click', function(){
            studentTab.classList.add('flex');
            studentTab.classList.remove('hidden');

            overviewTab.classList.add('hidden');
            gameroomTab.classList.add('hidden');
            assignmentTab.classList.add('hidden');
            addGameAssignmentTab.classList.add('hidden');

            addBorderStudent.classList.remove('hidden');
            addBorderStudent.classList.add('block');
            addBorderOverview.classList.add('hidden');
            addBorderGameroom.classList.add('hidden');
            addBorderAssignment.classList.add('hidden');
            addBorderGameAssignment.classList.add('hidden');

        });
    })

    gameroomButton.forEach(gamebtn => {
        gamebtn.addEventListener('click', function(){
            gameroomTab.classList.add('block');
            gameroomTab.classList.remove('hidden');

            studentTab.classList.add('hidden');
            overviewTab.classList.add('hidden');
            assignmentTab.classList.add('hidden');
            addGameAssignmentTab.classList.add('hidden');

            addBorderGameroom.classList.remove('hidden');
            addBorderGameroom.classList.add('block');
            addBorderStudent.classList.add('hidden');
            addBorderOverview.classList.add('hidden');
            addBorderAssignment.classList.add('hidden');
            addBorderGameAssignment.classList.add('hidden');

        });
    })


    assignmentButton.forEach(assignbtn => {
        assignbtn.addEventListener('click', function(){
            assignmentTab.classList.add('block');
            assignmentTab.classList.remove('hidden');

            studentTab.classList.add('hidden');
            overviewTab.classList.add('hidden');
            gameroomTab.classList.add('hidden');
            addGameAssignmentTab.classList.add('hidden');

            addBorderAssignment.classList.remove('hidden');
            addBorderAssignment.classList.add('block');
            addBorderStudent.classList.add('hidden');
            addBorderOverview.classList.add('hidden');
            addBorderGameroom.classList.add('hidden');
            addBorderGameAssignment.classList.add('hidden');
        });
    });

    gameAssignmentButton.forEach(gameassignbtn => {
        gameassignbtn.addEventListener('click', function(){
            addGameAssignmentTab.classList.add('block');
            addGameAssignmentTab.classList.remove('hidden');

            studentTab.classList.add('hidden');
            overviewTab.classList.add('hidden');
            gameroomTab.classList.add('hidden');
            assignmentTab.classList.add('hidden');

            addBorderGameAssignment.classList.remove('hidden');
            addBorderGameAssignment.classList.add('block');
            addBorderStudent.classList.add('hidden');
            addBorderOverview.classList.add('hidden');
            addBorderGameroom.classList.add('hidden');
            addBorderAssignment.classList.add('hidden');

        });
    });

    const gameroomModal = document.getElementById('gameroom-modal');
    const crossButton = document.getElementById('cross-btn');
    const addgameroomButton = document.getElementById('add-gameroom-btn');

    addgameroomButton.addEventListener('click', function(){
        console.log('click')
        gameroomModal.classList.add('flex');
        gameroomModal.classList.remove('hidden');
    });

    crossButton.addEventListener('click', function(){
        console.log('click')
        gameroomModal.classList.remove('flex');
        gameroomModal.classList.add('hidden');
    });

    //COPY LINK JS
    function copyGameroomLink(element) {
        // Get the gameroom link from data attribute
        const link = element.getAttribute("data-link");
        const copyText = document.getElementById('copy-text');

        // Copy to clipboard
        navigator.clipboard.writeText(link).then(() => {
            // alert("Gameroom link copied!");
            copyText.classList.remove('hidden');
            setTimeout(() => copyText.classList.add('hidden'), 2000); // Remove completely after fading out
        }).catch(err => {
            console.error("Failed to copy: ", err);
        });
    }

    const gameAssignmentModalButton = document.querySelectorAll('#open-game-assignment-modal');
    const gameAssignmentModal = document.getElementById('game-assignment-modal');
    const crossButton1 = document.getElementById('cross-btn1');

    gameAssignmentModalButton.forEach(assignbtn => {
        assignbtn.addEventListener('click', function(){
            console.log('click');
            const gameCode = assignbtn.dataset.gameCode;
            document.getElementById('modal-game-code').value = gameCode;
            gameAssignmentModal.classList.add('flex');
            gameAssignmentModal.classList.remove('hidden');

        });
    });

    crossButton1.addEventListener('click', function(){
            gameAssignmentModal.classList.add('hidden');
            gameAssignmentModal.classList.remove('flex');
        });


</script>

<script>
    const navTab = document.getElementById('nav-tab');
    const openBtn = document.getElementById('open-nav-tab');

    let isOpen = false;

    openBtn.addEventListener('click', function () {
        if (isOpen) {

            navTab.classList.remove('bottom-0');
            navTab.classList.add('bottom-[-18%]');
            openBtn.classList.add('rotate-0');
            openBtn.classList.remove('rotate-[180deg]');
        } else {
            openBtn.classList.add('rotate-[180deg]');
            openBtn.classList.remove('rotate-0');
            navTab.classList.remove('bottom-[-18%]');
            navTab.classList.add('bottom-0');
        }
        isOpen = !isOpen;
    });
</script>
</body>
@endsection

