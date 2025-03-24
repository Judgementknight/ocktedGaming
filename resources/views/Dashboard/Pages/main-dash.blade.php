@extends('Dashboard.dash-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')

<body class="h-auto w-full bg-[#E8F0F1]">
    <x-toast/>
        <x-dash-navbar />
        <div class="main2 px-[20px] xl:px-[88px] pt-4 flex flex-col">

            <div class="main  w-full flex lg:flex-row xl:flex-row flex-col gap-[47px]">
                <div class="xl:w-[700px] w-full lg:w-[500px] round  lg:h-[600px] h-[400px] gap-[47px] flex xl:flex-row flex-row lg:flex-col relative">
                        <div class="lg:h-full overflow-hidden h-[200px] round w-full xl:w-[47%] relative flex items-center justify-center group hover:cursor-pointer">
                            <a href="{{route('player')}}"><h1 class="anton text-white text-3xl lg:text-6xl opacity-0 transition-all duration-200 ease-in group-hover:opacity-100">PLAYERS</h1></a>
                            <img class="group-hover:scale-125 w-full h-full absolute object-cover -z-10 round brightness-90 group-hover:brightness-50 transition-all duration-200 ease-in" src="{{asset('dashboard/game2.jpg')}}">
                        </div>

                    <div class="lg:h-full h-[200px] overflow-hidden round  w-full xl:w-[47%] relative flex items-center justify-center group hover:cursor-pointer">
                        <a href="{{route('game')}}"><h1 class="anton text-white text-3xl lg:text-6xl opacity-0 transition-all duration-200 ease-in group-hover:opacity-100">GAMES</h1></a>
                        <img class="group-hover:scale-125 w-full h-full absolute object-cover -z-10 round brightness-90 group-hover:brightness-50 transition-all duration-200 ease-in" src="{{asset('dashboard/games.jpg')}}">
                    </div>
                </div>
                <div class="lg:w-[700px]  relative h-[600px] round flex items-center justify-center flex-col gap-[30px]">
                    <div class="w-full h-[300px] border-[1px] border-black/20 round relative group hover:cursor-pointer transition-all duration-200 ease-in hover:scale-95">
                        <img class="w-full h-full round absolute object-cover player" src="{{asset('dashboard/player.jpg')}}">

                        <div class="w-full h-[300px] round bg-black/50 absolute transition-all duration-200 ease-in translate-x-2 translate-y-1 -z-10">

                        </div>
                        <div class="w-full h-[300px] round bg-[#E8F0F1] p-3 relative">
                            <div class="flex items-center ">

                                <div class="w-full ">
                                    <h1 class="anton text-black/80  text-3xl  lg:text-7xl"> Total Players : </h1>
                                </div>
                                <div class="w-[30%] h-[100px] flex items-center justify-center">
                                    <div class="w-[100px] h-full  round relative">
                                        <div class=" absolute w-full h-full z-30 bg-[#D9D9D9] border-[1px] border-black/50 round flex items-center justify-center">
                                            <h1 class="anton text-6xl text-[#5ae4a8]">87</h1>
                                        </div>

                                        <div class="absolute w-full h-full bg-black round translate-x-1 translate-y-1">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="w-full h-[150px] flex items-end relative ">
                                <div class="w-full">
                                    <h1 class="text-black/80 text-4xl anton">Active Players : (FINNA DO WEBSOCKET HERE)</h1>
                                </div>
                                <div class="w-[20%]">
                                    <h1 class="anton text-4xl text-[#5ae4a8]">13</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full h-[300px] border-[1px] border-black/20 round relative z-50 group animate hover:scale-90 hover:cursor-pointer">
                        <div class="w-full h-full round bg-black/50 absolute translate-x-2 translate-y-1 -z-10">

                        </div>
                        <div class="w-full h-full round bg-[#E8F0F1] p-3 relative">
                            <div class="flex items-center flex-col w-full h-full ">
                                <div class="w-full h-[50px] absolute left-5">
                                    <h1 class="anton text-black/80 text-3xl  lg:text-5xl"> STATS</h1>
                                </div>
                                <div class="w-full h-full flex items-center">
                                    <img class="w-full h-full object-cover" src="{{asset('dashboard/chart.jpg')}}">
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="h-[200px] mt-5  w-full flex justify-between items-center">
                <div class="kode">
                    <h1 >PRAYAG EDU</h1>
                </div>
                <div class="kode">
                    Add Games
                    Analytics
                </div>
            </div>
        </div>
        <x-footer-nav class=""/>
</body>


@endsection
