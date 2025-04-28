<div class="w-full h-[80px] border-b-[1px] border-zinc-300 right-0 flex justify-center lg:justify-between items-center px-5 lg:px-10 sticky bg-white top-0 z-40">
    <div class="w-full flex items-center">
        <img class="size-16" src="{{asset('Teacher/icons/books.png')}}">
        <h1 class="font1 font-extrabold text-[#2A6DF4] text-3xl">OcktedTeach</h1>
    </div>
    <div class="w-full justify-end items-center gap-3 font1 hidden lg:flex">
        <div class="w-[8.5rem] h-[3rem] rounded-[5px] items-center bg-[#2A6DF4] flex px-3 justify-between ">
            <img class="size-6" src="{{asset('Teacher/icons/dashboard.png')}}">
            <h1 class="font-normal text-white">Dashboard</h1>
        </div>

        <div class="w-[12rem] h-[3rem] rounded-[5px]  items-center flex bg-[#4BE79E] px-3 justify-between ">
            <img class="size-6" src="{{asset('Teacher/icons/add-white.png')}}">
            <h1 class="text-black font-bold">Create Gameroom</h1>
        </div>

        <div class="w-[8rem] h-[3rem]  items-center px-3 flex  gap-1 ">
            <img class="size-6" src="{{asset('Teacher/icons/teacher.png')}}">
            <h1 class="font1 font-medium">Teacher</h1>
        </div>
    </div>
    {{-- <div id="open-side-menu" class="flex lg:hidden ">
        <img class="size-6" src="{{asset('Teacher/icons/menu.png')}}">
    </div> --}}
</div>

 {{-- SIDEMENU --}}
 <div id="side-menu-container" class="w-full h-full bg-black/25 fixed z-50 top-0 -right-[100%]">
     <div id="side-menu" class="w-[80%] bg-white -right-[100%] fixed h-full transition-all duration-200 ease-linear">
        <div class="flex h-full w-full flex-col justify-between py-4">
            <div class="">
                <header class="p-3 flex justify-between w-full">
                    <h1 class="text-2xl font-bold text-[#2A6DF4]">MENU</h1>
                    <img onclick="closeSideMenu()" src="{{ asset('Teacher/icons/cross.png') }}" class="size-6 bg-[#2A6DF4] hover:cursor-pointer">
                </header>
                <div class="px-3 w-full mt-10">
                    <a href="{{ route('view-game') }}">
                        <div class="w-full flex items-center justify-between group ">
                            <h1 class="font1 text-[#2A6DF4] text-xl font-bold">Overview</h1>
                            <div class="w-[30px] h-[30px] bg-[#2A6DF4] rounded-full flex items-center justify-center">
                                <img src="{{ asset('Teacher/icons/arrow.png') }}" class="h-[70%] w-[70%] group-hover:-rotate-[30deg] transition-all ease-linear duration-200">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="px-3 w-full mt-10">
                    <a href="{{ route('leaderboard') }}">
                        <div class="w-full flex items-center justify-between group">
                            <h1 class="font1 text-[#2A6DF4] text-xl font-bold">Students</h1>
                            <div class="w-[30px] h-[30px] bg-[#2A6DF4] rounded-full flex items-center justify-center">
                                <img src="{{ asset('Teacher/icons/arrow.png') }}" class="h-[70%] w-[70%] group-hover:-rotate-[30deg] transition-all ease-linear duration-200">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="px-3 w-full mt-10">
                    <a href="{{ route('welcome') }}">
                        <div class="w-full flex items-center justify-between group">
                            <h1 class="font1 text-[#2A6DF4] text-xl font-bold">Gameroom</h1>
                            <div class=" w-[30px] h-[30px] bg-[#2A6DF4] rounded-full flex items-center justify-center">
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
        {{-- <div class="w-full flex justify-center items-center">
            <img id="overview-btn" class="size-12" src="{{asset('Teacher/icons/overview.png')}}">
        </div>

        <div class="w-full flex justify-center items-center">
            <img id="student-btn" class="size-12" src="{{asset('Teacher/icons/students.png')}}">
        </div>

        <div class="w-full flex justify-center items-center">
            <img id="gameroom-btn" class="size-12" src="{{asset('Teacher/icons/game.png')}}">
        </div>

        <div class="w-full flex justify-center items-center">
            <img id="add-game-assignment-btn" class="size-12" src="{{asset('Teacher/icons/game.png')}}">
        </div>

        <div class="w-full flex justify-center items-center">
            <img id="assignment-btn" class="size-12" src="{{asset('Teacher/icons/assignmentmenu.png')}}">
        </div> --}}

    </div>
 </div>
<script>
    const openMenuButton = document.getElementById('open-side-menu');
    const sidemenu = document.getElementById('side-menu');
    const sidemenuContainer = document.getElementById('side-menu-container');


    openMenuButton.addEventListener('click', function() {
        console.log('click');
        sidemenu.classList.remove('-right-[100%]');
        sidemenu.classList.add('right-0');
        sidemenuContainer.classList.remove('-right-[100%]');
        sidemenuContainer.classList.add('right-0');
    });

    // closeMenuButton.addEventListener('click', function() {
    //     sidemenu.classList.remove('right-0');
    //     sidemenu.classList.add('-right-[100%]');
    // });

    function closeSideMenu(){
        sidemenu.classList.add('-right-[100%]');
        sidemenu.classList.remove('right-0');
        sidemenuContainer.classList.add('-right-[100%]');
        sidemenuContainer.classList.remove('right-0');
    }

</script>
