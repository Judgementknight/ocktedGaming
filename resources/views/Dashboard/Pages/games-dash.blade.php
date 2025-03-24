@extends('Dashboard.dash-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body class="h-auto w-full bg-[#E8F0F1] overflow-x-hidden">
        <x-dash-navbar />
        <x-table-tools2 />
        <x-active-status-games/>
        <x-toast />
        <div class="main w-full flex items-start justify-center">
            <div class="main2 w-[1200px] bg-[#E8F0F1] round border-[1px] border-black/35 relative">
                <div class="w-full h-full round bg-[#E8F0F1] absolute z-50">
                    <div class="w-full h-[80px] border-b-[1px] border-black/50 flex items-center justify-between px-5">
                        <div class="anton w-full">
                            <h1 class="text-4xl">Games</h1>
                        </div>
                        <form action="{{route('game')}}" method="GET">
                            @csrf
                            <div class="w-[500px] h-[50px] relative">
                                <div class="w-full h-full bg-[#D9D9D9] round absolute z-50 flex items-center px-2">
                                    <input name="search" placeholder="Search Game..." value="{{request('search')}}" class="border-b-[1px] w-full border-black bg-[#D9D9D9] focus:outline-none">
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
                                            <thead class="bg-white">
                                                <tr class="bg-white">
                                                    <th scope="col" class="whitespace-nowrap p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Game Banner </th>
                                                    <th scope="col" class="whitespace-nowrap p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Game Title </th>
                                                    <th scope="col" class="whitespace-nowrap p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Game Description</th>
                                                    <th scope="col" class="whitespace-nowrap p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Game Source</th>
                                                    <th scope="col" class="whitespace-nowrap p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">Game Code</th>
                                                    <th scope="col" class="whitespace-nowrap p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Game URL</th>
                                                    <th scope="col" class="whitespace-nowrap p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Game Status</th>
                                                    <th scope="col" class="whitespace-nowrap p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-300">
                                                @foreach ($games as $game )
                                                    <tr class="">
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 ">
                                                            @if (isset($game['game_banner']) && !empty($game['game_banner']))
                                                                <img class="size-12 round object-cover" src="{{$game['game_banner']}}">
                                                            @else
                                                            <p>N/A</p>
                                                            @endif
                                                        </td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 "> {{$game['game_title']}} </td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 "> {{ isset($game['game_description']) ? $game['game_description'] : 'N/A'}}</td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 "> {{ isset($game['game_source']) ? $game['game_source'] : 'N/A' }}</td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> {{$game['game_code']}}</td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-blue-500 underline"> <a href="{{$game['game_url']}}">{{$game['game_url']}}</a></td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium
                                                        @if ($game['game_status'] === 'Active') text-green-500
                                                        @else
                                                        text-red-500
                                                        @endif"> {{$game['game_status']}}</td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                            <div class="flex space-x-2">
                                                                @php
                                                                    $gameData = [
                                                                        'game_title' => $game['game_title'],
                                                                        'game_status' => $game['game_status'],
                                                                        'game_code' => $game['game_code'],
                                                                        'game_banner' => $game['game_banner'],
                                                                    ];
                                                                @endphp
                                                                <button type="submit" id="status-button"
                                                                data-game='@json($gameData)'
                                                                class="px-3 py-1 bg-blue-500 text-white rounded">
                                                                Edit
                                                                </button>
                                                                {{-- <button type="submit" value="@json(['game_title' => $game['game_code']])" class="px-3 py-1 bg-red-500 text-white rounded">Remove</button> --}}
                                                            </div>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            </div>
                    </div>


                </div>
                <div class="w-full h-full round bg-black/50 translate-x-2 translate-y-2 absolute top-0 -z-10">

                </div>
            </div>
            <x-footer-nav/>
        </div>
</body>

       <script>
                                const modal = document.getElementById('active-game-modal');
                                const statusButtons = document.querySelectorAll('#status-button'); // Select all buttons
                                const closeButton = document.getElementById('close-modal-button')
                                const setActive = document.getElementById('set-active');
                                const inputGameCode = document.getElementById('input-game-code');
                                const inputGameStatus = document.getElementById('input-game-status');

                                const gameBanner = document.getElementById('game-banner');
                                const gameTitle = document.getElementById('game-title');
                                const gameCode = document.getElementById('game-code');
                                const gameStatus = document.getElementById('game-status');


                                statusButtons.forEach(button => {
                                    button.addEventListener('click', function () {
                                        console.log("CLICK");

                                        const gameData = JSON.parse(this.getAttribute("data-game"));
                                        console.log(gameData);
                                        gameTitle.textContent = gameData.game_title;
                                        gameCode.textContent = gameData.game_code;
                                        gameStatus.textContent = gameData.game_status;
                                        gameBanner.src = gameData.game_banner;
                                        inputGameCode.value = gameData.game_code;
                                        inputGameStatus.value = gameData.game_status;

                                        if(gameData.game_status === 'Active'){
                                            gameStatus.classList.remove('text-red-500');
                                            gameStatus.classList.add('text-green-500');
                                        }else{
                                            gameStatus.classList.add('text-red-500');
                                            gameStatus.classList.remove('text-green-500');
                                        }

                                        modal.classList.remove('hidden');
                                    });
                                });

                                // setActive.addEventListener('click', function(){
                                //     console.log('click');
                                //     const gameCode = this.getAttribute("data-code");
                                //     // console.log(gameCode);
                                // });

                                document.querySelectorAll('.add-form-group').forEach(form => {
                                    form.addEventListener('submit', async () => {
                                        // e.preventDefault();
                                        let formData = new FormData(form);

                                        const code = formData.get('game_code');
                                        const status = formData.get('game_status');

                                        console.log(code);
                                        console.log(status);
                                        let token = "{{session('admin_token')}}";
                                        let csrf = "{{csrf_token()}}";

                                        let response = await fetch("{{ route('edit-game-status')}}", {
                                            method: 'POST',
                                            headers: {
                                                'Authorization': "Bearer " + token,
                                                'X-CSRF-TOKEN': csrf,
                                            },
                                            body: formData,
                                        });
                                        let result = await response.json();
                                        if(response.ok){
                                            console.log('Data Sent');
                                        }else{
                                            console.error('Data Didnt Sent')
                                        }
                                    })
                                })


                                closeButton.addEventListener('click', () => {
                                    modal.classList.add('hidden');
                                })
                            </script>
@endsection
