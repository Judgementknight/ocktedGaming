<div class="h-[600px] w-[70px] left-10 absolute flex items-center justify-center">

    <div class="h-[400px] w-[70px] bg-black/50 round translate-x-2 translate-y-1 absolute"></div>
    <div class="h-[400px] w-[70px] bg-white round flex flex-col items-center justify-between border-[1px] border-black/50 px-1 py-2 absolute z-[999]">
        <div class="kode text-center ">
            Table Tools
        </div>
        <div class="w-[60px] h-[50px] rounded-[5px] kode flex items-center justify-center relative group hover:cursor-pointer">
            <form method="GET" action="{{route('player-history')}}">
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
            <form action="{{route('player-history')}}" method="GET">
                <input type="hidden" name="user_id" value="{{request('user_id') === 'high' ? 'low' : 'high'}}">
                <button>
                    <img class="h-full w-full active:scale-90 animate" src="{{asset('dashboard/icons/sorting.png')}}">
                </button>
            </form>
            <div class="absolute w-[100px] h-[50px] bggray top-[-40px] right-0 round text-center opacity-0 group-hover:opacity-100 animate flex items-center justify-center">
                <p class="text-sm">Sort By User ID</p>
            </div>
        </div>

        <div class="w-[60px] h-[50px] rounded-[5px] kode flex items-center justify-center relative group hover:cursor-pointer z-[999]">
            <form action="{{ route('player-history') }}" method="GET" id="filterForm">
                <button type="submit">
                    <img class="h-full w-full active:scale-90 animate" src="{{ asset('dashboard/icons/date.png') }}">
                </button>

                <!-- Date Filter Dropdown (Hidden by Default, Shows on Hover) -->
                <div class="absolute w-auto h-auto bg-gray-200 top-[-40px] right-[-170%] rounded text-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center z-[999] p-2">
                    <select name="date_filter" class="border p-2 rounded" onchange="document.getElementById('filterForm').submit();">
                        <option value="">Filter by Date</option>
                        <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                        <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                    </select>
                </div>
            </form>
        </div>
        {{-- <div class="w-[60px] h-[50px]  rounded-[5px] kode flex items-center justify-center relative group hover:cursor-pointer">
            <form method="GET" action="{{route('player-history')}}">
                <input type="hidden" name="games" value="{{request('games') === 'top' ? 'bottom' : 'top'}}">
                <button>
                    <img class="h-full w-full active:scale-90 animate" src="{{asset('dashboard/icons/sorting.png')}}">
                </button>
            </form>
            <div class="absolute w-[100px] h-[70px] bggray z-20 top-[-60px] right-4 round text-center opacity-0 group-hover:opacity-100 animate flex items-center justify-center">
                <p class="text-sm">Order By Games Played</p>
            </div>
        </div> --}}
        <div class="w-[60px] h-[50px]  rounded-[5px] kode flex items-center justify-center relative group hover:cursor-pointer">
            <form method="GET" action="{{route('player-history')}}">
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
