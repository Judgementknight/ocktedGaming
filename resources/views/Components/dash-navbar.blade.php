<div class="w-full h-[100px] flex justify-between items-center lg:pl-5 px-2 lg:pr-10">
    <div class="lg:w-[70px] w-[100px] relative h-[70px] rounded-[50%] ">
        <img class="h-full w-full round2 object-cover" src="{{asset('dashboard/admin.jpg')}}">
    </div>
    <div class="w-[300px] relative h-[100px] ">
        <img class="w-full h-full" src="{{asset('dashboard/logo2.png')}}">
    </div>
    <div class="kode">
        <h1>Role: Admin</h1>
        <form action="{{route('logout')}}" method="POST">
            <button class="border-[1px] border-black/50 rounded-[5px] px-2 hover:bg-black/50 hover:text-white animate active:scale-90" type="submit">Logout</button>
        </form>
    </div>
</div>
