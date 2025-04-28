@extends('TeacherDashboard.teacher-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body>
    <x-toast/>
  <div class="w-full h-full fixed top-0 left-0 -z-30">
      <img class="w-full h-full object-cover" src="{{ asset('Teacher/bg3.jpg') }}">
  </div>
  <div class="w-screen h-screen flex items-center justify-center font1">
      <div class="w-[400px] h-[300px] rounded-md p-3 bg-[#F7C5D6]">
          <h1 class="font1 text-center text-xl text-zinc-800">Join {{ $classroom->classroom_title }}</h1>
          <p class="text-center mt-2">{{ $classroom->classroom_description }}</p>
          <p class="text-center mt-2">Teacher: {{ $classroom['teacher']['teacher_name'] }}</p>
          <!-- Adding novalidate disables default HTML validation -->
          <form id="joinClassroomForm" action="{{ route('join-room') }}" method="POST" novalidate>
              @csrf
              <div class="flex flex-col h-[200px] justify-center w-full">
                  <input
                      id="studentIdInput"
                      class="border-2 border-black h-[50px] rounded-md px-1"
                      type="text"
                      name="student_id"
                      placeholder="Enter your Student ID"
                      oninput="hideError()"
                  >
                  <!-- Custom error message element -->
                  <span id="studentIdError" class="error-message hidden">
                      Please enter your Student ID to join the classroom.
                  </span>
                  <input type="hidden" value="{{ $classroom->classroom_code }}" name="classroom_code">
                  <button class="border-2 border-black mt-10 h-[50px] hover:bg-[#F7C5D6] hover:text-white transition-all duration-200 ease-linear text-zinc-800 bg-[#ffff]" type="submit">
                      JOIN CLASSROOM
                  </button>
              </div>
          </form>
      </div>
  </div>

  <script>
      // Custom validation on form submission
      document.getElementById('joinClassroomForm').addEventListener('submit', function(event) {
          const studentInput = document.getElementById('studentIdInput');
          const errorSpan = document.getElementById('studentIdError');

          // Clear any previous custom validity.
          studentInput.setCustomValidity('');
          errorSpan.classList.add('hidden');
          studentInput.classList.remove('input-error');

          // Check custom rule: field must not be empty
          if (!studentInput.value.trim()) {
              // Prevent form submission
              event.preventDefault();
              // Set custom validity (not strictly needed since we're not using HTML native messages)
              studentInput.setCustomValidity('Please enter your Student ID to join the classroom.');
              // Display our custom error message and add error styling
              errorSpan.classList.remove('hidden');
              studentInput.classList.add('input-error');
          }
      });

      // Custom oninput handler to hide the error message as soon as the user starts typing
      function hideError() {
          const errorSpan = document.getElementById('studentIdError');
          const studentInput = document.getElementById('studentIdInput');
          errorSpan.classList.add('hidden');
          studentInput.classList.remove('input-error');
          studentInput.setCustomValidity('');
      }
  </script>

  <style>
      .error-message {
          color: red;
          font-size: 0.875rem;
          margin-top: 0.5rem;
      }
      .hidden {
          display: none;
      }
      .input-error {
          border-color: red;
      }
  </style>
</body>
@endsection
