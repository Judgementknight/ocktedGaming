<div id="menu" class="h-full w-[100%] bg-white/20 backdrop-blur-lg fixed right-[-100%] transition-all duration-300 ease-in-out z-20">
    <img id="close-menu" onclick="menuDisplay()" class="absolute top-5 left-5 hover:scale-125 transition-all duration-300 ease-in-out" src="{{asset('pfp/cancel.svg')}}"/>
    <div class="flex flex-col justify-center items-center gap-3 w-full h-full">
        <div class="font1 w-auto h-[60px] overflow-hidden side-menu text-6xl text-white hover:cursor-pointer">
            <a href="{{route('ockted')}}"><h1 class="sidemenu-items">HOME</h1>
            <h1 class="sidemenu-items">HOME</h1></a>
        </div>
        <div class="font1 w-auto h-[60px] overflow-hidden side-menu text-6xl text-white hover:cursor-pointer">
            <a href="{{route('leaderboard')}}"><h1 class="sidemenu-items">LEADERBOARD</h1>
            <h1 class="sidemenu-items">LEADERBOARD</h1></a>
        </div>
        <div class="font1 w-auto h-[60px] overflow-hidden side-menu text-6xl text-white hover:cursor-pointer">
            <h1 class="sidemenu-items">HISTORY</h1>
            <h1 class="sidemenu-items">HISTORY</h1>
        </div>
    </div>
</div>
