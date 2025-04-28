@extends('Dashboard.dash-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')

<body class="h-auto w-full bg-white overflow-x-hidden relative">
        <x-dash-navbar />
        <x-sidemenu-dashboard />
        <x-toast/>

        <button id="button">
            <div class="absolute hidden bg-gray-100 lg:flex items-center gap-5 bottom-0 border-[1px] border-black group hover:bg-black round w-[200px] h-[50px] px-2 z-50 hover:cursor-pointer">
                <div class="size-11 group-hover:scale-125 animate">
                    <img class="w-full h-full group-hover:scale-125 animate" src="{{asset('dashboard/icons/add2.png')}}">
                </div>
                <div class="kode">
                    <h1 class="group-hover:text-white">ADD GAMES</h1>
                </div>
            </div>
        </button>

        {{-- <p>Token: {{ session('admin_token') }}</p>
        <p>CSRF: {{csrf_token()}}</p> --}}


        <div class="h-auto w-full flex flex-col lg:flex-row px-[14px] lg:px-[28px] gap-[20px] lg:gap-[2%]">
            <div class="w-full lg:w-[68%] h-auto lg:h-[80vh] flex flex-col gap-[20px] lg:gap-[2%] ">
                <div class="h-[70vh] lg:h-[95%] w-full border-[1px] border-black/50 round relative">
                    <div class="w-full h-full bg-white absolute round z-20">
                        <div class="w-full h-[50px] flex items-center px-3 border-b-[1px] border-black/50">
                            <h1 class="anton text-2xl">GAMES DATA</h1>
                        </div>
                        <div class="w-full h-[90%] overflow-x-scroll overflow-y-scroll">
                            <div class="min-w-full h-full">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <!-- Table Header -->
                                    <thead class="bg-gray-50 kode sticky top-0 ">
                                        <tr>
                                            <th class="px-6 whitespace-nowrap py-3 text-left text-sm font-semibold text-gray-900">Game Title</th>
                                            <!-- Add more headers as needed -->
                                            <th class="px-6 py-3 whitespace-nowrap text-left text-sm font-semibold text-gray-900">Game Description</th>
                                            <th class="px-6 py-3 whitespace-nowrap text-left text-sm font-semibold text-gray-900">Game Source</th>
                                            <!-- Add more headers as needed -->
                                            <th class="px-6 py-3 whitespace-nowrap text-left text-sm font-semibold text-gray-900">Game URL</th>
                                            <th class="px-6 py-3 whitespace-nowrap text-left text-sm font-semibold text-gray-900">Game Banner Link</th>
                                            <!-- Add more headers as needed -->
                                            <th class="px-6 py-3 whitespace-nowrap text-left text-sm font-semibold text-gray-900">Game Code</th>
                                            <th class="sticky top-0 right-0 z-50 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900">Action</th>

                                        </tr>
                                    </thead>

                                    <!-- Table Body -->
                                    <tbody class="divide-y divide-gray-200 bg-white kode">
                                        <!-- Multiple rows -->
                                            @if (isset($gameData['Server 1']['Game Data']) && count($gameData['Server 1']['Game Data']) > 0 )
                                                @foreach ($gameData['Server 1']['Game Data'] as $key=>$game)
                                                    <tr>
                                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{$game['game_title']}}</td>
                                                        <td class="min-w-[300px] px-6 py-4 text-sm text-gray-500">{{$game['game_description']}}</td>
                                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{$gameData['Server 1']['sender']}}</td>
                                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500"><a href="{{$game['game_url']}}" class="text-blue-500">{{$game['game_url']}}</a></td>
                                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500"><a href="{{$game['game_banner']}}" class="text-blue-500">{{$game['game_banner']}}</a></td>
                                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{$game['game_code']}}</td>
                                                        <form class="add-game-form">
                                                            @csrf
                                                            <input type="hidden" name="game_title" value="{{$game['game_title']}}">
                                                            <input type="hidden" name="game_description" value="{{$game['game_description']}}">
                                                            <input type="hidden" name="game_source" value="{{$gameData['Server 1']['sender']}}">
                                                            <input type="hidden" name="game_code" value="{{$game['game_code']}}">
                                                            <input type="hidden" name="game_url" value="{{$game['game_url']}}">
                                                            <input type="hidden" name="game_banner" value="{{$game['game_banner']}}">
                                                            <td class="sticky right-0 z-5 hover:bg-black hover:text-white hover:cursor-pointer bg-white px-6 py-4 text-sm font-medium text-gray-900"><button type="submit">Add</button></td>
                                                        </form>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            @if (isset($gameData['Server 2']) && count($gameData['Server 2']) > 0)
                                                @foreach ($gameData['Server 2'] as $key=>$game)
                                                    <tr>
                                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{$game['game_title']}}</td>
                                                        <td class="min-w-[300px] px-6 py-4 text-sm text-gray-500">{{$game['game_description']}}</td>
                                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{isset($game['game_source']) ? $game['Server 2']['sender'] : 'N/A'}}</td>
                                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500"><a href="{{$game['game_url']}}" class="text-blue-500">{{$game['game_url']}}</a></td>
                                                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                            <a href="{{ isset($game['game_banner']) ? $game['game_banner'] : 'N/A' }}"
                                                            class="{{ isset($game['game_banner']) ? 'text-blue-500 underline whitespace-nowrap px-6 py-4 text-sm' : 'text-gray-500 whitespace-nowrap px-6 py-4 text-sm' }}">
                                                                {{ isset($game['game_banner']) ? $game['game_banner'] : 'N/A' }}
                                                            </a>
                                                        </td>
                                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{$game['game_code']}}</td>
                                                        <form class="add-game-form">
                                                            <input type="hidden" name="game_title" value="{{$game['game_title']}}">
                                                            <input type="hidden" name="game_description" value="{{$game['game_description']}}">
                                                            <input type="hidden" name="game_source" value="{{isset($gameData['Server 2']['sender']) ? $gameData['Server 2']['sender'] : 'N/A'}}">
                                                            <input type="hidden" name="game_code" value="{{$game['game_code']}}">
                                                            <input type="hidden" name="game_url" value="{{$game['game_url']}}">
                                                            <input type="hidden" name="game_banner" value="{{isset($game['game_banner']) ? $game['game_banner'] : 'N/A'}}">
                                                            <td class="sticky right-0 z-5 hover:bg-black hover:text-white hover:cursor-pointer bg-white px-6 py-4 text-sm font-medium text-gray-900"><button type="submit">Add</button></td>
                                                        </form>
                                                    </tr>
                                                @endforeach
                                            @endif


                                            <script>
                                                var GameDAta = @json($gameData);
                                                console.log(GameDAta["Server 1"].sender);

                                                document.querySelectorAll('.add-game-form').forEach(form => {
                                                    form.addEventListener('submit', async () => {

                                                        let formData = new FormData(form);
                                                        // Ensure the token is treated as a string
                                                        let token = "{{ session('admin_token') }}";
                                                        let csrf = "{{ csrf_token() }}";

                                                        let response = await fetch("{{ route('add-game') }}", {
                                                            method: "POST",
                                                            headers: {
                                                                'Authorization': "Bearer " + token,
                                                                'X-CSRF-TOKEN': csrf,
                                                            },
                                                            body: formData,
                                                        });

                                                        let result = await response.json();
                                                        if(response.ok){
                                                            console.log("DATA SENT!!")
                                                            // Remove the row (assuming the form is inside a <tr>)
                                                            const row = form.closest('tr');
                                                            if (row) {
                                                                row.remove();
                                                            }
                                                        } else {
                                                            console.error("DATA NOT SENT");
                                                        }
                                                    });
                                                });
                                            </script>
                                        <!-- Add more rows -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="w-full h-full bg-black/50 round translate-x-2 translate-y-1">
                    </div>

                </div>

                <div class="h-[80vh] lg:h-[40%] w-full round border-[1px] border-black/50 relative block lg:hidden">
                    <div class="w-full h-full bg-white absolute round z-20">
                        {{-- header --}}
                        <div class="w-full h-[50px] flex items-center px-3 border-b-[1px] border-black/50">
                            <h1 class="anton text-2xl">ADD GAMES</h1>
                        </div>
                        {{-- data --}}
                        <div class="w-full h-auto lg:h-[200px] flex flex-col gap-[10px] round px-[10px] py-2">
                            {{-- FIRST SECTION OF THE FORM --}}
                            <div class="flex flex-col lg:flex-row gap-[20px] lg:gap-[45px] w-full">
                                <div class="flex-1 round">
                                    <input placeholder="Insert Game Title..." class="kode w-full h-[50px] round bggray px-3" type="text">
                                </div>
                                <div class="flex-1 round">
                                    <input placeholder="Insert Game Code..." class="kode w-full h-[50px] round bggray px-3" type="text">
                                </div>
                                <div class="flex-1 round">
                                    <input placeholder="Insert Game Source..." class="kode w-full h-[50px] round bggray px-3" type="text">
                                </div>
                            </div>

                            {{-- SECOND SECTION OF THE FORM --}}
                            <div class="w-full h-auto lg:h-[120px] relative">
                                <div class="w-full h-full flex lg:gap-[45px] flex-col lg:flex-row relative">
                                    <div class="flex-1 py-2 h-full">
                                        <textarea placeholder="Insert Game Description..." class="w-full h-[100px] lg:h-full round bggray kode px-2 py-2"></textarea>
                                    </div>
                                    <div class="flex-1 flex flex-col gap-[20px] py-2">
                                        <div class="w-full h-full lg:h-[40%]">
                                            <input placeholder="Insert Game URL..." class="kode w-full h-[50px] round bggray px-3" type="text">

                                        </div>
                                        <div class="w-full h-full lg:h-[40%]">
                                            <input placeholder="Insert Game Banner Link..." class="kode w-full h-[50px] round bggray px-3" type="text">

                                        </div>
                                    </div>
                                    {{-- button --}}
                                    <div class="flex-1 flex items-end justify-end mt-3 lg:mt-0">
                                            <button id="button" class="w-full h-[50px] lg:h-[40%] kode bg-[#7BFBAA] border-[1px] border-black">SUBMIT</button>
                                    </div>
                                </div>
                                <div class="">

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="w-full h-full bg-black/50 round translate-x-2 translate-y-1">

                    </div>

                </div>

            </div>
            <div class="w-full lg:w-[30%] h-[80vh] relative border-[1px] border-black/50 round">
                <div class="w-full h-full bg-white absolute round z-20">
                    <div class="w-full flex items-center px-3 h-[100px] border-b-[1px] border-black/50">
                        <h1 class="anton text-4xl">RECENT ADDED GAMES</h1>
                    </div>
                    <div class="flex flex-col gap-4 p-3">
                        {{-- CARD GAME --}}
                        @if (isset($gameData['Recent Games']) && count($gameData['Recent Games']) > 0)
                            @foreach ($gameData['Recent Games'] as $key=>$game)
                            <div class="w-full flex gap-[3%] h-[150px] bg-gray-100 p-2 border-[1px] border-black/50 round">
                                <div class="w-[30%] h-full round">
                                    <img class="w-full h-full object-cover round" src="{{$game['game_banner']}}">

                                </div>
                                <div class="w-[67%] flex flex-col  h-full bg-[#FFFFFF] round">
                                    <div class="flex1 w-full kode p-2">
                                        <h1>{{$game['game_title']}}</h1>
                                    </div>
                                    <div class="flex1 h-full w-full px-2 whitespace-wrap ">
                                        <p class="truncate-text kode text-sm">{{ $game['game_description'] }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        @endif
                    </div>
                </div>
                <div class="w-full h-full bg-black/50 round translate-x-2 translate-y-1">

                </div>

            </div>




        </div>

        <x-footer-nav class=""/>

</body>


<script>
    const button = document.getElementById('button');
    const sidemenu = document.getElementById('sidemenu');
    const close = document.getElementById('close-sidemenu');

    button.addEventListener('click', () =>{
        console.log('click');
        if(sidemenu.classList.contains('right-[-100%]')){
            sidemenu.classList.add('right-0');
            sidemenu.classList.remove('right-[-100%]');

        }else{
            sidemenu.classList.add('right-[-100%]');
            sidemenu.classList.remove('right-0');

        }
    });

    close.addEventListener('click', () => {
        console.log('click');
        sidemenu.classList.add('right-[-100%]');
        sidemenu.classList.remove('right-0');
    });

</script>


@endsection
