@extends('Student.student-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body>
    <x-student-navbar :picture="$student['student']['profile_picture'] ?? ''"/>
    <x-toast/>
    <x-student-profile :picture="$student['student']['profile_picture'] ?? ''" :name="$student['student']['student_name'] ?? ''" :rank="$student['student']['rank']" :totalscore="$combinedData['Total Score']"/>
    <div class="w-full h-full fixed top-0 left-0 -z-30">
        <img class="w-full h-full object-cover filter contrast-less:" src="{{asset('Teacher/bg3.jpg')}}">
    </div>
    <div class="px-4 lg:px-10 w-full h-[120px] gap-5 lg:gap-0 flex flex-col lg:flex-row items-center justify-center lg:justify-between font1">
        <div class="justify-center text-center lg:text-left flex-col w-full ">
            <h1 class="font-bold text-3xl text-zinc-800">{{$student['student']['student_name']}} Dashboard</h1>
            <p class="text-center lg:text-left text-md text-zinc-500">View your classes and assignments</p>
        </div>
    </div>

    <section class="font1">
        <div class="w-full bg-white md:h-[130px] lg:h-[100px]  flex justify-center lg:px-10 px-4">
            <div class="grid gap-5 md:gap-3  md:grid-cols-2 lg:grid-cols-4 px-4 w-full ">
                <div class="w-full h-full flex items-center gap-3">
                    <div class="w-[50px] h-[40px] rounded-[50%] bg-[#2776F9] flex items-center justify-center">
                        <img class="size-6" src="{{asset('Teacher/icons/classroom.png')}}">
                    </div>
                    <div class="w-full flex flex-row items-center md:items-start justify-between md:flex-col my-3">
                        <h1 class="text-md font-light text-zinc-700">My Classes</h1>
                        <p class="text-xl lg:text-2xl font-medium text-zinc-800">{{$combinedData['Total Classroom']}}</p>
                    </div>
                </div>
                <div class="w-full h-full flex items-center gap-3">
                    <div class="w-[50px] h-[40px] rounded-[50%] bg-[#F59E0B] flex items-center justify-center">
                        <img class="size-6" src="{{asset('Teacher/icons/newassign.png')}}">
                    </div>
                    <div class="w-full flex flex-row items-center md:items-start justify-between md:flex-col">
                        <h1 class="font-light text-md text-zinc-500">Total Assignments</h1>
                        <p class="text-xl lg:text-2xl font-medium text-zinc-800">{{$combinedData['Total Assignment']}}</p>
                    </div>
                </div>
                <div class="w-full h-full flex items-center gap-3">
                    <div class="w-[50px] h-[40px] rounded-[50%] bg-[#10B981] flex items-center justify-center">
                        <img class="size-6" src="{{asset('Teacher/icons/complete.png')}}">
                    </div>
                    <div class="w-full flex flex-row items-center md:items-start justify-between md:flex-col">
                        <h1 class="font-light text-md text-zinc-500">Completed</h1>
                        <p class="text-xl lg:text-2xl font-medium text-zinc-800">{{$combinedData['Assignment Completed']}}</p>
                    </div>
                </div>
                <div class="w-full h-full flex items-center gap-3">
                    <div class="w-[50px] h-[40px] rounded-[50%] bg-[#F43F5E] flex items-center justify-center">
                        <img class="size-6" src="{{asset('Teacher/icons/time2.png')}}">
                    </div>
                    <div class="w-full flex flex-row items-center md:items-start justify-between md:flex-col">
                        <h1 class="font-light text-md text-zinc-500">Pending</h1>
                        <p class="text-xl lg:text-2xl font-medium text-zinc-800">{{$combinedData['Assignment Pending']}}</p>
                    </div>
                </div>
            </div>




        </div>
    </section>

    <section class="font1 mt-4 lg:mt-0">
        <div class="w-full h-[50px] items-center flex flex-col gap-5 lg:gap-0 lg:flex-row px-4 lg:px-10">
            <h1 class="w-full font-bold text-2xl text-center lg:text-left text-zinc-700">My Classes</h1>
            <div class="w-full flex justify-end">
                {{-- <div class="w-full lg:w-[300px] h-[40px] relative">
                    <img src="{{asset('Teacher/icons/search.png')}}"  class="absolute size-6 left-2 top-2">
                    <input placeholder="Search Classroom..." class="ring-none focus:ring-none w-full h-full px-9 rounded-lg text-zinc-600">
                </div> --}}
            </div>
        </div>
        <div class="w-full h-[300px] grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 px-4 lg:px-10 mt-5">

            @if (isset($combinedData['Classrooms']) && count($combinedData['Classrooms']) > 0)
                @foreach ($combinedData['Classrooms'] as $key=>$class)
                <a href="{{route('view-classroom-assignment', ['classroom_code' => $class['classroom_code']])}}">
                <div class="w-full bg-white shadow-lg h-[230px] lg:h-[200px] relative rounded-lg">
                    <div class="w-full h-[15px] rounded-t-lg" style="background-color: {{$class['classroom_color']}}"></div>
                    <div class="flex flex-col px-3 py-2">
                        <h1 class=" text-2xl font-semibold text-zinc-800">{{$class['classroom_title']}}</h1>
                        <p>{{$class['classroom_description']}}</p>
                        <div class="mt-4 flex flex-col lg:flex-row gap-2 lg:gap-10">
                            <div class="flex gap-2 items-center"><img class="size-4" src="{{asset('Teacher/icons/assignment.png')}}"><p>{{$class['assignments_count']}} Assignments</p></div>
                            <div class="flex gap-2 items-center"><img class="size-4" src="{{asset('Teacher/icons/students.png')}}"><p>{{$class['students_count']}} Students</p></div>
                        </div>
                        <div class="flex justify-end mt-3 lg:mt-5">
                            <button class="w-[150px] h-[40px] rounded-sm bg-[#0d1b2a] text-zinc-100">View Assignments</button>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <p>No Classrooms</p>
            @endif
        </div>
    </section>

</body>

@endsection



