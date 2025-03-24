@extends('Dashboard.dash-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body class="h-auto w-full bg-[#E8F0F1] overflow-x-hidden">
        <x-dash-navbar />
        <x-table-tools />
        <x-active-status-user />
        <x-toast />
        <x-confirm-delete />
        <div class="main w-full flex items-start justify-center">
            <div class="main2 w-[1200px] bg-[#E8F0F1] round border-[1px] border-black/35 relative">
                <div class="w-full h-full round bg-[#E8F0F1] absolute z-50">
                    <div class="w-full h-[80px] border-b-[1px] border-black/50 flex items-center justify-between px-5">
                        <div class="anton w-[30%] ">
                            <h1 class="text-4xl">PLAYERS</h1>
                        </div>
                        <form action="{{route('player')}}" method="GET">
                            @csrf
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
                                                    <th scope="col" class="sticky top-0 p-5 whitespace-nowrap text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Profile Picture </th>
                                                    <th scope="col" class="sticky top-0 p-5 whitespace-nowrap text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> User ID </th>
                                                    <th scope="col" class="sticky top-0p-5 whitespace-nowrap text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Player Name </th>
                                                    <th scope="col" class="sticky top-0 p-5 whitespace-nowrap text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> School Code </th>
                                                    <th scope="col" class="sticky top-0 p-5 whitespace-nowrap text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Game Token </th>
                                                    <th scope="col" class="sticky top-0 p-5 whitespace-nowrap text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Total Score Earn </th>
                                                    <th scope="col" class="sticky top-0 p-5 whitespace-nowrap text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Total Game Played </th>
                                                    <th scope="col" class="sticky top-0 p-5 whitespace-nowrap text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Rank </th>
                                                    <th scope="col" class="sticky top-0 p-5 whitespace-nowrap text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Status</th>
                                                    <th scope="col" class="sticky top-0 p-5 whitespace-nowrap text-left text-sm leading-6 font-semibold text-gray-900 capitalize"> Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-300">
                                                @foreach ($players as $player )
                                                    <tr class="">
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 "> <img class="size-12 round object-cover" src="{{$player->profile_picture}}"></td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 "> {{$player->user_id}}</td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 "> {{$player->username}}</td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 "> {{$player->school_code}}</td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 "> {{$player->game_token}}</td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900 "> {{$player->total_score}}</td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> {{$player->game_count}}</td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900"> {{isset($player->rank) ? $player->rank : 'No Rank'}}</td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium
                                                        @if ($player->user_status === "Active") text-green-500
                                                        @else
                                                        text-red-500
                                                        @endif"> {{$player->user_status}}</td>
                                                        <td class="p-5 whitespace-nowrap text-sm leading-6 font-medium text-gray-900">
                                                            <div class="flex space-x-2">
                                                                @php
                                                                    $userData = [
                                                                        'username' => $player->username,
                                                                        'game_token' => $player->game_token,
                                                                        'school_code' => $player->school_code,
                                                                        'profile_picture' => $player->profile_picture,
                                                                        'user_status' => $player->user_status,
                                                                    ];
                                                                @endphp

                                                                @php
                                                                    $gameToken = ['game_token' => $player->game_token]
                                                                @endphp
                                                                <button type="submit" id="status-button"
                                                                data-user='@json($userData)'
                                                                class="px-3 py-1 bg-blue-500 text-white rounded">
                                                                Edit
                                                                </button>
                                                                <button id="open-remove-modal" type="submit" data-token='@json($gameToken)' class="px-3 py-1 bg-red-500 text-white rounded">Remove</button>
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
                            <script>
                                const modal = document.getElementById('active-user-modal');
                                const statusButtons = document.querySelectorAll('#status-button');
                                const close = document.getElementById('close-modal-button');

                                const username = document.getElementById('username');
                                const schoolCode = document.getElementById('school-code');
                                const gameToken = document.getElementById('game-token');
                                const profilePicture = document.getElementById('profile-picture');
                                const userStatus = document.getElementById('user-status');

                                const removeModal = document.getElementById('confirm-delete-modal');
                                const removeButtons = document.querySelectorAll('#open-remove-modal');
                                const closeRemoveModal = document.getElementById('close-modal')
                                const removeToken = document.getElementById('remove-token');

                                removeButtons.forEach(button => {
                                    button.addEventListener('click', function() {
                                        const gameToken = JSON.parse(this.getAttribute('data-token'));
                                        console.log(gameToken);
                                        removeToken.value = gameToken.game_token;
                                        removeModal.classList.remove('hidden');
                                    });
                                });

                                document.querySelectorAll('.remove-player').forEach(form => {
                                    form.addEventListener('submit', async () => {
                                        // e.preventDefault();
                                        let formData = new FormData(form);
                                        const gameToken = formData.get('game_token');
                                        console.log(gameToken);
                                        let token = "{{session('admin_token')}}";
                                        let csrf = "{{csrf_token()}}";

                                        let response = await fetch("{{route('remove-player')}}", {
                                            method: "POST",
                                            headers: {
                                                'Authorization': "Bearer " + token,
                                                'X-CSRF-TOKEN': csrf,
                                            },
                                            body: formData,
                                        });
                                        let result = response.json();
                                        if(response.ok){
                                            console.log("Data Send", result);
                                        }else{
                                            console.error("DATA NOT SENT")
                                        }
                                    });
                                });

                                closeRemoveModal.addEventListener('click', () => {
                                    removeModal.classList.add('hidden');
                                });

                                statusButtons.forEach(button => {
                                    button.addEventListener('click', function () {
                                        const userData = JSON.parse(this.getAttribute('data-user'));
                                        console.log(userData);

                                        username.placeholder = userData.username;
                                        schoolCode.placeholder = userData.school_code;
                                        gameToken.value = userData.game_token;
                                        userStatus.textContent = userData.user_status;
                                        profilePicture.src = userData.profile_picture;

                                        console.log(userData.user_status);

                                        if(userData.user_status === "Active"){
                                            userStatus.classList.add('text-green-500')
                                            userStatus.classList.remove('text-red-500')
                                            console.log("ADDING GREEN");
                                        }else{
                                            userStatus.classList.add('text-red-500');
                                            userStatus.classList.remove('text-green-500')
                                        }

                                        modal.classList.remove('hidden');

                                    });
                                });

                                const form = document.querySelectorAll('.add-form-group').forEach(form => {
                                    form.addEventListener('submit', async () => {

                                        let formData = new FormData(form);
                                        const username = formData.get('username');
                                        console.log(username)
                                        const schoolCode = formData.get('school_code');
                                        console.log(schoolCode);
                                        const gametoken = formData.get('game_token');
                                        console.log(gametoken);

                                        let token = "{{session('admin_token')}}";
                                        let csrf = "{{csrf_token()}}";

                                        let response = await fetch("{{route('update-player')}}", {
                                            method: "POST",
                                            headers: {
                                                'Authorization': "Bearer " + token,
                                                'X-CSRF-TOKEN': csrf,
                                            },
                                            body: formData,
                                        });

                                        let result = await response.json();
                                        if(response.ok){
                                            console.log("DATA SENT")
                                        }else{
                                            console.error('DATA NOT SENT');
                                        }
                                    })
                                });

                                close.addEventListener('click', () => {
                                    modal.classList.add('hidden');
                                })
                            </script>
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
