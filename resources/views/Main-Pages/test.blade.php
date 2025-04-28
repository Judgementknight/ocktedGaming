@extends('TeacherDashboard.teacher-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body id="body" class="overflow-hidden w-screen h-screen filter contrast-0">
    <x-student-welcome-navbar/>
    <div class="w-full h-full fixed top-0 left-0 -z-30">
        <img class="w-full h-full object-cover" src="{{asset('Teacher/bg2.jpg')}}">
    </div>
    <div class="w-full h-screen font1 flex flex-col items-center justify-center">
        <div class="flex md:flex-row flex-col items-center">
            <h1 class="text-6xl text-center md:text-7xl font-bold">Welcome to <span class="text-[#2A6DF4] font-extrabold">OCKTED GAMING</span></h1>
            <img class="size-16" src="{{asset('Teacher/icons/peace.gif')}}">
        </div>

        <form action="{{ route('test-data') }}" method="POST">
            @csrf
            <button type="submit" name="teacher" value="teacher">TEACHER</button>
            <button type="submit" name="student" value="student" >STUDENT</button>

        </form>
        <a href="{{route('create-ockted-student')}}">
            <div class="mt-10 w-[200px] h-[50px] relative hover:cursor-pointer">
                <div class="w-full h-full bg-zinc-800 absolute translate-x-1 translate-y-2 rounded-sm"></div>
                <div class="w-full h-full bg-[#2A6DF4] absolute flex items-center justify-evenly px-2 rounded-sm">
                    <button class=" text-white">GET STARTED</button>
                    <img src="{{asset('Teacher/icons/arrow.png')}}" class="size-10">
                </div>
            </div>
        </a>

    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loader = document.getElementById('loader');
        const text = document.getElementById('text');
        const body = document.getElementById('body');
        const main = document.getElementById('main');

        tl = gsap.timeline();

        tl.to(body,{
            filter: "contrast(1)",
            duration: 0.4,
        })

        gsap.matchMedia().add("(min-width: 768px)", () => {
            tl.to(text, {
                duration: 2,
                opacity: 1,
                x: 40,
            });
        });

        gsap.matchMedia().add("(max-width: 767px)", () => {
            tl.to(text, {
                duration: 2,
                opacity: 1,
                x: 10, // Less movement on small screens
            });
        });

        tl.to(loader, {
            // delay: 1,
            duration: 1,
            y: '-100%',
        });

        tl.from(main, {
            opacity: 0,
            duration: 3,
            y: 30,
        });

        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const addLogo = document.getElementById('add-logo');

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if(file){
                const reader = new FileReader();
                reader.onload = function(e) {

                    imagePreview.src = e.target.result;
                    imagePreview.value = e.target.result;

                    imagePreview.classList.remove('hidden');
                    addLogo.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        document.querySelectorAll('.add-form-group').forEach(form => {
            form.addEventListener('submit', async () => {
                console.log('Click');
                let formData = new FormData(form);
                let token = "{{session('User Data')}}";
                let csrf = "{{csrf_token()}}";

                let response = await fetch(" {{route('create-ockted-teacher')}} ", {
                    method: 'POST',
                    headers:{
                        'Authorization': "Bearer " + token,
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: formData,
                });

                let result = response.json();
                if(response.ok){
                    console.log('Data Sent');
                }else{
                    console.error('Data Not Sent');
                }
            });
        });
    });


</script>


@endsection
