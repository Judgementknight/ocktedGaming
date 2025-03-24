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

@if(session()->has('game_already_exists'))
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

@endif

@if(session()->has('game_added'))
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

@endif

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
