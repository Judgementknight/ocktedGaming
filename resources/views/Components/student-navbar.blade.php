<div class="w-full h-[80px] border-b-[1px] border-zinc-300 right-0 flex justify-between items-center px-4 lg:px-10 sticky bg-white top-0 z-40">

    <div class="w-[50%] md:w-full items-center  flex">
        <div onclick="toggleStudentProfile()" class="flex lg:hidden w-[40px] h-[40px]  rounded-[50%] hover:border-2 hover:border-[#2A6DF4] transition-all duration-100 hover:cursor-pointer ease-in">
            <img class="w-full h-full rounded-[50%] object-cover" src="{{$picture}}">
        </div>
        <img class="size-12 lg:size-16 hidden lg:flex" src="{{asset('Teacher/icons/books.png')}}">
        <h1 class="font1 hidden lg:flex font-extrabold text-[#2A6DF4] text-3xl">Ockted Gaming</h1>
    </div>
	<div class="w-full flex items-center lg:hidden justify-center ">
		<h1 class="font1 font-extrabold text-[#2A6DF4] text-lg">Ockted Gaming</h1>
	</div>
    <div class="w-full justify-center text-sm font-medium  items-center gap-10 hidden lg:flex text-zinc-500 ">
            {{-- <img class="size-6" src="{{asset('Teacher/icons/dashboard.png')}}"> --}}
            <a href="{{route('view-game')}}">
                <h1 class="hover:cursor-pointer hover:text-[#2A6DF4] transition-all duration-400 ease-linear">Games</h1>
            </a>

            <a href="{{route('welcome')}}">
                <h1 class="hover:cursor-pointer hover:text-[#2A6DF4] transition-all duration-400 ease-linear">Assignment</h1>
            </a>

            <a href="{{route('leaderboard')}}">
                <h1 class="hover:cursor-pointer hover:text-[#2A6DF4] transition-all duration-400 ease-linear">Leaderboard</h1>
            </a>

            {{-- <img class="size-6" src="{{asset('Teacher/icons/add-white.png')}}"> --}}
            {{-- <h1 class="hover:cursor-pointer hover:text-[#2A6DF4] transition-all duration-400 ease-linear">All Assignments</h1> --}}
    </div>
    <div class="w-full hidden lg:flex justify-end ">
        <div onclick="toggleStudentProfile()" class="w-[40px] h-[40px]  rounded-[50%] hover:border-2 hover:border-[#2A6DF4] transition-all duration-100 hover:cursor-pointer ease-in">
            <img class="w-full h-full rounded-[50%] object-cover" src="{{$picture}}">
        </div>
    </div>
    <div class="w-[50%] flex justify-end lg:hidden hover:cursor-pointer  ">
        <img onclick="toggleDisplaySideMenu()" class="size-6" src="{{asset('Teacher/icons/menu.png')}}">
    </div>
</div>

{{-- SIDE NAV --}}
<div id="side-menu-parent" class="w-full h-screen fixed top-0 right-[-100%] bg-black/50 z-40 lg:hidden flex">
    <div id="side-menu-children" class="bg-white z-50 top-0 right-[-100%] w-[80%] h-screen fixed transition-all ease-linear duration-200">
        <div class="flex h-full w-full flex-col justify-between py-4">
            <div class="">
                <header class="p-3 flex justify-between w-full">
                    <h1 class="text-2xl font-bold text-[#2A6DF4]">MENU</h1>
                    <img onclick="closeSideMenu()" src="{{ asset('Teacher/icons/cross.png') }}" class="size-6 bg-[#2A6DF4] hover:cursor-pointer">
                </header>
                <div class="px-3 w-full mt-10">
                    <a href="{{ route('view-game') }}">
                        <div class="w-full flex items-center justify-between group ">
                            <h1 class="font1 text-[#2A6DF4] text-xl font-bold">Games</h1>
                            <div class="w-[30px] h-[30px] bg-[#2A6DF4] rounded-full flex items-center justify-center">
                                <img src="{{ asset('Teacher/icons/arrow.png') }}" class="h-[70%] w-[70%] group-hover:-rotate-[30deg] transition-all ease-linear duration-200">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="px-3 w-full mt-10">
                    <a href="{{ route('leaderboard') }}">
                        <div class="w-full flex items-center justify-between group">
                            <h1 class="font1 text-[#2A6DF4] text-xl font-bold">Leaderboard</h1>
                            <div class="w-[30px] h-[30px] bg-[#2A6DF4] rounded-full flex items-center justify-center">
                                <img src="{{ asset('Teacher/icons/arrow.png') }}" class="h-[70%] w-[70%] group-hover:-rotate-[30deg] transition-all ease-linear duration-200">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="px-3 w-full mt-10">
                    <a href="{{ route('welcome') }}">
                        <div class="w-full flex items-center justify-between group">
                            <h1 class="font1 text-[#2A6DF4] text-xl font-bold">Assignment</h1>
                            <div class=" w-[30px] h-[30px] bg-[#2A6DF4] rounded-full flex items-center justify-center">
                                <img src="{{ asset('Teacher/icons/arrow.png') }}" class="h-[70%] w-[70%] group-hover:-rotate-[30deg] transition-all ease-linear duration-200">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="px-3 font1">
                <h1 class="text-3xl text-zinc-700 font-bold">OCKTED GAMING</h1>
            </div>
        </div>

    </div>



</div>

<script>

    const sideMenu1 = document.getElementById('side-menu-parent');
    const sideMenu2 = document.getElementById('side-menu-children');

    function toggleDisplaySideMenu() {
        sideMenu1.classList.add('right-0');
        sideMenu2.classList.add('right-0');

        sideMenu1.classList.remove('right-[-100%]');
        sideMenu2.classList.remove('right-[-100%]');

        const isOpen = sideMenu1.classList.contains('right-0');
        document.body.style.overflow = isOpen ? 'hidden' : 'auto';
    }

    function closeSideMenu() {
        sideMenu1.classList.add('right-[-100%]');
        sideMenu2.classList.add('right-[-100%]');

        sideMenu1.classList.remove('right-0');
        sideMenu2.classList.remove('right-0');

        const isClose = sideMenu1.classList.contains('right-[-100%]');
        document.body.style.overflow = isClose ? 'auto' : 'hidden';
    }
</script>
