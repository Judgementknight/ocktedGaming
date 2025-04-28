@extends('Student.student-layout')

@section('OCKTED GAMING')

@section('content')
<body class="">
    <x-background />
    <x-student-navbar :picture="$student->profile_picture"/>
    <x-student-profile :picture="$student->profile_picture" :name="$student->student_name" :rank="$student->rank" :totalscore="$TotalScore"/>
        <section class="pb-10">
            <div class="w-full h-[50px] px-4  lg:px-10 flex items-end font1 py-3">
                <a href="{{route('welcome')}}">
                    <div class="flex gap-3 hover:cursor-pointer hover:text-zinc-950 text-zinc-600">
                        {{-- <img class="size-6" src="{{asset('Teacher/icons/back.png')}}"> --}}
                        {{-- <p class="">Back to Dashboard</p> --}}
                    </div>
                </a>
            </div>
            <div class="px-4 lg:px-10 w-full h-[150px] gap-5 lg:gap-0 flex flex-col lg:flex-col items-center justify-center lg:justify-evenly font1">
                <div class="w-full">
                    <div class="w-full lg:w-[20%] h-[4px] rounded-md bg-[#2776F9]"></div>
                </div>
                <div class="justify-center text-center flex gap-5 lg:text-left flex-col w-full ">
                    <div class="flex-col flex">
                        <h1 class="font-bold text-3xl text-zinc-800">Leaderboard</h1>
                        <p class="text-center lg:text-left text-md text-zinc-500 mt-2">Top scorer among Prayag Edu students</p>
                    </div>
                    <div class="flex justify-center lg:justify-start gap-2 items-center">
                            {{-- <img class="size-5" src="{{asset('Teacher/icons/group.png')}}"> --}}
                            {{-- <p class="text-zinc-600">Teacher: {{$combinedData['classroom'][0]['teacher']['teacher_name']}} </p> --}}
                    </div>
                </div>
            </div>

            <div class="px-4 lg:px-10 w-full h-auto  flex items-center justify-center pb-10 font1">
                <div class="w-full lg:w-[80%] bg-white xl:w-[70%] h-full gap-10 flex flex-col p-3 shadow-xl rounded-lg">
                    <div class="grid md:grid-cols-2 gap-5">
                        <div class="w-full h-[400px] rounded-md relative shadow-md bg-gradient-to-r from-violet-200 to-pink-200">
                            <img class="size-12 absolute" src="{{ asset('Teacher/icons/first.png') }}">
                            <div class="w-full h-[70%] p-2">
                                @if (isset($scores[0]->profile_picture))
                                    <img src="{{ $scores[0]->profile_picture}}" class="w-full h-full rounded-lg object-cover">
                                @else
                                    <img src="{{ asset('Teacher/icons/backuppfp.jpg') }}" class="w-full object-cover h-full rounded-lg" >
                                @endif
                            </div>
                            <div class="p-2 w-full h-[30%] flex rounded-lg">
                                <div class="w-full h-full rounded-lg items-center justify-between flex flex-col">
                                    @if (isset($scores[0]->student_name))
                                        <p class="text-zinc-700 text-xl font-bold">{{$scores[0]->student_name}}</p>
                                    @else
                                        <p class="text-zinc-700 text-md font-bold">No Records Yet</p>
                                    @endif
                                    {{-- <p class="text-zinc-400 text-xl">Class: 9</p> --}}
                                    @if (isset($scores[0]->total_score))
                                        <p class="text-zinc-400 text-md ">Total Score: <span class="text-green-400">{{$scores[0]->total_score}}</span> </p>
                                    @else
                                        <p></p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col w-full h-[350px] xl:h-[300px] gap-5">
                            <div class="w-full relative rounded-lg flex gap-[4%] h-[48%] shadow-md p-2 bg-gradient-to-r from-rose-100 to-teal-100">
                            <img class="lg:size-8 size-10 absolute left-0 top-0" src="{{ asset('Teacher/icons/second.png') }}">

                                <div class="h-full w-[40%] ">
                                    @if (isset($scores[1]->profile_picture))
                                        <img src="{{ $scores[1]->profile_picture }}" class="w-full object-cover h-full rounded-lg" >
                                    @else
                                    <img src="{{ asset('Teacher/icons/backuppfp.jpg') }}" class="w-full object-cover h-full rounded-lg" >
                                    @endif
                                </div>
                                <div class="h-full w-[60%] flex flex-col">
                                    @if (isset($scores[1]->student_name))
                                        <p class="text-zinc-700 text-lg p-2 font-bold">{{$scores[1]->student_name}}</p>
                                    @else
                                        <p class="text-zinc-700 text-md p-2 font-bold">No Records Yet</p>
                                    @endif
                                    {{-- <p class="text-zinc-400 text-md p-2">Class: 8</p> --}}
                                    @if (isset($scores[1]->total_score))
                                        <p class="text-zinc-400 text-md p-2 ">Total Score: <span class="text-green-400">{{$scores[1]->total_score}}</span> </p>
                                    @else
                                        <p></p>
                                    @endif
                                </div>
                            </div>

                            <div class="w-full relative rounded-lg flex gap-[4%] h-[48%] shadow-md p-2 bg-gradient-to-r from-indigo-200 to-yellow-100">
                                <img class="lg:size-8 size-10 absolute left-0 top-0" src="{{ asset('Teacher/icons/third.png') }}">
                                <div class="h-full w-[40%] ">
                                    @if (isset($scores[2]->profile_picture))
                                        <img src="{{ $scores[2]->profile_picture }}" class="w-full object-cover h-full rounded-lg" >
                                    @else
                                        <img src="{{ asset('Teacher/icons/backuppfp.jpg') }}" class="w-full object-cover h-full rounded-lg" >
                                    @endif
                                </div>
                                <div class="h-full w-[60%] flex flex-col">
                                    @if (isset($scores[2]->student_name))
                                        <p class="text-zinc-700 text-lg p-2 font-bold">{{$scores[2]->student_name}}</p>
                                    @else
                                        <p class="text-zinc-700 text-md p-2 font-bold">No Records Yet</p>
                                    @endif
                                    {{-- <p class="text-zinc-400 text-md p-2">Class: 8</p> --}}
                                    @if (isset($scores[2]->total_score))
                                        <p class="text-zinc-400 text-md p-2 ">Total Score: <span class="text-green-400">{{$scores[2]->total_score}}</span> </p>
                                    @else
                                        <p></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full h-auto xxl:h-[300px] rounded-lg grid md:grid-cols-2 xl:grid-cols-3 gap-3">

                        <div class="w-full h-[150px] bg-white xl:h-[130px] shadow-xl bg-background rounded-lg flex gap-2 p-2 xl:p-1">
                            <div class="w-[60%] h-full">
                                @if (isset($scores[3]))
                                    <img src="{{ $scores[3]->profile_picture }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <img src="{{ asset('Teacher/icons/backuppfp.jpg') }}" class="w-full h-full object-cover rounded-lg">
                                @endif
                            </div>
                            <div class="w-full h-full flex flex-col xl:justify-evenly">
                                @if (isset($scores[3]->student_name))
                                    <p class="text-zinc-700 text-lg xl:text-md font-bold p-2 xl:p-0">{{$scores[3]->student_name}}</p>
                                @else
                                    <p class="text-zinc-700 text-md xl:text-md font-bold p-2 xl:p-0">No Records Yet</p>
                                @endif
                                {{-- @if (isset($scores[3]->student_name))
                                <p class="text-zinc-700 text-md xl:text-sm p-2 xl:p-0">Class: 8</p>
                                @else
                                <p class="text-zinc-700 text-lg xl:text-md font-bold p-2 xl:p-0">No Records Yet</p>
                                @endif --}}
                                @if (isset($scores[3]->total_score))
                                    <p class="text-zinc-700 text-md xl:text-sm p-2 xl:p-0">Total Score: <span class="text-green-400">3023</span> </p>
                                @else
                                    <p class=""></p>
                                @endif
                            </div>
                        </div>

                        <div class="w-full h-[150px] bg-white xl:h-[130px] shadow-xl bg-background rounded-lg flex gap-2 p-2 xl:p-1">
                            <div class="w-[60%] h-full">
                                @if (isset($scores[4]))
                                    <img src="{{ $scores[4]->profile_picture }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <img src="{{ asset('Teacher/icons/backuppfp.jpg') }}" class="w-full h-full object-cover rounded-lg">
                                @endif
                            </div>
                            <div class="w-full h-full flex flex-col xl:justify-evenly">
                                @if (isset($scores[4]->student_name))
                                    <p class="text-zinc-700 text-lg xl:text-md font-bold p-2 xl:p-0">{{$scores[4]->student_name}}</p>
                                @else
                                    <p class="text-zinc-700 text-md xl:text-md font-bold p-2 xl:p-0">No Records Yet</p>
                                @endif
                                {{-- @if (isset($scores[3]->student_name))
                                <p class="text-zinc-700 text-md xl:text-sm p-2 xl:p-0">Class: 8</p>
                                @else
                                <p class="text-zinc-700 text-lg xl:text-md font-bold p-2 xl:p-0">No Records Yet</p>
                                @endif --}}
                                @if (isset($scores[4]->total_score))
                                    <p class="text-zinc-700 text-md xl:text-sm p-2 xl:p-0">Total Score: <span class="text-green-400">{{$scores[4]->total_score}}</span> </p>
                                @else
                                    <p class=""></p>
                                @endif
                            </div>
                        </div>


                        <div class="w-full h-[150px] bg-white xl:h-[130px] shadow-xl bg-background rounded-lg flex gap-2 p-2 xl:p-1">
                            <div class="w-[60%] h-full">
                                @if (isset($scores[5]))
                                    <img src="{{ $scores[5]->profile_picture }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <img src="{{ asset('Teacher/icons/backuppfp.jpg') }}" class="w-full h-full object-cover rounded-lg">
                                @endif
                            </div>
                            <div class="w-full h-full flex flex-col xl:justify-evenly">
                                @if (isset($scores[5]->student_name))
                                    <p class="text-zinc-700 text-lg xl:text-md font-bold p-2 xl:p-0">{{$scores[5]->student_name}}</p>
                                @else
                                    <p class="text-zinc-700 text-md xl:text-md font-bold p-2 xl:p-0">No Records Yet</p>
                                @endif
                                {{-- @if (isset($scores[3]->student_name))
                                <p class="text-zinc-700 text-md xl:text-sm p-2 xl:p-0">Class: 8</p>
                                @else
                                <p class="text-zinc-700 text-lg xl:text-md font-bold p-2 xl:p-0">No Records Yet</p>
                                @endif --}}
                                @if (isset($scores[5]->total_score))
                                    <p class="text-zinc-700 text-md xl:text-sm p-2 xl:p-0">Total Score: <span class="text-green-400">{{$scores[5]->total_score}}</span> </p>
                                @else
                                    <p class=""></p>
                                @endif
                            </div>
                        </div>


                        <div class="w-full h-[150px] bg-white xl:h-[130px] shadow-xl bg-background rounded-lg flex gap-2 p-2 xl:p-1">
                            <div class="w-[60%] h-full">
                                @if (isset($scores[6]))
                                    <img src="{{ $scores[6]->profile_picture }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <img src="{{ asset('Teacher/icons/backuppfp.jpg') }}" class="w-full h-full object-cover rounded-lg">
                                @endif
                            </div>
                            <div class="w-full h-full flex flex-col xl:justify-evenly">
                                @if (isset($scores[6]->student_name))
                                    <p class="text-zinc-700 text-lg xl:text-md font-bold p-2 xl:p-0">{{$scores[6]->student_name}}</p>
                                @else
                                    <p class="text-zinc-700 text-md xl:text-md font-bold p-2 xl:p-0">No Records Yet</p>
                                @endif
                                {{-- @if (isset($scores[3]->student_name))
                                <p class="text-zinc-700 text-md xl:text-sm p-2 xl:p-0">Class: 8</p>
                                @else
                                <p class="text-zinc-700 text-lg xl:text-md font-bold p-2 xl:p-0">No Records Yet</p>
                                @endif --}}
                                @if (isset($scores[6]->total_score))
                                    <p class="text-zinc-700 text-md xl:text-sm p-2 xl:p-0">Total Score: <span class="text-green-400">{{$scores[6]->total_score}}</span> </p>
                                @else
                                    <p class=""></p>
                                @endif
                            </div>
                        </div>


                        <div class="w-full h-[150px] bg-white xl:h-[130px] shadow-xl bg-background rounded-lg flex gap-2 p-2 xl:p-1">
                            <div class="w-[60%] h-full">
                                @if (isset($scores[7]))
                                    <img src="{{ $scores[7]->profile_picture }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <img src="{{ asset('Teacher/icons/backuppfp.jpg') }}" class="w-full h-full object-cover rounded-lg">
                                @endif
                            </div>
                            <div class="w-full h-full flex flex-col xl:justify-evenly">
                                @if (isset($scores[7]->student_name))
                                    <p class="text-zinc-700 text-lg xl:text-md font-bold p-2 xl:p-0">{{$scores[7]->student_name}}</p>
                                @else
                                    <p class="text-zinc-700 text-md xl:text-md font-bold p-2 xl:p-0">No Records Yet</p>
                                @endif
                                {{-- @if (isset($scores[3]->student_name))
                                <p class="text-zinc-700 text-md xl:text-sm p-2 xl:p-0">Class: 8</p>
                                @else
                                <p class="text-zinc-700 text-lg xl:text-md font-bold p-2 xl:p-0">No Records Yet</p>
                                @endif --}}
                                @if (isset($scores[7]->total_score))
                                    <p class="text-zinc-700 text-md xl:text-sm p-2 xl:p-0">Total Score: <span class="text-green-400">{{$scores[7]->total_score}}</span> </p>
                                @else
                                    <p class=""></p>
                                @endif
                            </div>
                        </div>


                        <div class="w-full h-[150px] bg-white xl:h-[130px] shadow-xl bg-background rounded-lg flex gap-2 p-2 xl:p-1">
                            <div class="w-[60%] h-full">
                                @if (isset($scores[8]))
                                    <img src="{{ $scores[8]->profile_picture }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <img src="{{ asset('Teacher/icons/backuppfp.jpg') }}" class="w-full h-full object-cover rounded-lg">
                                @endif
                            </div>
                            <div class="w-full h-full flex flex-col xl:justify-evenly">
                                @if (isset($scores[8]->student_name))
                                    <p class="text-zinc-700 text-lg xl:text-md font-bold p-2 xl:p-0">{{$scores[8]->student_name}}</p>
                                @else
                                    <p class="text-zinc-700 text-md xl:text-md font-bold p-2 xl:p-0">No Records Yet</p>
                                @endif
                                {{-- @if (isset($scores[3]->student_name))
                                <p class="text-zinc-700 text-md xl:text-sm p-2 xl:p-0">Class: 8</p>
                                @else
                                <p class="text-zinc-700 text-lg xl:text-md font-bold p-2 xl:p-0">No Records Yet</p>
                                @endif --}}
                                @if (isset($scores[8]->total_score))
                                    <p class="text-zinc-700 text-md xl:text-sm p-2 xl:p-0">Total Score: <span class="text-green-400">{{$scores[8]->total_score}}</span> </p>
                                @else
                                    <p class=""></p>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
</body>
@endsection
