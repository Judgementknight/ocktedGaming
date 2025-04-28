<div class="w-full h-[80px] border-b-[1px] border-zinc-300 right-0 flex justify-center lg:justify-between items-center px-4 lg:px-10 sticky bg-zinc-100 top-0 z-40">
    <div class="w-full flex items-center">
        <img class="size-16" src="{{asset('Teacher/icons/books.png')}}">
        <h1 class="font1 font-extrabold text-[#2A6DF4] text-3xl">Ockted Gaming</h1>
    </div>
    {{-- <div class="w-full justify-center text-sm font-medium  items-center gap-10 hidden lg:flex text-zinc-500 ">
            <a href="{{route('view-game')}}">
                <h1 class="hover:cursor-pointer hover:text-[#2A6DF4] transition-all duration-400 ease-linear">Games</h1>
            </a>

            <a href="{{route('welcome')}}">
                <h1 class="hover:cursor-pointer hover:text-[#2A6DF4] transition-all duration-400 ease-linear">Dashboard</h1>
            </a>

            <h1 class="hover:cursor-pointer hover:text-[#2A6DF4] transition-all duration-400 ease-linear">All Assignments</h1>
    </div> --}}
    <div class="w-full hidden lg:flex justify-end ">
        {{-- <div class="w-[40px] h-[40px] bg-red-300 rounded-[50%] hover:border-2 hover:border-[#2A6DF4] transition-all duration-100 hover:cursor-pointer ease-in">
            <img class="w-full h-full rounded-[50%] object-cover" src="{{$picture}}">
        </div> --}}
    </div>
    <div class="flex lg:hidden ">
        <img class="size-6" src="{{asset('Teacher/icons/menu.png')}}">
    </div>
</div>
