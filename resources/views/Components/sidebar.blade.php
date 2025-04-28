<!-- Sidebar -->
<div id="sidebar" class="w-[10vh] h-[100vh] bgnavy hidden flex-col items-center justify-between py-10 transition-[width] duration-300 ease-linear z-[99]">
    <!-- Logo -->
    <div id="circle" class="w-[50px] h-[50px] bgteal rounded-[50%] flex items-center justify-center">
      <p class="text-zinc-200 text-md">O.G</p>
    </div>

    <!-- Navigation Items -->
    <div class="flex flex-col gap-4">
      <!-- Repeatable nav items -->
      <a href="{{route('dashboard')}}">
          <div class="nav-box w-[50px] h-[50px] flex items-center justify-center rounded-lg hover:bg-[#273049] relative hover:cursor-pointer">
            <img class="w-[50%] h-[50%]" src="{{ asset('dash/dash.png') }}">
            <div class="text-zinc-200 text-sm px-2 nav-title transition-all duration-200 ease-linear opacity-0 pointer-events-none w-auto h-[30px] bgnavy absolute left-10 sm:left-16 rounded-md -bottom-2 items-center justify-center flex z-10">
              Dashboard
            </div>
          </div>
      </a>

      <a href="{{route('student-details')}}">
          <div class="nav-box w-[50px] h-[50px] flex items-center justify-center rounded-lg hover:bg-[#273049] relative hover:cursor-pointer">
            <img class="w-[50%] h-[50%]" src="{{ asset('dash/students.png') }}">
            <div class="text-zinc-200 text-sm px-2 nav-title transition-all duration-200 ease-linear opacity-0 pointer-events-none w-auto h-[30px] bgnavy absolute left-10 sm:left-16 rounded-md -bottom-2 items-center justify-center flex z-10">
              Students
            </div>
          </div>
      </a>

      <a href="{{route('teacher-details')}}">
          <div class="nav-box w-[50px] h-[50px] flex items-center justify-center rounded-lg hover:bg-[#273049] relative hover:cursor-pointer">
            <img class="w-[50%] h-[50%]" src="{{ asset('dash/teacher.png') }}">
            <div class="text-zinc-200 text-sm px-2 nav-title transition-all duration-200 ease-linear opacity-0 pointer-events-none w-auto h-[30px] bgnavy absolute left-10 sm:left-16 rounded-md -bottom-2 items-center justify-center flex z-20">
              Teachers
            </div>
          </div>
      </a>

      <a href="{{route('games-details')}}">
          <div class="nav-box w-[50px] h-[50px] flex items-center justify-center rounded-lg hover:bg-[#273049] relative hover:cursor-pointer">
            <img class="w-[50%] h-[50%]" src="{{ asset('dash/games.png') }}">
            <div class="text-zinc-200 text-sm px-2 nav-title transition-all duration-200 ease-linear opacity-0 pointer-events-none w-auto h-[30px] bgnavy absolute left-10 sm:left-16 rounded-md -bottom-2 items-center justify-center flex z-10">
              Games
            </div>
          </div>
      </a>

      {{-- <a href="{{route('player-history')}}">
          <div class="nav-box w-[50px] h-[50px] flex items-center justify-center rounded-lg hover:bg-[#273049] relative hover:cursor-pointer">
            <img class="w-[50%] h-[50%]" src="{{ asset('dash/gps.png') }}">
            <div class="text-zinc-200 text-sm px-2 nav-title transition-all duration-200 ease-linear opacity-0 pointer-events-none w-auto h-[30px] bgnavy absolute left-10 sm:left-16 rounded-md -bottom-2 items-center justify-center flex z-10">
              GPS
            </div>
          </div>
      </a> --}}

    </div>

    <!-- Logout -->
    <div>
        <div class="w-[50px] h-[50px] flex items-center justify-center rounded-lg hover:bg-[#273049] relative">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center justify-center">
                    <img class="w-[50%] h-[50%]" src="{{ asset('dash/logout.png') }}">
                </button>
            </form>
            </div>
    </div>
  </div>

  <!-- Top Nav -->
  <div id="top-nav" class="sm:hidden w-full h-[0vh] bgnavy transition-all duration-300 ease-linear flex items-center justify-end px-6">
    <div class="">
        <img src="{{asset('dash/menu.png')}}" class="size-6 hover:cursor-pointer">
    </div>
  </div>

  <!-- Script -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const boxes = document.querySelectorAll('.nav-box');
      const sidebar = document.getElementById('sidebar');
      const topNav = document.getElementById('top-nav');

      // Hover effect for nav titles
      boxes.forEach(box => {
        const title = box.querySelector('.nav-title');

        box.addEventListener('mouseenter', () => {
            console.log("Hovering:", title);
            title.classList.add('opacity-100', 'pointer-events-auto');
            title.classList.remove('opacity-0', 'pointer-events-none');
        });

        box.addEventListener('mouseleave', () => {
        title.classList.remove('opacity-100', 'pointer-events-auto');
        title.classList.add('opacity-0', 'pointer-events-none');
        });
      });

      // Resize event for sidebar and top-nav
      const handleResize = () => {
        const width = window.innerWidth;
        console.log('width', width);

        if (width < 640) {
            topNav.classList.remove('hidden');
            topNav.classList.add('flex');
            sidebar.classList.add('w-[0vh]');
            sidebar.classList.remove('w-[10vh]');
            setTimeout(() => {

                sidebar.classList.add('hidden');
                sidebar.classList.remove('flex');
            }, 200);


            setTimeout(() => {
                topNav.classList.remove('h-[0vh]');
                topNav.classList.add('h-[10vh]');
            },200)
        } else {

            sidebar.classList.remove('hidden');
            sidebar.classList.add('flex');
            topNav.classList.add('h-[0vh]');
            topNav.classList.remove('h-[10vh]');

            setTimeout(() => {
                sidebar.classList.add('w-[10vh]');
                sidebar.classList.remove('w-[0vh]');
            },200)

            setTimeout(() => {
                topNav.classList.remove('flex');
                topNav.classList.add('hidden');
            },200)
        }
      };

      window.addEventListener('resize', handleResize);
      handleResize(); // Trigger on page load
    });
  </script>
