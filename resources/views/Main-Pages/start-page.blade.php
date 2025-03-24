@extends('Main-Pages.main-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<body id="body" class="overflow-hidden w-screen h-screen filter contrast-0">
    <div class="absolute top-0 left-0 -z-10 w-full h-full ">
        <img class="w-full h-full" src="{{asset('pfp/bg4.png')}}">
    </div>
    <div id="loader" class="w-full h-full absolute glass left-0 top-0 flex items-center justify-center ">
        <div class="">
            <h1 id="text" class="font1 text-4xl lg:text-[10rem] text-white opacity-0">
              OCKTED GAMING
            </h1>
        </div>
    </div>
    <div id="main" class="w-[400px] h-[400px] glass absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%]">
        <div class="w-full h-[100px] flex items-center justify-center">
            <h1 class="font1 text-4xl text-white">Welcome To Ockted Gaming</h1>
        </div>
        <form class="add-form-group" enctype="multipart/form-data">
            <div  class="w-full h-[300px] flex flex-col gap-5">
                <div class="w-full h-[150px] flex flex-col gap-2 items-center justify-center">
                    <label for="imageInput" class="w-[100px] h-[100px] glass p-2 relative cursor-pointer">
                        <!-- Hidden file input -->
                        <input type="file" name="profile_picture" accept="image/*" id="imageInput" class="hidden active:scale-75 transition-all duration-100 ease-linear">
                        <!-- Icon overlay -->
                        <img id="add-logo" class="absolute size-6 bottom-9 right-9" src="{{ asset('pfp/add.png') }}" alt="Add Icon">
                        <img id="imagePreview" name="profile_picture" value="" src="" class="object-cover w-full h-full hidden rounded-[5px]">
                    </label>
                    <p class=" text-white text-sm font1 bottom-1 left-4">Profile Picture</p>
                </div>
                <div class="w-full h-[100px] justify-center items-center flex flex-col ">
                    <div class="">
                        <input class="font1 text-white glass px-2 w-[250px] h-[40px] outline-none" placeholder="Enter Username...." type="text" name="ockted_username">
                    </div>
                    <div class="w-full h-[50px] flex items-center justify-center mt-3">
                        <button type="submit" class="px-3 py-2 font1 text-white glass active:scale-90 animate" type="submit" name="username">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    {{-- <h1>HELLO THIS IS START PAGE</h1> --}}
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

            let response = await fetch(" {{route('create-ockted-user')}} ", {
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
