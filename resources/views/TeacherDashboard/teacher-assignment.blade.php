@extends('TeacherDashboard.teacher-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<style>
    th{
        padding: 0px 10px;
        color: #a1a1aa;
    }

    td{
        padding: 0px 10px;
        height: 50px;
    }
</style>
<body>
    <x-teacher-navbar />
    <div class="w-full h-full fixed top-0 left-0 -z-30">
        <img class="w-full h-full object-cover" src="{{asset('Teacher/bg3.jpg')}}">
    </div>
    <div class="w-full h-[80px] px-4 lg:px-10 flex items-center font1">
        <a href="{{route('classroom-details', ['classroom_code' => $combinedData['Classroom Code']])}}">
        <div class="flex items-center gap-2">
                <div class="w-[30px] h-[30px] rounded-[50%] transition-all ease-in duration-200 hover:cursor-pointer hover:bg-pink-500 flex items-center justify-center">
                    <img src="{{asset('Teacher/icons/back.png')}}" class="w-[75%] h-[75%]">
                </div>
                <p class="font1 text-zinc-500 font-medium">Back to Classroom</p>
            </div>
        </a>
    </div>
    <div class="h-[4px] w-full px-4 lg:px-12">
        <div class="h-full w-full rounded-lg bg-[#2A6DF4] "></div>
    </div>
    <div class="px-4 lg:px-12 flex items-start w-full flex-col h-[100px] justify-center">
        <h1 class="font1 text-3xl font-bold text-zinc-800">{{$Assignment->assignment_title}}</h1>
        {{-- <p class="text-zinc-600 font1 font-semibold text-lg ">Class 6</p> --}}
    </div>
    <div class="px-4 lg:px-12 w-full h-[100px] font1 flex flex-col justify-center gap-3">
        <p class="font-bold text-zinc-800 text-lg">Assignment Details</p>
        <div class="flex items-center gap-1">
            <img class="size-4" src="{{asset('Teacher/icons/time.png')}}">
            <p class="text-zinc-700">Due: {{$Assignment->due_date}}</p>
        </div>
        <div class="flex items-center gap-1">
            <img class="size-4" src="{{asset('Teacher/icons/group.png')}}">
            <p class="text-zinc-700">{{$combinedData['Total Student']}} students assigned</p>
        </div>
    </div>

    <div class="w-full mt-16 h-[40px] px-4 lg:px-12 font1 flex items-center ">
        <h1 class="text-2xl text-zinc-600 font-semibold">Student Submissions</h1>
    </div>

    <div class="min-w-[30vh] md:w-full overflow-hidden overflow-x-scroll h-auto px-4 lg:px-12">
        <table class="w-[70vh] md:w-full font1">
            <tr class="text-left h-[50px]">
                <th>Student Name</th>
                <th>Status</th>
                <th>Score</th>
                <th>Submitted On</th>
            </tr>
            @foreach ($Students as $student )
            <tr>
                <td>{{$student->student_name}}</td>
                <td>
                    @if (!empty($student->assignment_status) && $student->assignment_status == 'completed')
                    <div class="flex items-center gap-1">
                        <img class="size-5" src="{{asset('Teacher/icons/done.png')}}">
                        <p class="text-green-400">Completed</p>
                    </div>
                    @elseif ($student->assignment_status == 'overdue')
                        <div class="flex items-center gap-1">
                            <img class="size-5" src="{{asset('Teacher/icons/overdue.png')}}">
                            <p class="text-[#FF0000]">Overdue</p>
                        </div>
                    @else
                        <div class="flex items-center gap-1">
                            <img class="size-5" src="{{asset('Teacher/icons/pending.png')}}">
                            <p class="text-[#F59E0B]">Pending</p>
                        </div>
                    @endif
                </td>
                <td>
                    @if (!empty($student->score))
                        <p>{{$student->score}}</p>
                    @else
                        <p>0</p>
                    @endif
                </td>
                <td>
                    <p>{{$student->submitted_at ?? 'N/A'}}</p>
                </td>
            </tr>
            @endforeach


        </table>
    </div>

</body>

@endsection
