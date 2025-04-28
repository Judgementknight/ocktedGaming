<div class=" w-full lg:w-[600px] h-[50px] fixed bottom-2 left-[50%] translate-x-[-50%] flex items-center justify-center z-50">
    <div class="bg-gray-100 w-[500px] h-[50px] round px-3 flex items-center justify-between ">
        <div class="size-12 relative hover:scale-105 transition-all group duration-200 ease-in hover:cursor-pointer">
            <div class="absolute bg-[#c99ea7] w-[50px] h-[30px] top-[-20px] round flex justify-center items-center opacity-0 group-hover:opacity-100 animate">
                <p class="kode">Home</p>
            </div>
            <a href="{{route('dashboard')}}"><img class="h-full w-full active:scale-75 animate" src="{{asset('dashboard/icons/home2.png')}}"></a>
        </div>
        <div class="size-12 relative hover:scale-105 transition-all group duration-200 ease-in hover:cursor-pointer">
            <div class="absolute bg-[#f69272] w-[100px] h-auto top-[-20px] round flex justify-center items-center opacity-0 group-hover:opacity-100 animate">
                <p class="kode">Add Games</p>
            </div>
            <a href="{{route('AddGames')}}"><img class="h-full w-full active:scale-75 animate" src="{{asset('dashboard/icons/add.png')}}"></a>
        </div>
        <div class="size-12 relative hover:scale-105 transition-all group duration-200 ease-in hover:cursor-pointer">
            <div class="absolute bg-[#127274] w-[150px] h-[30px] top-[-20px] round flex justify-center items-center opacity-0 group-hover:opacity-100 animate">
                <p class="kode">View Game List</p>
            </div>
            <a href="{{route('game')}}"><img class="h-full w-full " src="{{asset('dashboard/icons/game.png')}}"></a>
        </div>
        <div class="size-12 relative hover:scale-105 transition-all group duration-200 ease-in hover:cursor-pointer">
            <div class="absolute bg-[#2ec4b6] w-[90px] h-[30px] top-[-20px] round flex justify-center items-center opacity-0 group-hover:opacity-100 animate">
                <p class="kode">Students</p>
            </div>
            <a href="{{route('student-details')}}"><img class="h-full w-full " src="{{asset('dashboard/icons/players.png')}}"></a>
        </div>
        <div class="size-12 relative hover:scale-105 transition-all group duration-200 ease-in hover:cursor-pointer">
            <div class="absolute bg-[#72caaf] w-auto h-auto p-1 top-[-20px] round flex justify-center items-center opacity-0 group-hover:opacity-100 animate">
                <p class="kode whitespace-nowrap">Player History</p>
            </div>
            <a href="{{route('player-history')}}"><img class="h-full w-full " src="{{asset('dashboard/icons/history.png')}}"></a>
        </div>
        <div class="size-12 relative hover:scale-105 transition-all group duration-200 ease-in hover:cursor-pointer">
            <div class="absolute bg-[#c5e4fa] w-[100px] h-[30px] top-[-20px] round flex justify-center items-center opacity-0 group-hover:opacity-100 animate">
                <p class="kode">Analytics</p>
            </div>
            <img class="h-full w-full " src="{{asset('dashboard/icons/stats.png')}}">
        </div>
    </div>
</div>
