@extends('TeacherDashboard.teacher-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body>

<h1>HELLO THIS IS GAME ROOM DETAILS</h1>
<h1>{{$roomDetails['Room Link']}} COPY THIS LINK</h1>
    @foreach ($roomDetails['Students']['students'] as $key => $student)
        <h1>{{ $student['student_id'] }}</h1>
        <h1>{{ $student['student_name'] }}</h1>
    @endforeach
</body>


@endsection
