@extends('TeacherDashboard.teacher-layout')

@section('title') {{ $combinedData['Game Room']['gameroom_type'] }} @endsection

@section('content')
<body>
    <x-teacher-navbar/>
    <x-toast/>
    <div class="w-full h-[30px] mt-5 px-5 lg:px-10 flex items-center justify-between font1">
        <div class="flex items-center">
            <a href="{{ route('classroom-details', ['classroom_code' => $combinedData['Class Room']]) }}">
                <div class="w-[30px] h-[30px] rounded-[50%] transition-all ease-in duration-200 hover:cursor-pointer hover:bg-pink-500 flex items-center justify-center">
                    <img src="{{ asset('Teacher/icons/back.png') }}" class="w-[75%] h-[75%]">
                </div>
            </a>
        </div>
        {{-- <div>

        </div> --}}
    </div>
    <div class="w-full flex items-center justify-between px-10 mt-5 font1">
        <div class="flex flex-col">
            <p class="text-3xl font-bold text-zinc-800">{{ $combinedData['Game Room']['gameroom_type'] }}</p>
            <div class="flex gap-2 items-center h-[50px]">
                <p class="font-bold text-md text-zinc-500">Class Room ID: {{ $combinedData['Class Room'] }}</p>
                <div class="flex items-center justify-center">
                    <div class="w-[5px] h-[4px] rounded-[50%] bg-zinc-500">
                    </div>
                </div>
                <div class="w-[50px] h-[25px] border-2 border-[#bee9e8] rounded-[10px] flex items-center justify-center">
                    <p class="text-[#5fa8d3] text-sm font-bold">MCQ</p>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <div class="w-auto px-2 h-[25px] bg-[#c7f9cc] rounded-[10px] flex items-center justify-center" id="questionCounter">
                <p class="text-[#008000] text-sm font-bold">{{ old('questions') ? count(old('questions')) : 0 }} Questions</p>
            </div>
            <div class="flex items-center">
                <img src="{{ asset('Teacher/icons/upload.png') }}" class="size-5">
                <p class="text-sm text-zinc-500 font-bold">Save All</p>
            </div>
        </div>

    </div>
    <form action="{{ route('create-assignment') }}" method="POST" onsubmit="return validateForm()">
        @csrf
        {{-- <div class="mt-5 lg:mt-5 font1 lg:px-10 px-5 flex gap-3 w-full h-[80px] bg-red-200">
            <div class="flex gap-10 w-full items-center justify-end">
                <div class="flex items-center gap-2">
                    <p class="text-zinc-500">Assignment Title: </p>
                    <input id="assignment-title" name="assignment_title" placeholder="Enter Assignment Title"  class="w-auto border-2 px-2 h-[40px] border-zinc-400 text-zinc-600 outline-none focus:ring-0 focus:outline-none" type="text">
                    <span class="hidden text-red-400">Input Assignment Title</span>
                </div>
                <div class="flex gap-2 items-center">
                    <p class="text-zinc-500">Due Date: </p>                    <input id="due-date" type="date" name="assignment_title" placeholder="Enter Assignment Title"  class="border-b-2 border-zinc-400 text-zinc-600 outline-none focus:ring-0 focus:outline-none" type="text">
                    <span class="hidden text-red-400">Select Due Date!!</span>
                </div>
            </div>
        </div> --}}

        {{-- Questions Container --}}
        <div class="px-10 flex justify-between w-full">
            <div class="w-[800px] h-[500px] p-4 overflow-y-auto ">

                <div id="questionsPreview" class="space-y-4 shadow-lg bg-white rounded-lg">
                    @if(old('questions'))
                        @foreach(old('questions') as $index => $question)
                            <div class="p-4 rounded-lg preview-question">
                                <h3 class="font-semibold">Question {{ $index + 1 }}:</h3>
                                <p>{{ $question['text'] }}</p>
                                <div class="grid grid-cols-2 gap-2 mt-2">
                                    @foreach($question['choices'] as $choice)
                                        <div class="p-2 {{ $question['correct'] === $choice ? 'bg-green-100' : '' }}">
                                            {{ $choice }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="w-[400px] min-h-[200px] p-4 border-2 shadow-lg bg-background rounded-md">
                <div class="w-full h-full space-y-4 font1">
                    <div class="">
                        <label class="text-zinc-500">Assignment Title</label>
                        <input id="assignment-title" type="text" placeholder="Enter Assignment Title.." class="py-2 px-3 focus:outline-none border-[1px] text-zinc-500 border-zinc-200 focus:ring-2 focus:ring-blue-500 rounded-md w-full h-[40px]" oninput="removeError()">
                        <span id="assignment-error" class="text-red-400 text-sm hidden">Please enter assignment title!!</span>

                    </div>

                    <div class="">
                        <label class="text-zinc-500">Due Date</label>
                        <input id="due-date" type="date" placeholder="Select Due Date" class="py-2 px-3 focus:outline-none border-[1px] text-zinc-500 border-zinc-200 focus:ring-2 focus:ring-blue-500 rounded-md w-full h-[40px]" oninput="removeError()">
                        <span id="date-error" class="text-red-400 text-sm hidden">Select Due Date!!</span>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-zinc-500">Question</label>
                        <textarea name="current_question"
                        value="{{ old('current_question') }}"
                        class="h-[70px] py-2 px-3 focus:outline-none border-[1px] text-zinc-500 border-zinc-200 focus:ring-2 focus:ring-blue-500 rounded-md"
                        placeholder="Enter question"
                        type="text" oninput="removeError()"></textarea>
                        <span id="question-error" class="text-red-400 text-sm hidden">Please enter a question!!</span>
                    </div>

                    <div class="mt-3 min-h-[200px]">
                        <label>Choices</label>
                        <div id="choicesContainer" class="space-y-2">

                        </div>
                        <button type="button" onclick="addChoice()" onclick="removeError()"
                                class="bg-gray-200 text-white px-3 py-1 rounded mt-2">
                            Add Choice
                        </button>
                        <span id="choice-error" class="text-red-400 text-sm hidden">Please add atleast two choices!!</span>

                        <!-- Template for choices -->
                        <template id="choiceTemplate">
                            <div class="flex items-center gap-2 choice-item">
                                <input type="text" class="w-full h-[40px] px-3 focus:outline-none border-[1px] text-zinc-500 border-zinc-200 focus:ring-2 focus:ring-blue-500 rounded-md choice-input"
                                       placeholder="Enter choice">
                                <button type="button" onclick="removeChoice(this)"
                                        class="text-red-500 hover:text-red-700">×</button>

                            </div>
                        </template>
                    </div>

                    <span id="correct" class="text-red-400 text-sm hidden">Please select the correct answer!</span>
                    <div class="">
                        <label>Correct Answer</label>
                        <select name="current_correct" class="h-[40px] w-full border-[1px] border-zinc-300 rounded-md focus:outline-none px-3" onclick="removeError()">
                            <option value="">Select correct answer</option>
                        </select>
                    </div>

                    <span id="add-question" class="text-red-400 text-sm hidden">Please add at least one question before saving.</span>
                    <div class="flex justify-center gap-4 mt-6">
                        <button type="button" onclick="addQuestionToForm()"
                                class="bg-[#2A6DF4] px-4 py-2 rounded text-white hover:bg-blue-500">
                            Add Question
                        </button>
                        <button type="submit"
                                class="bg-[#4BE79E] px-4 py-2 rounded text-white hover:bg-[#65eeae]">
                            Save All Questions
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hidden Inputs --}}
        <div id="hiddenQuestionsContainer">
            @if(old('questions'))
                @foreach(old('questions') as $index => $question)
                    <input type="hidden" name="questions[{{ $index }}][text]"
                           value="{{ $question['text'] }}">
                    @foreach($question['choices'] as $choice)
                        <input type="hidden" name="questions[{{ $index }}][choices][]"
                               value="{{ $choice }}">
                    @endforeach
                    <input type="hidden" name="questions[{{ $index }}][correct]"
                           value="{{ $question['correct'] }}">
                @endforeach
            @endif
        </div>

        <script>
            let questionCounter = {{ old('questions') ? count(old('questions')) : 0 }};

            const title = document.getElementById('assignment-title');
            const dueDate = document.getElementById('due-date');
            const assignment = document.getElementById('assignment-error');
            const date = document.getElementById('date-error');
            const addQuestion = document.getElementById('add-question');
            const questionError = document.getElementById('question-error');
            const choice = document.getElementById('choice-error');
            const correct = document.getElementById('correct');


            function removeError() {
                questionError.classList.remove('block');
                questionError.classList.add('hidden');

                assignment.classList.remove('block');
                assignment.classList.add('hidden');

                date.classList.remove('block');
                date.classList.add('hidden');

                choice.classList.add('hidden');
                choice.classList.remove('block');

                correct.classList.add('hidden');
                correct.classList.remove('block');

                addQuestion.classList.add('hidden');
                addQuestion.classList.remove('block');

            }
            function validateForm() {

                if(!title.value.trim()){
                    // alert('Please enter assigment title');
                    assignment.classList.remove('hidden');
                    assignment.classList.add('block');
                    return false;
                }

                if(!dueDate.value.trim()){
                    // alert('Please Select Due Date');
                    date.classList.remove('hidden');
                    date.classList.add('block');
                    return false;
                }

                if (questionCounter === 0) {
                    addQuestion.classList.remove('hidden');
                    addQuestion.classList.add('block');
                    return false;
                }
                return true;
            }

            function addChoice() {
                const container = document.getElementById('choicesContainer');
                const template = document.getElementById('choiceTemplate');
                const clone = template.content.cloneNode(true);
                container.appendChild(clone);
                updateCorrectAnswerOptions();
            }

            function removeChoice(button) {
                button.closest('.choice-item').remove();
                updateCorrectAnswerOptions();
            }

            function updateCorrectAnswerOptions() {
                const select = document.querySelector('[name="current_correct"]');
                select.innerHTML = '<option value="">Select correct answer</option>';

                document.querySelectorAll('.choice-input').forEach(input => {
                    const trimmedVal = input.value.trim();
                    if (trimmedVal) {
                        const option = document.createElement('option');
                        option.value = trimmedVal;
                        option.textContent = trimmedVal;
                        select.appendChild(option);
                    }
                });
            }

            document.addEventListener('input', function(e) {
                if(e.target && e.target.classList.contains('choice-input')) {
                    updateCorrectAnswerOptions();
                }
            });

            function addQuestionToForm() {
                const questionInput = document.querySelector('[name="current_question"]');
                const choiceInputs = document.querySelectorAll('.choice-input');
                const correctInput = document.querySelector('[name="current_correct"]');

                const choices = Array.from(choiceInputs)
                    .map(input => input.value.trim())
                    .filter(val => val !== '');

                if (!questionInput.value.trim()) {
                    // alert('Please enter a question!');
                    questionError.classList.remove('hidden');
                    questionError.classList.add('block');
                    return;
                }
                if (choices.length < 2) {
                    // alert('Please add at least 2 choices!');
                    choice.classList.add('block');
                    choice.classList.remove('hidden');
                    return;
                }
                if (!correctInput.value) {
                    // alert('');
                    correct.classList.add('block');
                    correct.classList.remove('hidden');
                    return;
                }

                const container = document.getElementById('hiddenQuestionsContainer');
                const questionDiv = document.createElement('div');

                questionDiv.innerHTML = `
                    <input type="hidden" name="questions[${questionCounter}][text]"
                           value="${questionInput.value.trim()}">
                    ${choices.map(choice => `
                        <input type="hidden" name="questions[${questionCounter}][choices][]"
                               value="${choice}">
                    `).join('')}
                    <input type="hidden" name="questions[${questionCounter}][correct]"
                           value="${correctInput.value}">
                `;
                container.appendChild(questionDiv);

                const previewContainer = document.getElementById('questionsPreview');
                previewContainer.innerHTML += `
                    <div class="p-4 rounded-lg preview-question font1">
                        <h3 class="font-semibold">Question ${questionCounter + 1}:</h3>
                        <p>${questionInput.value.trim()}</p>
                        <div class="grid grid-cols-2 gap-2 mt-2">
                            ${choices.map(choice => `
                                <div class="p-2 ${choice === correctInput.value ? 'bg-green-100' : ''}">
                                    ${choice}
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;

                questionCounter++;
                document.querySelector('#questionCounter p').textContent = `${questionCounter} Questions`;


                questionInput.value = '';
                document.getElementById('choicesContainer').innerHTML = '';
                correctInput.value = '';
                updateCorrectAnswerOptions();
            }
        </script>
    </form>
</body>
@endsection
