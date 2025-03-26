@extends('TeacherDashboard.teacher-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body>
<h1>HELLO THIS IS TEACHER DASHBOARD</h1>
<h1>Welcome {{$combinedData['Teacher Data']['teacher_name']}}</h1>
<h1>Your ID: {{$combinedData['Teacher Data']['ocktedgaming_id']}}<h1>
<h1>School Code: {{$combinedData['Teacher Data']['school_code']}}<h1>

    <div class="">
        <h1 class="text-3xl">CREATE GAMEROOM</h1>
        <div class="flex flex-col">
            <form action="{{route('create-gameroom')}}" method="POST">
                <label>Class</label>
                <input type="text" name="class_level_gameroom" placeholder="eg: Class 3" class="border-2 border-black">
                <button type="submit" class="p-2 bg-red-300 border-2 border-black">Create Gameroom</button>
            </form>
        </div>
    </div>

    <div class="w-full p-6 flex flex-col space-y-4">
        <h1 class="text-2xl font-bold text-center">GAME ROOM</h1>

        @if (isset($combinedData['Game Room']) && count($combinedData['Game Room']) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($combinedData['Game Room'] as $key=>$gameroom)
                    <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $gameroom['gameroom_code'] }}</h2>
                        <p class="text-gray-600">{{ $gameroom['class_level_gameroom'] }}</p>
                        <a href="{{ route('gameroom-details', ['gameroom_code' => $gameroom['gameroom_code']]) }}"
                            class="mt-4 py-2 px-4 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition duration-200">
                             View Room
                         </a>               
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</body>


@endsection
