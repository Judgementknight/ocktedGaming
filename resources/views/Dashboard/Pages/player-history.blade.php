@extends('Dashboard.dash-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body class="h-auto w-full bg-[#E8F0F1] overflow-x-hidden">
        <x-dash-navbar />
        <x-table-tools3 />
        <x-active-status-user />
        <x-toast />
        <x-confirm-delete />
        <div class="main w-full flex items-start justify-center">
            <div class="main2 w-[1200px] bg-[#E8F0F1] round border-[1px] border-black/35 relative">
                <div class="w-full h-full round bg-[#E8F0F1] absolute z-50">
                    <div class="w-full h-[80px] border-b-[1px] border-black/50 flex items-center justify-between px-5">
                        <div class="anton w-[30%] ">
                            <h1 class="text-4xl">PLAYERS HISTORY</h1>
                        </div>
                        <form action="{{route('player-history')}}" method="GET">
                            
                            <div class="w-[300px] lg:w-[500px] h-[50px] relative">
                                <div class="w-full h-full bg-[#D9D9D9] round absolute z-50 flex items-center px-2">
                                    <input name="search" placeholder="Search Player..." value="{{request('search')}}" class="border-b-[1px] w-full border-black bg-[#D9D9D9]  focus:outline-none">
                                    <div class="">
                                        <button class="kode">Search</button>
                                    </div>
                                </div>
                                <div class="w-full h-full bg-black round translate-x-1 translate-y-1">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="w-90vw h-[64vh] round bg-[#E8F0F1] overflow-x-scroll overflow-y-scroll p-2 relative z-10 flex flex-col gap-[10px]">
                        <div class="flex flex-col">
                            <div class="text-xl">
                                <div class="min-w-full inline-block align-middle">
                                    <div class="overflow-hidden border rounded-lg border-gray-300">
                                        <table class="w-full kode  rounded-xl">
                                            <thead class="bg-white sticky top-0">
                                                <tr class="bg-white sticky top-0">
                                                    <th scope="col" class="sticky top-0 p-5 whitespace-nowrap text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> User ID </th>
                                                    <th scope="col" class="sticky top-0p-5 whitespace-nowrap text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Player Name </th>
                                                    <th scope="col" class="sticky top-0 p-5 whitespace-nowrap text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Game Played </th>
                                                    <th scope="col" class="sticky top-0 p-5 whitespace-nowrap text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Score Earn </th>
                                                    <th scope="col" class="sticky top-0 p-5 whitespace-nowrap text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Played On </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-300">
                                                @foreach ($players as $player )
                                                    <tr class="">
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 "> {{$player->user_id}}</td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 "> {{$player->username}}</td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 "> {{$player->game_code}}</td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 "> {{$player->score}}</td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> {{$player->created_at}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                            </div>
                            </div>
                    </div>
                    {{ $players->links('vendor.pagination.tailwind') }}


                </div>
                <div class="w-full h-full round bg-black/50 translate-x-2 translate-y-2 absolute top-0 -z-10">

                </div>
            </div>
            <x-footer-nav/>
        </div>
</body>


@endsection
