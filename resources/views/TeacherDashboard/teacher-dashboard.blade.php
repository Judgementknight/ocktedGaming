@extends('TeacherDashboard.teacher-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body>
    <x-teacher-navbar/>
    <x-toast/>
    <div class="w-full h-full fixed top-0 left-0 -z-30">
        <img class="w-full h-full object-cover" src="{{asset('Teacher/bg3.jpg')}}">
    </div>
    <div class="w-full h-auto lg:h-[110px] flex flex-col gap-4 justify-center lg:gap-0 lg:flex-row justify-betweem items-center  py-3 lg:py-0 px-5 lg:px-10">
        <div class="font1 flex text-center lg:text-left justify-center lg:justify-start flex-col w-full">
            <h1 class="text-4xl font-extrabold">Teacher Dashboard</h1>
            <h1 class="font1 font-bold text-zinc-600">Manage gameroom and student game assignment</h1>
        </div>
        <div class="w-full flex items-center justify-center lg:justify-end">
            <div id="add-gameroom-btn" class="bg-[#2A6DF4] text-white px-5 py-3 rounded-[5px] flex items-center gap-2 font1 hover:cursor-pointer">
                <img class="size-8" src="{{asset('Teacher/icons/add.png')}}">
                <h1>Create New Classroom</h1>
            </div>
        </div>
    </div>

    <div class="w-full h-[50px] px-5 lg:px-10 font1">
        <div class="relative w-full h-full border-b-[1px] border-zinc-300">
            <input type="text" placeholder="Search gamerooms by title, class or description...." class="w-full h-full pl-10 lg:px-10 relative">
            <img class="size-4 absolute top-[18px] left-4" src="{{asset('Teacher/icons/search.png')}}">
        </div>
    </div>
    <div class="px-5 lg:px-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 w-full mt-8 gap-5 font1 text-zinc-600">

        @if (isset($combinedData['Class Room']) && count($combinedData['Class Room']) > 0)
            @foreach ($combinedData['Class Room'] as $key=>$class)

            <a href="{{route('classroom-details', ['classroom_code' => $class['classroom_code']])}}">
                <div class="w-full h-[250px] bg-white lg:h-[200px] p-5 rounded-lg relative hover:cursor-pointer hover:-translate-y-3 transition-all duration-200 ease-linear">
                    <div class="absolute w-full rounded-t-lg h-[15px] left-0 top-0" style="background-color: {{$class['classroom_color']}}"></div>
                    <div class="w-full flex flex-col lg:flex-row justify-between lg:items-center mt-3">
                        <h1 class="text-2xl font-semibold text-zinc-900">{{$class['classroom_title']}}</h1>
                        {{-- <h1 class="text-md text-zinc-900">Mathematics</h1> --}}
                    </div>
                    <div class="w-full mt-3">
                        <h1 class="text-md">{{$class['classroom_description']}}</h1>
                    </div>
                    <div class="w-full flex flex-col lg:flex-row gap-4 items-start lg:items-center mt-4">
                       <div class="flex items-center gap-2">
                        <img class="size-4" src="{{asset('Teacher/icons/group.png')}}">
                        <p>{{$class['students_count']}} Students</p>
                       </div>
                       <div class="flex items-center gap-2">
                        <img class="size-4" src="{{asset('Teacher/icons/assignment.png')}}">
                        <p>{{$class['assignments_count']}} Assignments</p>
                       </div>
                    </div>
                    <div class="w-full mt-3">
                        <h1 class="text-md">Class Room Code: {{$class['classroom_code']}}</h1>
                    </div>
                </div>
            </a>

            @endforeach
        @else
            <p class="text-zinc-500 font-semibold">NO CLASSROOM CREATED</p>

        @endif
    </div>

    <div id="gameroom-modal" class="hidden w-full h-screen fixed top-0 bg-zinc-700 bg-opacity-50 justify-center items-center px-3 font1 font-medium z-50">
        <div class="w-[500px] h-auto bg-[#ffffff] rounded-lg pb-5">
            <div class="h-[50px] w-full rounded-t-lg bg-[#05668d] flex items-center justify-between px-2">
                <h1 class="text-xl text-zinc-200 font-semibold">Create Classroom</h1>
                <img src="{{asset('Teacher/icons/cross.png')}}" class="size-10 hover:cursor-pointer" id="cross-btn">
            </div>
            <form method="POST" action="{{route('create-classroom')}}">
                @csrf
                <div class="w-full p-4">
                    <div class="w-full flex flex-col">
                        <label class="font-bold text-xl">Classroom Title</label>
                        <input id="input-1" type="text" class="w-full h-[50px] px-3 border-b-2 border-zinc-300" name="classroom_title" placeholder="Title....">
                        <p id="error-1" class="text-sm text-red-400 hidden">Enter Title!</p>
                    </div>

                    <div class="w-full flex flex-col mt-3">
                        <label class="font-bold text-xl">Classroom Description</label>
                        <textarea id="input-2" type="text" class="w-full h-[100px] p-3 border-b-2 border-zinc-300" name="classroom_description" placeholder="Description...."></textarea>
                        <p id="error-2" class="text-sm text-red-400 hidden">Description cross text limit!</p>
                    </div>

                    <div class="w-full flex flex-col mt-3">
                        <label class="font-bold text-xl">Class</label>
                        <select id="input-3" name="class_level" class="w-full h-[50px] px-3 border-b-2 border-zinc-300">
                            <option  selected disabled>Select Class</option>
                            @for ($i=1; $i<=12; $i++)
                                <option value="{{ $i }}">{{$i}}</option>
                            @endfor
                        </select>
                        <p id="error-3" class="text-sm text-red-400 hidden">Select a class!</p>

                    </div>

                    <div class="gap-4 mt-3 w-full">
                        <label class="font-bold text-xl">Select Color</label>
                        <div class="flex gap-5 items-center justify-center mt-2">
                            <label class="cursor-pointer">
                                <input id="input-4" type="radio" name="classroom_color" value="#a4dded" class="hidden peer">
                                <div class="w-[50px] h-[50px] rounded-[50%] bg-[#a4dded] peer-checked:ring-4 ring-black"></div>
                            </label>
                            <label class="cursor-pointer">
                                <input id="input-4"  type="radio" name="classroom_color" value="#f7d6e0" class="hidden peer">
                                <div class="w-[50px] h-[50px] rounded-[50%] bg-[#f7d6e0] peer-checked:ring-4 ring-black"></div>
                            </label>
                            <label class="cursor-pointer">
                                <input id="input-4"  type="radio" name="classroom_color" value="#ee7674" class="hidden peer">
                                <div class="w-[50px] h-[50px] rounded-[50%] bg-[#ee7674] peer-checked:ring-4 ring-black"></div>
                            </label>
                            <label class="cursor-pointer">
                                <input id="input-4"  type="radio" name="classroom_color" value="#f0ead2" class="hidden peer">
                                <div class="w-[50px] h-[50px] rounded-[50%] bg-[#f0ead2] peer-checked:ring-4 ring-black"></div>
                            </label>
                        </div>
                        <p id="error-4" class="text-sm text-red-400 hidden">Choose a color!</p>
                    </div>

                    <div class="w-full flex items-center justify-center h-[80px]">
                        <button onclick="checkValidation()" type="submit" class="bg-[#05668d] px-3 p-1 text-zinc-200 font-medium rounded-sm">Create Classroom</button>
                    </div>
                </div>
            </form>

        </div>

    </div>

</body>

<script>
    const error1 = document.getElementById('error-1');
    const error2 = document.getElementById('error-2');
    const error3 = document.getElementById('error-3');
    const error4 = document.getElementById('error-4');

    const input1 = document.getElementById('input-1');
    const input2 = document.getElementById('input-2');
    const input3 = document.getElementById('input-3');
    const input4 = document.querySelectorAll('input[name="classroom_color"]'); // Get all radio buttons for color selection

    function checkValidation(event) {
        let isValid = true;

        // Validate Classroom Title (input-1)
        if (!input1.value.trim()) {
            error1.classList.remove('hidden');
            isValid = false;
        } else {
            error1.classList.add('hidden');
        }

        // Validate Classroom Description (input-2)
        if (!input2.value.trim()) {
            // If the description is empty
            error2.textContent = 'Description should not be empty!';
            error2.classList.remove('hidden');
            isValid = false;
        } else if (input2.value.length > 200) { // Example: limit description to 200 characters
            // If the description exceeds the character limit
            error2.textContent = 'Description exceeds the text limit!';
            error2.classList.remove('hidden');
            isValid = false;
        } else {
            // If description is valid
            error2.classList.add('hidden');
        }

     // Validate Class Level (input-3)
        if (input3.value === "" || input3.value === null || input3.value === "Select Class") {
            error3.classList.remove('hidden');
            error3.textContent = 'Select a class!'; // Update error message for clarity
            isValid = false;
        } else {
            error3.classList.add('hidden');
        }

        // Validate Classroom Color (input-4)
        let colorSelected = false;
        input4.forEach((input) => {
            if (input.checked) {
                colorSelected = true;
            }
        });

        if (!colorSelected) {
            error4.classList.remove('hidden');
            isValid = false;
        } else {
            error4.classList.add('hidden');
        }

        // If validation fails, prevent form submission
        if (!isValid) {
            event.preventDefault();
        }
    }

    // Attach the validation function to the form's submit event
    const form = document.querySelector('form');
    form.addEventListener('submit', checkValidation);
</script>

<script>

    const gameroomModal = document.getElementById('gameroom-modal');
    const crossButton = document.getElementById('cross-btn');
    const addGameroomButton = document.getElementById('add-gameroom-btn');

    addGameroomButton.addEventListener('click', function(){
        console.log('click')
        gameroomModal.classList.add('flex');
        gameroomModal.classList.remove('hidden');
    });

    crossButton.addEventListener('click', function(){
        console.log('click')
        gameroomModal.classList.remove('flex');
        gameroomModal.classList.add('hidden');
    });


</script>
@endsection



{{--
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
 --}}
