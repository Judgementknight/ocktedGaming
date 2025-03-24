@extends('Main-Pages.main-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body class="main2 w-full min-h-screen md:h-full flex justify-center items-center overflow-x-hidden relative">
    <x-sidemenu/>
    <x-profile-modal :picture="$data['User Data']['user']['profile_picture']" :total="$data['User Data']['totalScore']" />
    <div class="absolute top-0 left-0 -z-10 w-full h-full ">
        <img class="w-full h-full" src="{{asset('pfp/bg4.png')}}">
    </div>
    <div class="absolute left-5 bottom-5 hidden lg:flex z-20 hover:scale-125 transition-all duration-200 ease-linear hover:cursor-pointer active:scale-75">
        <a href="{{route('ockted')}}">
            <img class="" src="{{asset('pfp/backicon.png')}}">
        </a>
    </div>
    <x-navbar :name="$data['User Data']['user']['username']" :picture="$data['User Data']['user']['profile_picture']"/>

    <div class="w-full h-auto lg:h-[81vh] mt-5 flex justify-center items-center relative">

        <div class="w-[100%] sm:w-[100%] md:w-[100%] lg:w-[100%] h-full p-3 relative">
            <div class="flex items-center w-full h-[50px] glass justify-center relative">
                <div class="absolute left-2 lg:hidden hover:scale-125 transition-all duration-200 ease-linear hover:cursor-pointer active:scale-75 size-8">
                    <a href="{{route('ockted')}}"><img class="w-full h-full" src="{{asset('pfp/backicon.png')}}"></a>
                </div>
                <h1 class="font1 text-3xl text-white">History</h1>
            </div>
            <div class="font1 text-2xl text-white mt-5 w-full h-auto lg:h-[50vh] glass relative rounded-lg flex flex-col items-center gap-2 justify-center md:grid md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 p-3">
                @if (isset($data['leaderboard']) && count($data['leaderboard']) > 0)
                    @foreach ($data['leaderboard'] as $key=>$score)
                    <div class="lg:w-full xl:w-[370px] w-full h-[60px] flex items-center glass gap-5 p-2">
                        <div class="font1">
                            <h1>{{$key + 1}}</h1>
                        </div>
                        <div class="flex items-center w-full justify-between">
                            <div class="size-12 relative ">
                                <img class="w-full h-full rounded-md object-cover" src="{{$score['profile_picture']}}">
                            </div>
                            <div class="text-[1.15rem] md:text-2xl">
                                <h1>{{$score['username']}} </h1>
                            </div>
                            <div class="text-sm md:text-lg">
                                <h1>Total Score: <span class=" text-green-400">{{$score['total_score']}}</span></h1>
                            </div>
                        </div>
                    </div>

                    @endforeach

                @endif


            </div>


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

    </script>


@endsection
