@extends('TeacherDashboard.teacher-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

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
                    <p class="text-[#5fa8d3] text-sm font-bold">Picture</p>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <div class="w-auto px-2 h-[25px] bg-[#c7f9cc] rounded-[10px] flex items-center justify-center" id="pictureCounter">
                <p class="text-[#008000] text-sm font-bold">{{ old('pictures') ? count(old('pictures')) : 0 }} Pictures</p>
            </div>
        </div>
    </div>

    <form action="{{route('create-picture-assignment')}}" method="POST" onsubmit="return validateForm()">
        @csrf
        <div class="px-2 lg:px-10 flex lg:flex-row flex-col-reverse justify-between w-full">
            <div class="w-full lg:w-[800px] h-[500px] p-4 overflow-y-auto">
                <div id="picturesPreview" class="space-y-4 shadow-lg bg-white rounded-lg">
                    @if(old('pictures'))
                        @foreach(old('pictures') as $index => $picture)
                        <div class="p-4 border rounded-lg w-full preview-picture font1">
                            <div class="flex justify-between items-start">
                                <h3 class="font-semibold">Question {{ $index + 1}}:</h3>
                                <button type="button" onclick="removePicture(${index})" class="text-red-500 hover:text-red-700">Remove</button>
                            </div>
                            <p class="mb-2">${picture.question_text || 'No question text provided'}</p>
                            <div class="flex gap-3 items-center">
                                <img src="{{ $picture['image_url'] }}" class="size-24 object-cover rounded-md">
                                <p class="font-bold text-green-400">Correct Answer: {{ $picture['correct_answer'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="w-[400px] h-auto p-4 border-2 shadow-lg bg-background rounded-md">
                <div class="w-full h-full space-y-4 font1">
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

                    <div class="flex flex-col">
                        <label>Question Text</label>
                        <textarea name="current_question_text"
                            class="h-[70px] py-2 px-3 focus:outline-none border-[1px] text-zinc-500 border-zinc-200 focus:ring-2 focus:ring-blue-500 rounded-md w-full"
                            placeholder="Enter question for this picture"
                            oninput="removeError()"></textarea>
                        <span id="question-error" class="text-red-400 text-sm hidden">Please enter a question!!</span>
                    </div>

                    <div class="flex flex-col">
                        <label>Image URL</label>
                        <input name="current_image_url" value="{{ old('current_image_url') }}"
                            class="py-2 px-3 focus:outline-none border-[1px] text-zinc-500 border-zinc-200 focus:ring-2 focus:ring-blue-500 rounded-md w-full h-[40px]"
                            placeholder="https://example.com/image.jpg"
                            type="url" oninput="removeError()">
                        <span id="input-error" class="text-red-400 text-sm hidden">Please input a URL!!</span>
                    </div>

                    <div class="mt-3">
                        <label>Correct Answer</label>
                        <input name="current_correct_answer" value="{{ old('current_correct_answer') }}"
                            class="py-2 px-3 focus:outline-none border-[1px] text-zinc-500 border-zinc-200 focus:ring-2 focus:ring-blue-500 rounded-md w-full h-[40px]"
                            placeholder="Enter correct answer"
                            type="text" oninput="removeError()">
                        <span id="correct-error" class="text-red-400 text-sm hidden">Input Correct Answer!!</span>
                    </div>

                    <div class="flex justify-center gap-4 mt-6">
                        <button type="button" onclick="addPictureToForm()"
                                class="bg-blue-400 px-4 py-2 rounded text-white hover:bg-blue-500">
                            Add Picture
                        </button>
                        <button type="submit"
                                class="bg-green-500 px-4 py-2 rounded text-white hover:bg-green-600">
                            Save All Pictures
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="hiddenPicturesContainer">
            @if(old('pictures'))
                @foreach(old('pictures') as $index => $picture)
                    <input type="hidden" name="pictures[{{ $index }}][question_text]"
                        value="{{ $picture['question_text'] }}">
                    <input type="hidden" name="pictures[{{ $index }}][image_url]"
                        value="{{ $picture['image_url'] }}">
                    <input type="hidden" name="pictures[{{ $index }}][correct_answer]"
                        value="{{ $picture['correct_answer'] }}">
                @endforeach
            @endif
        </div>

        <script>
            let picturesArray = [];
            let pictureCounter = 0;

            function escapeHtml(unsafe) {
                return unsafe
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            function initializeExistingPictures() {
                const hiddenInputs = document.querySelectorAll('#hiddenPicturesContainer input');
                const picturesMap = {};

                hiddenInputs.forEach(input => {
                    const name = input.getAttribute('name');
                    const matches = name.match(/pictures\[(\d+)\]\[(\w+)\]/);
                    if (matches) {
                        const index = matches[1];
                        const field = matches[2];
                        if (!picturesMap[index]) {
                            picturesMap[index] = { question_text: '', image_url: '', correct_answer: '' };
                        }
                        if (field === 'question_text') {
                            picturesMap[index].question_text = input.value;
                        } else if (field === 'image_url') {
                            picturesMap[index].image_url = input.value;
                        } else if (field === 'correct_answer') {
                            picturesMap[index].correct_answer = input.value;
                        }
                    }
                });

                const sortedIndices = Object.keys(picturesMap).sort((a, b) => a - b);
                sortedIndices.forEach(index => {
                    picturesArray.push(picturesMap[index]);
                });

                pictureCounter = picturesArray.length;
                renderPicturesPreview();
                renderHiddenPictures();
                updatePictureCounter();
            }

            function renderPicturesPreview() {
                const previewContainer = document.getElementById('picturesPreview');
                previewContainer.innerHTML = '';
                picturesArray.forEach((picture, index) => {
                    const pictureHtml = `
                        <div class="p-4 rounded-lg w-full preview-picture font1">
                            <div class="flex justify-between items-start">
                                <h3 class="font-semibold">Question ${index + 1}:</h3>
                                <button type="button" onclick="removePicture(${index})" class="text-red-500 hover:text-red-700">Remove</button>
                            </div>
                            <p class="mb-2">${escapeHtml(picture.question_text) || 'No question text provided'}</p>
                            <div class="flex gap-3 items-center">
                                <img src="${escapeHtml(picture.image_url)}" class="size-24 object-cover rounded-md">
                                <p class="font-bold text-green-400">Correct Answer: ${escapeHtml(picture.correct_answer)}</p>
                            </div>
                        </div>
                    `;
                    previewContainer.innerHTML += pictureHtml;
                });
            }

            function renderHiddenPictures() {
                const container = document.getElementById('hiddenPicturesContainer');
                container.innerHTML = '';
                picturesArray.forEach((picture, index) => {
                    const inputs = `
                        <input type="hidden" name="pictures[${index}][question_text]" value="${escapeHtml(picture.question_text)}">
                        <input type="hidden" name="pictures[${index}][image_url]" value="${escapeHtml(picture.image_url)}">
                        <input type="hidden" name="pictures[${index}][correct_answer]" value="${escapeHtml(picture.correct_answer)}">
                    `;
                    container.innerHTML += inputs;
                });
            }

            function removePicture(index) {
                picturesArray.splice(index, 1);
                renderPicturesPreview();
                renderHiddenPictures();
                updatePictureCounter();
            }

            function updatePictureCounter() {
                pictureCounter = picturesArray.length;
                document.querySelector('#pictureCounter p').textContent = `${pictureCounter} Pictures`;
            }

            document.addEventListener('DOMContentLoaded', initializeExistingPictures);

            function addPictureToForm() {
                const questionInput = document.querySelector('[name="current_question_text"]');
                const imageInput = document.querySelector('[name="current_image_url"]');
                const answerInput = document.querySelector('[name="current_correct_answer"]');

                if (!questionInput.value.trim()) {
                    document.getElementById('question-error').classList.remove('hidden');
                    return;
                }
                if (!imageInput.value.trim()) {
                    document.getElementById('input-error').classList.remove('hidden');
                    return;
                }
                if (!answerInput.value.trim()) {
                    document.getElementById('correct-error').classList.remove('hidden');
                    return;
                }

                const newPicture = {
                    question_text: questionInput.value.trim(),
                    image_url: imageInput.value.trim(),
                    correct_answer: answerInput.value.trim()
                };

                picturesArray.push(newPicture);
                renderPicturesPreview();
                renderHiddenPictures();

                questionInput.value = '';
                imageInput.value = '';
                answerInput.value = '';
                updatePictureCounter();
            }

            // Validation functions
            const title = document.getElementById('assignment-title');
            const dueDate = document.getElementById('due-date');
            const assignment = document.getElementById('assignment-error');
            const date = document.getElementById('date-error');

            function removeError() {
                assignment.classList.remove('block');
                assignment.classList.add('hidden');
                date.classList.remove('block');
                date.classList.add('hidden');
                document.getElementById('input-error').classList.add('hidden');
                document.getElementById('correct-error').classList.add('hidden');
                document.getElementById('question-error').classList.add('hidden');
            }

            function validateForm() {
                if (!title.value.trim()) {
                    assignment.classList.remove('hidden');
                    assignment.classList.add('block');
                    return false;
                }
                if (!dueDate.value.trim()) {
                    date.classList.remove('hidden');
                    date.classList.add('block');
                    return false;
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


                if(dueData.value)
                if (picturesArray.length === 0) {
                    alert('Please add at least one picture!');
                    return false;
                }
                return true;
            }
        </script>
    </form>
</body>
@endsection
