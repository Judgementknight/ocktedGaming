@extends('TeacherDashboard.teacher-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body>

<h1>HELLO THIS IS JOIN ROOM FORM</h1>
<h1>JOINING ROOM {{$code}}</h1>
<form action="{{route('join-room')}}" method="POST">
    <input class="border-2 border-black" type="text" name="student_id" placeholder="enter your student ID">
    <input type="hidden" value="{{$code}}" name="gameroom_code">
    <button class="border-2 border-black bg-red-300" type="submit">JOIN ROOM</button>
</form>
</body>


@endsection
