@if(session()->has('welcome_toast'))
    <div class="absolute w-[300px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-50">
        <div class="w-full h-full bg-white absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center px-4">
            <div class="h-[3rem] w-[5rem]">
                <img src="{{ asset('dashboard/icons/welcome.gif') }}" alt="Welcome">
            </div>
            <div class="kode">
                <p>Welcome Back!!</p>
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">

        </div>
    </div>

@endif

@if(session()->has('logout_toast'))
    <div class="absolute w-[300px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-[999]">
        <div class="w-full h-full bg-white absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center px-4">
            <div class="h-[3rem] w-[5rem]">
                <img src="{{ asset('dashboard/icons/welcome.gif') }}" alt="Logout">
            </div>
            <div class="kode">
                <p>Logout Successful!</p>
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">

        </div>
    </div>
@endif

@if(session()->has('active_toast'))
    <div class="absolute w-[300px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-[999]">
        <div class="w-full h-full bg-white absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center px-4">
            <div class="h-[3rem] w-[5rem]">
                <img src="{{ asset('dashboard/icons/done.gif') }}" alt="Logout">
            </div>
            <div class="kode">
                <p>Game Status Change</p>
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">

        </div>
    </div>
@endif

{{-- @if(session()->has('game_already_exists'))
    <div class="absolute w-[300px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-[999]">
        <div class="w-full h-full bg-white absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center px-4">
            <div class="h-[3rem] w-[5rem]">
                <img src="{{ asset('dashboard/icons/error.gif') }}" alt="Logout">
            </div>
            <div class="kode">
                <p>Game Already Exists</p>
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">

        </div>
    </div>

@endif --}}

{{-- @if(session()->has('game_added'))
    <div class="absolute w-[300px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-[999]">
        <div class="w-full h-full bg-white absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center px-4">
            <div class="h-[3rem] w-[5rem]">
                <img src="{{ asset('dashboard/icons/done.gif') }}" alt="Logout">
            </div>
            <div class="kode">
                <p>Game Added</p>
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">

        </div>
    </div>

@endif --}}

@if(session()->has('player_updated'))
    <div class="absolute w-[300px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-[999]">
        <div class="w-full h-full bg-white absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center px-4">
            <div class="h-[3rem] w-[5rem]">
                <img src="{{ asset('dashboard/icons/done.gif') }}" alt="Logout">
            </div>
            <div class="kode">
                <p>Player Updated</p>
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">

        </div>
    </div>
@endif

@if(session()->has('player_remove'))
    <div class="absolute w-[300px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-[999]">
        <div class="w-full h-full bg-white absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center px-4">
            <div class="h-[3rem] w-[5rem]">
                <img src="{{ asset('dashboard/icons/done.gif') }}" alt="Logout">
            </div>
            <div class="kode">
                <p>Player Remove!!</p>
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">

        </div>
    </div>

@endif

@if(session()->has('classroom-created'))
    <div class="absolute w-[250px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-50">
        <div class="w-full h-full bg-[#2A6DF4] absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center justify-center px-4">
            <div class="font1">
                <p class="text-zinc-200 font-semibold">Class Room Created!!</p>
            </div>
            <div class="h-[60px] w-[60px] absolute left-[-12%] top-[-10%]">
                <img src="{{asset('Teacher/icons/success.png')}}" class="w-full h-full -rotate-[10deg] md:-rotate-[30deg]" alt="Welcome">
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">
        </div>
    </div>
@endif

@if(session()->has('classroom-exists'))
    <div class="absolute w-[250px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-50">
        <div class="w-full h-full bg-[#F50057] absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center justify-center px-4">
            <div class="font1">
                <p class="text-zinc-200 font-semibold">Class Room Already Exists!!</p>
            </div>
            <div class="h-[60px] w-[60px] absolute left-[-12%] top-[-10%]">
                <img src="{{asset('Teacher/icons/fail.png')}}" class="w-full h-full -rotate-[10deg] md:-rotate-[30deg]" alt="Welcome">
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">
        </div>
    </div>
@endif

@if(session()->has('gameroom-created'))
    <div class="absolute w-[250px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-50">
        <div class="w-full h-full bg-[#2A6DF4] absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center justify-center px-4">
            <div class="font1">
                <p class="text-zinc-200 font-semibold">Gameroom Created!!</p>
            </div>
            <div class="h-[60px] w-[60px] absolute left-[-12%] top-[-10%]">
                <img src="{{asset('Teacher/icons/success.png')}}" class="w-full h-full -rotate-[10deg] md:-rotate-[30deg]" alt="Welcome">
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">
        </div>
    </div>
@endif


@if(session()->has('gameroom-exists'))
    <div class="absolute w-[300px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-50">
        <div class="w-full h-full bg-[#F50057] absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center justify-center px-4">
            <div class="font1">
                <p class="text-zinc-200 font-semibold">Another Gameroom with same title is found!!</p>
            </div>
            <div class="h-[60px] w-[60px] absolute left-[-12%] top-[-10%]">
                <img src="{{asset('Teacher/icons/fail.png')}}" class="w-full h-full -rotate-[10deg] md:-rotate-[30deg]" alt="Welcome">
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">
        </div>
    </div>
@endif

@if(session()->has('assignment-exists'))
    <div class="absolute w-[250px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-50">
        <div class="w-full h-full bg-[#F50057] absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center justify-center px-4">
            <div class="font1">
                <p class="text-zinc-200 font-semibold">Assignment Title Already Exists!!</p>
            </div>
            <div class="h-[60px] w-[60px] absolute left-[-12%] top-[-10%]">
                <img src="{{asset('Teacher/icons/fail.png')}}" class="w-full h-full -rotate-[10deg] md:-rotate-[30deg]" alt="Welcome">
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">
        </div>
    </div>
@endif

@if(session()->has('assignment-created'))
    <div class="absolute w-[250px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-50">
        <div class="w-full h-full bg-[#2A6DF4] absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center justify-center px-4">
            <div class="font1">
                <p class="text-zinc-200 font-semibold">Assignment Created!!</p>
            </div>
            <div class="h-[60px] w-[60px] absolute left-[-12%] top-[-10%]">
                <img src="{{asset('Teacher/icons/success.png')}}" class="w-full h-full -rotate-[10deg] md:-rotate-[30deg]" alt="Welcome">
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">
        </div>
    </div>
@endif

@if(session()->has('assignment completed'))
    <div class="absolute w-[250px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-50">
        <div class="w-full h-full bg-[#2A6DF4] absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center justify-center px-4">
            <div class="font1">
                <p class="text-zinc-200 font-semibold">Assignment Submitted!!</p>
            </div>
            <div class="h-[60px] w-[60px] absolute left-[-12%] top-[-10%]">
                <img src="{{asset('Teacher/icons/success.png')}}" class="w-full h-full -rotate-[10deg] md:-rotate-[30deg]" alt="Welcome">
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">
        </div>
    </div>
@endif

@if(session()->has('missing-id-classroom'))
    <div class="absolute w-[250px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-50">
        <div class="w-full h-full bg-[#F50057] absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center justify-center px-4">
            <div class="font1">
                <p class="text-zinc-200 font-semibold">Invalid ID</p>
            </div>
            <div class="h-[60px] w-[60px] absolute left-[-12%] top-[-10%]">
                <img src="{{asset('Teacher/icons/fail.png')}}" class="w-full h-full -rotate-[10deg] md:-rotate-[30deg]" alt="Welcome">
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">
        </div>
    </div>
@endif

@if(session()->has('already-join-classroom'))
    <div class="absolute w-[250px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-50">
        <div class="w-full h-full bg-[#e3be58] absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center justify-center px-4">
            <div class="font1">
                <p class="text-zinc-200 font-semibold">ID Already Joined!!</p>
            </div>
            <div class="h-[60px] w-[60px] absolute left-[-12%] top-[-10%]">
                <img src="{{asset('Teacher/icons/fail.png')}}" class="w-full h-full -rotate-[10deg] md:-rotate-[30deg]" alt="Welcome">
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">
        </div>
    </div>
@endif

@if(session()->has('classroom-join-sucess'))
    <div class="absolute w-[250px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-50">
        <div class="w-full h-full bg-[#2A6DF4] absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center justify-center px-4">
            <div class="font1">
                <p class="text-zinc-200 font-semibold">Classroom Joined!!</p>
            </div>
            <div class="h-[60px] w-[60px] absolute left-[-12%] top-[-10%]">
                <img src="{{asset('Teacher/icons/success.png')}}" class="w-full h-full -rotate-[10deg] md:-rotate-[30deg]" alt="Welcome">
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">
        </div>
    </div>
@endif

@if (session()->has('game-played'))
    @php
    $playedData = session('game-played');
    @endphp
    <div class="absolute w-[300px] h-[80px] right-[-100%] top-8 toast-container transition-all duration-300 ease-linear z-50">
        <div class="w-full h-full bg-[#2A6DF4] absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center justify-center px-6">
            <div class="font1">
                <p class="text-zinc-200 font-semibold">
                    You played <strong>{{ $playedData['game'] }}</strong> and scored <strong>{{ $playedData['score'] }}</strong>!
                </p>
            </div>
            <div class="h-[60px] w-[60px] absolute left-[-12%] top-[-10%]">
                <img src="{{ asset('Teacher/icons/success.png') }}" class="w-full h-full -rotate-[10deg] md:-rotate-[30deg]" alt="Success">
            </div>
        </div>
        <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">
        </div>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toast = document.querySelector('.toast-container');
    if (toast) {
        showToast();
        setTimeout(hideToast, 4000); // Adjust the time as needed
    }
});

function showToast() {
    const toast = document.querySelector('.toast-container');
    toast.classList.remove('right-[-100%]');
    toast.classList.add('right-4');
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('opacity-100'), 10);
}

function hideToast() {
    const toast = document.querySelector('.toast-container');
    toast.classList.remove('right-4');
    toast.classList.add('right-[-100%]');
    toast.classList.remove('opacity-100');
    // toast.classList.add('hidden');
    // Optional: Hide after transition if you want
    setTimeout(() => toast.classList.add('hidden'), 300);
}
</script>
