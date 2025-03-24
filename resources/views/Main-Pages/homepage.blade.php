@extends('Main-Pages.main-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body class="main">
    <x-sidemenu/>
    <x-profile-modal :picture="$combinedData['User Data']['user']['profile_picture'] ?? null" :total="$combinedData['Total Score'] ?? null" :rank="$combinedData['User Data']['user']['rank']" />
        <x-navbar class="xl:px-10" :name="$combinedData['User Data']['user']['ockted_username'] ?? null" :picture="$combinedData['User Data']['user']['profile_picture'] ?? null"/>
        <div class="absolute top-0 left-0 -z-10 w-full h-full ">
            <img class="w-full h-full" src="{{asset('pfp/bg4.png')}}">
        </div>
            <div class="flex flex-col md:flex-row gap-[3%] px-2 sm:px-0">
                <div class="Games Title mt-5 glass w-full lg:w-[65%] h-[50px] font1 flex items-center justify-between px-10 text-2xl text-white tracking-wide">
                    <h1>GAMES</h1>

                    <h1>Total Games:{{$combinedData['Total Games']}}</h1>
                </div>
                <div class="Games Title mt-5 glass w-full md:w-[32%] h-[50px] font1 hidden lg:flex items-center justify-between px-10 md:px-2 text-white tracking-wide">
                    <h1 class="text-2xl">Recent Games Played</h1>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-[3%] px-2 sm:px-0">
                <div class="Games mt-5 glass w-full lg:w-[65%] h-[72vh] overflow-y-scroll font1 px-5 py-5 text-2xl text-white tracking-wide relative flex flex-col gap-5">
                    @if (isset($combinedData['Game Data']) && count($combinedData['Game Data']) > 0)
                        @foreach ($combinedData['Game Data'] as $key=>$game)
                            <div id="small-game-card" class="w-full relative transition-all group duration-200 ease-in h-[200px] md:h-[250px] glass2 p-2 hover:cursor-pointer flex flex-col md:flex-row items-start md:items-center gap-5">
                                <div class="size-12 md:flex hidden group-hover:size-36  transition-all duration-200 ease-in">
                                    <img class="h-full w-full rounded-sm object-cover" src="{{$game['game_banner']}}">
                                    {{-- <div class="absolute top-0 left-0 bg-amber-300 h-10 w-14 transition-opacity duration-200 ease-in opacity-0 group-hover:opacity-100"></div> --}}
                                </div>
                                <div class="flex justify-between items-center w-full ">
                                    <div class="">
                                        <h1>{{$game['game_title']}}</h1>
                                        <h1>{{$game['game_description']}}</h1>
                                    </div>
                                    <div class=" transition-all duration-600 ease-linear opacity-0 group-hover:opacity-90 items-start justify-items-end">
                                        @php
                                        $token = [
                                            'token' => $combinedData['gameToken'] ?? null,
                                            'game_code' => $game['game_code'] ?? null,
                                        ];
                                        $queryString = http_build_query($token);
                                        $gameURL = $game['game_url'] . '?' .$queryString;
                                        @endphp

                                        <a href="{{$gameURL}}">
                                            <button class="py-2 px-3 rounded-md hover:bg-white hover:text-black transition-all duration-200 ease-in-out bg-[#0a0908]">PLAY</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="w-[32%] hidden lg:flex flex-col gap-[3%]">
                    <div class="Games Title glass mt-5 w-full md:w-[100%] h-[40vh] hidden md:flex flex-col gap-3 font1 px-10 md:p-3 text-white tracking-wide overflow-y-scroll">
                        @if (isset($combinedData['Recent Games Played']) && count($combinedData['Recent Games Played']) > 0)
                            @foreach ($combinedData['Recent Games Played'] as $key=>$game )
                                <div class="glass w-full h-[100px] py-1 px-2">
                                    <div class="text-2xl">
                                        <p>{{$game->game_title}}</p>
                                    </div>
                                    <div class="flex items-end justify-end w-full h-[50px]">Scores Earn:<span class="text-green-400">{{$game->score}}</span> </div>
                                </div>
                            @endforeach
                            @else
                            <div class="flex items-center justify-center h-full w-full">
                                <p>No Games Played Yet</p>
                            </div>
                        @endif
                    </div>
                    <div class="h-[30vh] w-full hidden xl:flex justify-end items-end">
                        <div class="h-[50px] flex w-full justify-end items-end">
                            <h1 class="iewduh text-white/70">Copyright 2025 -All Rights Reserved By Iewduh Techz Pvt Limited</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full flex md:hidden h-14">
                <div class="flex items-center justify-center w-full h-full glass">
                    <h1 class="iewduh text-white/70">Copyright 2025 -All Rights Reserved By Iewduh Techz Pvt Limited</h1>
                </div>
            </div>




</body>
<script>
const menu = document.getElementById('menu');
const burger = document.getElementById('burger');

function menuDisplay(){
    console.log('Clicked');
    if(menu.classList.contains('right-[-100%]'))
    {
        menu.classList.add('right-0');
        menu.classList.remove('right-[-100%]')
    }else{
        menu.classList.add('right-[-100%]');
        menu.classList.remove('right-0');
    }
}

const bigGameCard = document.querySelectorAll('#big-game-card');
const smallGameCard = document.querySelectorAll('#small-game-card');

smallGameCard.forEach((card, index) => {
    card.addEventListener('mouseenter', () => {
        console.log("ENTER");
    });
});

smallGameCard.forEach((card, index) => {
    card.addEventListener('mouseleave', () => {
        console.log('leave');
        bigGameCard[index]?.classList.add('hidden');
    });
});

// smallGameCard.forEach(card => {
//     card.addEventListener('mouseleave', () => {
//         console.log('Leave');
//     });
// });

</script>


@endsection
