@extends('TeacherDashboard.teacher-layout')

@section('title', 'OCKTED GAMING')  <!-- Corrected title section -->

@section('content')
<body>
    <x-student-navbar :picture="$combinedData['Student Data']['profile_picture']"/>
    <x-toast/>
    <div id='img-container' class="hidden w-full h-screen bg-zinc-800/50 fixed z-[9999] top-0 items-center justify-center">
        <div class="w-auto h-auto lg:w-auto lg:h-[90%] rounded-lg relative overflow-hidden">
            <img id="close-img-container" src="{{ asset('Teacher/icons/cross.png') }}" class="size-10 absolute right-2 top-2 hover:cursor-pointer bg-zinc-800 rounded-full">
            <img id="question-img" src="" class="w-full h-full object-cover">
        </div>
    </div>

    <div class="w-full h-[50px] px-4 lg:px-10 flex items-end font1 py-3">
        <a href="{{ route('view-classroom-assignment', ['classroom_code' => $combinedData['Game Room Data']['classroom_code']]) }}">
            <div class="flex gap-3 hover:cursor-pointer hover:text-zinc-950 text-zinc-600">
                <img class="size-6" src="{{ asset('Teacher/icons/back.png') }}">
                <p>Back to Classroom</p>
            </div>
        </a>
    </div>

    <div class="w-full h-full fixed top-0 left-0 -z-30">
        <img class="w-full h-full object-cover filter contrast-less" src="{{ asset('Teacher/bg3.jpg') }}">
    </div>

    <div class="w-full rounded-md h-auto px-4 lg:px-10">
        <div class="w-full h-[6px] rounded-t-md bg-[#F59E0B]"></div>
        <div class="w-full h-auto lg:h-[110px] flex flex-col gap-4 lg:gap-0 lg:flex-row justify-center items-center py-3 lg:py-0 px-4 lg:px-10">
            <div class="font1 flex text-center lg:text-left justify-center lg:justify-start flex-col w-full">
                <div class="flex flex-col lg:flex-row justify-between items-center">
                    <h1 class="text-4xl font-extrabold">{{ $combinedData['Assignment Data']['assignment_title'] }}</h1>
                    <p class="px-2 py-1 rounded-b-md text-[#F59E0B] bg-[#e8d7ba]">{{ $combinedData['Assignment Data']['assignment_status'] }}</p>
                </div>
            </div>
        </div>
        <div class="w-full lg:w-[50%] h-[6px] bg-[#2776F9] mt-3 rounded-lg"></div>
    </div>

    <div class="px-4 sm:px-20 font1 h-[120px] mt-4">
        <p class="text-2xl font-semibold">Description</p>
        <p>Complete the online question {{ $combinedData['Assignment Data']['assignment_title'] }}. The quiz includes picture based questions.</p>
    </div>

    <div class="font1 px-4 lg:px-20 text-2xl lg:h-[50px] mb-3">
        <h1>Guess The Picture</h1>
    </div>

    <form action="{{ route('submit-assignment', ['assignment_code' => $combinedData['Assignment Data']['custom_game_assignment_code']]) }}" method="POST">
        @csrf
        <div class="px-4 sm:px-20 font1 grid lg:grid-cols-2 gap-5">
            @foreach ($combinedData['Question Data'] as $key => $question)
                @foreach ($question['maths'] as $math)
                    <div class="w-full bg-white h-auto pb-4 rounded-2xl overflow-hidden shadow-2xl relative">
                        <div class="w-full h-[10px] bg-[#4BE79E] rounded-t-md mb-2 "></div>
                        <div class="px-2">
                            @if (isset($math['question']))
                                <h1 class="font1 text-xl text-zinc-700">{{ $math['question'] }}</h1>
                            @elseif(isset($math['img']))
                                <div class="w-full h-full flex items-center justify-center mt-2">
                                    <div class="w-[200px] h-[200px] relative overflow-hidden rounded-lg">
                                        <img id="img" src="{{ asset('storage/' . $math['img']) }}"  class="w-full h-full object-cover hover:cursor-pointer" onclick="expandImg(this)">
                                    </div>
                                </div>
                            @endif
                            <div class="w-full h-auto mt-2">
                                <label>Your Answer:</label>
                                <input name="answers[{{ $math['math_game_id'] }}]" type="text" class="font1 px-2 w-full h-[40px] focus:outline-none border-[1px] border-zinc-400 rounded-lg" placeholder="Type your answer">
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>

        <div id="open-modal-btn" class="hover:cursor-pointer fixed bottom-14 right-0 px-3 py-2 bg-[#0d1b2a] text-zinc-100 font1">
            Submit Answer
        </div>

        <div id="submit-modal" class="hidden w-full h-screen fixed top-0 font1 items-center justify-center">
            <div class="w-[300px] absolute h-[200px] z-10 rounded-md border-[1px] border-[#0d1b2a] bg-white">
                <div class="flex items-center justify-center h-20">Submit Your Assignment!</div>
                <div class="flex items-center gap-4 justify-center h-20">
                    <div  class="w-[110px] h-[70%] flex items-center justify-center hover:cursor-pointer"><button class="hover:border-b-2 hover:border-black" type="submit">Yes</button></div>
                    <div id="close-modal-btn" class="w-[110px] h-[70%]  flex items-center justify-center hover:cursor-pointer"><p class="hover:border-b-2 hover:border-black">No</p></div>
                </div>
            </div>
            <div class="w-[300px] h-[200px] bg-[#0d1b2a] rounded-md translate-x-1 translate-y-2">
            </div>
        </div>
    </form>

</body>

<script>
    const openModal = document.getElementById('open-modal-btn');
    const submitModal = document.getElementById('submit-modal');
    const closeModal = document.getElementById('close-modal-btn');

    openModal.addEventListener('click', function() {
        submitModal.classList.add('flex');
        submitModal.classList.remove('hidden');
    });

    closeModal.addEventListener('click', function() {
        submitModal.classList.add('hidden');
        submitModal.classList.remove('flex');
    });
</script>

<script>
    const img = document.querySelectorAll('#img');
    const imgContainer = document.getElementById('question-img');
    const imgWrapper = document.getElementById('img-container');
    function expandImg(element)
    {
        console.log('click');
        const image = element.src;
        console.log(image);

        imgContainer.src = image;

        imgWrapper.classList.remove('hidden');
        imgWrapper.classList.add('flex');
    }

    document.getElementById('close-img-container').addEventListener('click', () => {
        imgWrapper.classList.remove('flex');
        imgWrapper.classList.add('hidden');
    });
</script>
@endsection
