<div class="h-[600px] w-[70px] left-10 absolute flex items-center justify-center">

    <div class="h-[500px] w-[70px] bg-black/50 round translate-x-2 translate-y-1 absolute"></div>
    <div class="h-[500px] w-[70px] bg-white round flex flex-col items-center justify-between border-[1px] border-black/50 px-1 py-2 absolute z-20">
        <div class="kode text-center ">
            Table Tools
        </div>
        <div class="w-[60px] h-[50px] rounded-[5px] kode flex items-center justify-center relative group hover:cursor-pointer">
            <form method="GET" action="{{route('student-query')}}">
                <input type="hidden" name="sort_by_name" value="name">
                <input type="hidden" name="sort_order" value="{{ request('sort_order') === 'asc' ? 'desc' : 'asc' }}">
                <button>
                    <img class="h-full w-full active:scale-90 animate" src="{{asset('dashboard/icons/alphabetorder.png')}}">
                </button>
            </form>
            <div class="absolute w-[100px] bggray h-[50px] top-[-40px] round text-center opacity-0 group-hover:opacity-100 animate flex items-center justify-center">
                <p>Sort By Names</p>
            </div>
        </div>
        <div class="w-[60px] h-[50px]  rounded-[5px] kode flex items-center justify-center relative group hover:cursor-pointer">
            <form method="GET" action="{{route('student-query')}}">
                <input type="hidden" name="status" value="{{request('status') === 'active' ? 'inactive' : 'active'}}">
                <button>
                    <img class="h-full w-full active:scale-90 animate" src="{{asset('dashboard/icons/active.png')}}">
                </button>
            </form>
            <div class="absolute w-auto h-[50px] bggray top-[-40px] z-50 left-[-40px] round text-center opacity-0 group-hover:opacity-100 animate flex items-center justify-center">
                <p class="text-sm">Toggle Between Active/Inactive</p>
            </div>
        </div>
        <div class="w-[60px] h-[50px]  rounded-[5px] kode flex items-center justify-center relative group hover:cursor-pointer">
            <form action="{{route('student-query')}}" method="GET">
                <input type="hidden" name="score" value="{{request('score') === 'high' ? 'low' : 'high'}}">
                <button>
                    <img class="h-full w-full active:scale-90 animate" src="{{asset('dashboard/icons/score.png')}}">
                </button>
            </form>
            <div class="absolute w-[100px] h-[50px] bggray top-[-40px] right-0 round text-center opacity-0 group-hover:opacity-100 animate flex items-center justify-center">
                <p class="text-sm">Order By Score</p>
            </div>
        </div>
        <div class="w-[60px] h-[50px]  rounded-[5px] kode flex items-center justify-center relative group hover:cursor-pointer">
            <form method="GET" action="{{route('student-query')}}">
                <input type="hidden" name="games" value="{{request('games') === 'top' ? 'bottom' : 'top'}}">
                <button>
                    <img class="h-full w-full active:scale-90 animate" src="{{asset('dashboard/icons/sorting.png')}}">
                </button>
            </form>
            <div class="absolute w-[100px] h-[70px] bggray z-20 top-[-60px] right-4 round text-center opacity-0 group-hover:opacity-100 animate flex items-center justify-center">
                <p class="text-sm">Order By Games Played</p>
            </div>
        </div>
        <div class="w-[60px] h-[50px]  rounded-[5px] kode flex items-center justify-center relative group hover:cursor-pointer">
            <form method="GET" action="{{route('student-query')}}">
                <input type="hidden" name="games" value="{{request('games') === 'top' ? 'bottom' : 'top'}}">
                <button>
                    <img class="h-full w-full active:scale-90 animate" src="{{asset('dashboard/icons/reset.png')}}">
                </button>
            </form>
            <div class="absolute w-[100px] h-[70px] bggray top-[40px] right-0 round text-center opacity-0 group-hover:opacity-100 animate flex items-center justify-center">
                <p class="text-sm">Reset Table</p>
            </div>
        </div>

    </div>
</div>
