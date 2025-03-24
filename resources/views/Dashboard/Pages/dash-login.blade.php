@extends('Dashboard.dash-layout')

@section('OCKTED GAMING')  <!-- Overriding the title with dynamic game title -->

@section('content')
<x-toast/>
<body class="h-screen w-full flex items-center justify-center bgwhite1 relative overflow-hidden md:px-0">
    <div class="w-[300px] absolute lg:top-0 xxl:top-14 left-[50%] translate-x-[-50%] h-[100px]">
        <img src="{{asset('dashboard/logo2.png')}}">
    </div>
    <div class="w-[340px] h-[500px] absolute rotate-[15deg] round bottom-[-20%] left-[-5%]">
        <img class="w-full h-full round" src="{{asset('dashboard/bg.jpg')}}">
    </div>
    <div class="w-[340px] h-[500px] absolute rotate-[220deg] round top-[-15%] right-[-5%]">
        <img class="w-full h-full round" src="{{asset('dashboard/login.webp')}}">
    </div>
    <div class="md:w-[550px] w-[400px] h-[600px] border-[1px] border-black/50 bgwhite1 round absolute z-20">
        <div class="h-[150px] w-full flex items-center justify-center">
            <p class="w-[50%] text-center kode text-xl text-black">Log In To Ockted Gaming</p>
        </div>
        <form  action="{{route('login-verify')}}" method="POST">
            @csrf
            <div class="h-[300px] w-full round flex flex-col gap-[47px] px-[46px]">
                <div class="h-[100px] w-full bggray">
                    <input name="username" class="w-full h-full bggray px-4 text-black" placeholder="Enter Amin Username...." type="text">
                </div>
                <div class="h-[100px] w-full bggray">
                    <input name="password" type="password" class="w-full h-full bggray px-4 text-black" placeholder="Enter Password...." type="text">
                </div>
                <div class="h-[50px] flex items-center justify-end w-full gap-2">
                    <p class="kode text-black">Remember Me</p><input name="remember" class="rounded-none" type="checkbox">
                </div>
            </div>

            <div class="h-[50px] w-full mt-5 flex items-center justify-center">
                <button type="submit" class="kode w-[100px] h-[30px] border-[1px] border-black/60 bg-green-400 transition-all ease-in duration-100 active:scale-90">Login</button>
            </div>
        </form>
    </div>
    <div class="md:w-[550px] w-[400px] h-[600px] bg-black/50 round translate-x-2 translate-y-1"></div>

</body>
@endsection
