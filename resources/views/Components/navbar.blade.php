{{-- <x-profile-modal /> --}}

<nav class="w-full h-[100px] font1 text-white bg-white/10 backdrop-blur-lg flex justify-between items-center px-2 md:px-10 rounded-[10px] mt-5">
    <div class="left-nav">
        <h1 class="text-4xl">OCKTED GAMING</h1>
    </div>
    <div class="mid-nav justify-between items-center gap-7 text-xl hidden md:flex">
        <div class="nav-head2 overflow-hidden w-auto h-[30px]">
            <a href="{{route('ockted')}}"><h1 class="nav-items2 nav-items">Home</h1>
            <h1 class="nav-items2 nav-items">Home</h1></a>
        </div>
        <div class="nav-head2 overflow-hidden w-auto h-[30px]">
            <a href="{{route('history')}}"><h1 class="nav-items2 nav-items">History</h1>
            <h1 class="nav-items2 nav-items">History</h1></a>
        </div>
        <div class="nav-head2 overflow-hidden w-auto h-[30px] ">
            <a href="{{route('leaderboard')}}"><h1 class="nav-items2 nav-items">Leaderboard</h1>
            <h1 class="nav-items2 nav-items">Leaderboard</h1></a>
        </div>
    </div>
    <div class="right-nav rounded-[5px] bg-[#9FCAED]/10 backdrop-blur-lg p-2 flex items-center gap-5 ">
        <div class="flex md:hidden">
            {{-- <img width="50" height="50" src="https://img.icons8.com/fluency/50/menu.png" alt="menu"/> --}}
            <img id="burger" class="hover:scale-110 hover:cursor-pointer" onclick="menuDisplay()" src="{{asset('pfp/menu.svg')}}"/>
        </div>
        <div class="hidden md:flex flex-col">
            <p class="text-[1.3vw] tracking-wide">Welcome,</p>
            <p class="text-[1.3vw] tracking-wide">{{$name}}</p>
            {{-- <p class="text-[1.3vw] tracking-wide">{{$token}}</p> --}}

        </div>
        <div class="size-12 relative hover:border-2 hover:cursor-pointer active:scale-75 border-white rounded-[5px] hover:rotate-12 hover:p-1 transition-all duration-300 ease-in-out hover:bg-white/50">
            <img onclick="openProfileModal()" class="w-full h-full rounded-[5px] hover:rotate-6 object-cover " src="{{$picture}}"></img>
        </div>
    </div>
</nav>

<script>

</script>

