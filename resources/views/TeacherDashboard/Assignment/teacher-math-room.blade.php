@extends('TeacherDashboard.teacher-layout')

@section('title', 'OCKTED GAMING') <!-- Overriding the title with dynamic game title -->

@section('content')
<body>
    <x-teacher-navbar/>
    <x-toast/>
    <x-background/>
    <div class="w-full h-[30px] mt-5 px-5 lg:px-10 flex items-center justify-between font1 ">
        <div class="flex items-center">
            <a href="{{ route('classroom-details', ['classroom_code' => $combinedData['Class Room']]) }}">
                <div class="w-[30px] h-[30px] rounded-[50%] transition-all ease-in duration-200 hover:cursor-pointer hover:bg-pink-500 flex items-center justify-center">
                    <img src="{{ asset('Teacher/icons/back.png') }}" class="w-[75%] h-[75%]">
                </div>
            </a>
        </div>
    </div>

    <div class="w-full flex flex-col lg:flex-row lg:items-center justify-between px-4 lg:px-10 mt-5 font1 mb-5">
        <div class="flex flex-col">
            <p class="text-2xl lg:text-3xl font-bold text-zinc-800">{{ $combinedData['Game Room']['gameroom_type'] }}</p>
            <div class="flex gap-2 items-center h-[50px]">
                <p class="font-bold text-md text-zinc-500">Class Room ID: {{ $combinedData['Class Room'] }}</p>
                <div class="flex items-center justify-center">
                    <div class="w-[5px] h-[4px] rounded-[50%] bg-zinc-500">
                    </div>
                </div>
                <div class="w-auto h-[25px] border-2 border-[#bee9e8] rounded-[10px] px-2 flex items-center justify-center">
                    <p class="text-[#5fa8d3] text-sm font-bold">Math</p>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <div class="w-auto px-2 h-[25px] bg-[#c7f9cc] rounded-[10px] flex items-center justify-center" id="mathCounter">
                <p class="text-[#008000] text-sm font-bold">{{ old('question') ? count(old('question')) : 0 }} Questions</p>
            </div>
        </div>
    </div>
    <form action="{{route('create-math-assignment')}}" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data">
        @csrf

        <div class="px-10 flex justify-between w-full">
            {{-- Math Questions Container --}}
            <div class="w-full lg:w-[800px] h-[500px] p-4 overflow-y-auto">
                {{-- Preview of Added Math Problems --}}
                <div id="mathPreview" class="space-y-4 shadow-lg bg-white rounded-lg">
                    @if(old('math_questions'))
                        @foreach(old('math_questions') as $index => $question)
                        <div class="space-y-4 p-4 rounded-lg preview-math " data-index="{{ $index }}">
                            <div class="flex justify-between items-center mt-2">
                                <h3 class="font-semibold">Math Problem {{ $index + 1}}:</h3>
                                <button type="button" onclick="removeMathProblem({{ $index }})" class="text-red-600 hover:text-red-800">×</button>
                            </div>
                            @if($question['problem_image'])
                                <img src="{{ $question['problem_image'] }}" class="w-full h-48 object-contain mb-2">
                            @else
                                <p class="text-lg mb-2">{{ $question['problem_text'] }}</p>
                            @endif
                            <p class="font-bold">Correct Answer: {{ $question['correct_answer'] }}</p>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Math Form --}}
            <div class="w-[400px] h-auto p-4 border-2 shadow-lg bg-background rounded-md">
                <div class="w-full h-full space-y-4">

                    <div class="">
                        <label class="text-zinc-500">Assignment Title</label>
                        <input id="assignment-title" name="assignment_title" type="text" placeholder="Enter Assignment Title.." class="py-2 px-3 focus:outline-none border-[1px] text-zinc-500 border-zinc-200 focus:ring-2 focus:ring-blue-500 rounded-md w-full h-[40px]" oninput="removeError()">
                        <span id="assignment-error" class="text-red-400 text-sm hidden">Please enter assignment title!!</span>
                    </div>

                    <div class="">
                        <label class="text-zinc-500">Due Date</label>
                        <input id="due-date" name="due_date" type="date" placeholder="Select Due Date" class="py-2 px-3 focus:outline-none border-[1px] text-zinc-500 border-zinc-200 focus:ring-2 focus:ring-blue-500 rounded-md w-full h-[40px]" oninput="removeError()">
                        <span id="date-error" class="text-red-400 text-sm hidden">Select Due Date!!</span>
                    </div>

                    {{-- Problem Input --}}
                    <div class="flex flex-col gap-2">
                       <label class="text-zinc-500">Math Problem (Text or Picture)</label>
                        <input name="current_problem_text" value="{{ old('current_problem_text') }}"
                            class="py-2 px-3 focus:outline-none border-[1px] text-zinc-500 border-zinc-200 focus:ring-2 focus:ring-blue-500 rounded-md w-full h-[40px]" oninput="removeError()"
                            placeholder="Enter math problem text"
                            type="text">

                        <input type="file" name="current_problem_image" accept="image/*"
                            class="focus:outline-none border-[1px] text-zinc-500 border-zinc-200 focus:ring-2 focus:ring-blue-500 rounded-md w-full h-auto"
                            onchange="previewImage(event)"
                            id="imageInput">
                        <span id="input-error" class="text-red-400 text-sm hidden">Input text or image!!</span>
                    </div>

                    <div class="mt-3">
                        <label>Numerical Answer</label>
                        <input name="current_math_answer" value="{{ old('current_math_answer') }}"
                            class="py-2 px-3 focus:outline-none border-[1px] text-zinc-500 border-zinc-200 focus:ring-2 focus:ring-blue-500 rounded-md w-full h-[40px]" oninput="removeError()"
                            placeholder="Enter numerical answer"
                            type="number" step="any">
                        <span id="correct-error" class="text-red-400 text-sm hidden">Input Answer!!</span>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-center gap-4 mt-6">
                        <button type="button" onclick="addMathToForm()"
                                class="bg-blue-400 px-4 py-2 rounded text-white hover:bg-blue-500">
                            Add Math Problem
                        </button>
                        <button type="submit"
                                class="bg-green-500 px-4 py-2 rounded text-white hover:bg-green-600">
                            Save All Problems
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hidden Inputs for Math Problems --}}
        <div id="hiddenMathContainer">
            @if(old('math_questions'))
                @foreach(old('math_questions') as $index => $question)
                    <input type="hidden" name="math_questions[{{ $index }}][problem_text]"
                        value="{{ $question['problem_text'] }}">
                    <input type="hidden" name="math_questions[{{ $index }}][problem_image]"
                        value="{{ $question['problem_image'] }}">
                    <input type="hidden" name="math_questions[{{ $index }}][correct_answer]"
                        value="{{ $question['correct_answer'] }}">
                @endforeach
            @endif
        </div>

        <script>
            let mathCounter = {{ old('math_questions') ? count(old('math_questions')) : 0 }};
            let currentImageDataURL = '';
            const correctError = document.getElementById('correct-error');
            const inputError = document.getElementById('input-error');
            const assignmentError = document.getElementById('assignment-error');
            const dateError = document.getElementById('date-error');

            function previewImage(event) {
                const input = event.target;
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        currentImageDataURL = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function addMathToForm() {
                const problemText = document.querySelector('[name="current_problem_text"]');
                const mathAnswer = document.querySelector('[name="current_math_answer"]');
                const imageInput = document.getElementById('imageInput');

                if (!problemText.value.trim() && !currentImageDataURL) {
                    inputError.classList.remove('hidden');
                    return;
                }

                if (!mathAnswer.value.trim()) {
                    correctError.classList.remove('hidden');
                    return;
                }

                const container = document.getElementById('hiddenMathContainer');
                container.innerHTML += `
                    <input type="hidden" name="math_questions[${mathCounter}][problem_text]"
                        value="${problemText.value.trim()}">
                    <input type="hidden" name="math_questions[${mathCounter}][problem_image]"
                        value="${currentImageDataURL}">
                    <input type="hidden" name="math_questions[${mathCounter}][correct_answer]"
                        value="${mathAnswer.value.trim()}">
                `;

                const previewContainer = document.getElementById('mathPreview');
                const previewContent = currentImageDataURL
                    ? `<img src="${currentImageDataURL}" class="w-full h-48 object-contain mb-2">`
                    : `<p class="text-lg mb-2">${problemText.value.trim()}</p>`;

                previewContainer.innerHTML += `
                    <div class="space-y-4 p-4 rounded-lg preview-math" data-index="${mathCounter}">
                        <div class="flex justify-between items-center mt-2">
                            <h3 class="font-semibold">Math Problem ${mathCounter + 1}:</h3>
                            <button type="button" onclick="removeMathProblem(${mathCounter})" class="text-red-600 hover:text-red-800">×</button>
                        </div>
                        ${previewContent}
                        <p class="font-bold">Correct Answer: ${mathAnswer.value}</p>
                    </div>
                `;

                mathCounter++;
                updateMathCounterDisplay();
                updateQuestionNumbers();

                problemText.value = '';
                imageInput.value = '';
                mathAnswer.value = '';
                currentImageDataURL = '';
            }

            function removeMathProblem(index) {
                document.querySelector(`.preview-math[data-index="${index}"]`).remove();
                const inputs = document.querySelectorAll(`#hiddenMathContainer input[name*="[${index}]"]`);
                inputs.forEach(input => input.remove());

                const remainingProblems = document.querySelectorAll('.preview-math');
                remainingProblems.forEach((problem, newIndex) => {
                    problem.dataset.index = newIndex;
                    problem.querySelector('h3').textContent = `Math Problem ${newIndex + 1}:`;
                    document.querySelectorAll(`#hiddenMathContainer input[name*="math_questions[${newIndex}]"]`)
                        .forEach(input => {
                            input.name = input.name.replace(/\[\d+\]/g, `[${newIndex}]`);
                        });
                });

                mathCounter = remainingProblems.length;
                updateMathCounterDisplay();
            }

            function updateMathCounterDisplay() {
                document.querySelector('#mathCounter p').textContent = `${mathCounter} Question${mathCounter !== 1 ? 's' : ''}`;
            }

            function updateQuestionNumbers() {
                document.querySelectorAll('.preview-math').forEach((problem, index) => {
                    problem.querySelector('h3').textContent = `Math Problem ${index + 1}:`;
                });
            }

            function removeError() {
                correctError.classList.add('hidden');
                inputError.classList.add('hidden');
                assignmentError.classList.add('hidden');
                dateError.classList.add('hidden');
            }

            function validateForm() {
                let isValid = true;
                if (!document.getElementById('assignment-title').value.trim()) {
                    assignmentError.classList.remove('hidden');
                    isValid = false;
                }
                
                // 3) Due date must be after today
                const selected = new Date(dueDate.value);
                const today    = new Date();
                // zero out the hours so “today” means midnight
                today.setHours(0,0,0,0);

                if (selected <= today) {
                    date.textContent = 'Due date must be in the future.';
                    date.classList.remove('hidden');
                    return false;
                }

                if (!document.getElementById('due-date').value) {
                    dateError.classList.remove('hidden');
                    isValid = false;
                }
                if (mathCounter === 0) {
                    alert('Please add at least one math problem!');
                    isValid = false;
                }
                return isValid;
            }
        </script>
</body>
@endsection
