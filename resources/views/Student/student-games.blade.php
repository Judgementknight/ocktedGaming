@extends('Student.student-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body>
    <x-student-navbar :picture="$student->profile_picture ?? ''"/>
    <x-toast/>
    <x-student-profile :picture="$student->profile_picture" :name="$student->student_name" :rank="$student->rank" :totalscore="$totalScore"/>
    <div class="w-full h-full fixed top-0 left-0 -z-30">
        <img class="w-full h-full object-cover filter contrast-less:" src="{{asset('Teacher/bg3.jpg')}}">
    </div>
    <div class="px-4 lg:px-10 w-full h-[100px] flex items-center">
        <h1 class="font1 text-3xl font-bold text-zinc-800">Games</h1>
    </div>
    <section>
        <div class="px-4 lg:px-10 w-full h-auto">
            <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach ($games as $game)
                <div class="w-full h-[300px] xl:h-[350px] relative rounded-md p-2 hover:-translate-x-1 hover:-translate-y-1 hover:cursor-pointer transition-all duration-200 ease-linear group">
                    <div class="w-full h-full flex justify-between flex-col bg-white rounded-md absolute z-10 p-2">
                        <div class="w-full h-[250px] rounded-md overflow-hidden">
                            <img src="{{$game->game_banner}}" class="w-full h-full object-cover object-top rounded-md group-hover:scale-110 transition-all duration-150 ease-linear">
                        </div>
                        <div class="w-full font1 mt-2 flex flex-col">
                            <p class="text-xl font-semibold text-zinc-800">{{$game->game_title}}</p>
                            <p>{{$game->game_description}}</p>
                            <div class="flex justify-end mt-3">
                                <a href="{{route('play-game', ['game_code' => $game->game_code])}}">
                                    <p class="px-3 py-1 bg-zinc-800 rounded-sm text-zinc-200 kode opacity-0 group-hover:opacity-100 transition-opacity duration-200 ease-linear hover:bg-zinc-200 hover:text-zinc-800">Play Game</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="w-full h-full bg-zinc-500 rounded-md translate-x-1 translate-y-1 absolute">

                    </div>

                </div>
                @endforeach
            </div>
        </div>


    </section>
</body>

@endsection


