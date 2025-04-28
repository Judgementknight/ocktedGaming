{{-- PROFILE MODAL --}}
<div id="profile-modal" class="w-full h-screen hidden rounded-lg z-[999] items-center justify-center fixed top-0">
    <div class="w-[90%] md:w-[60%] lg:w-[40%] bg-white h-[350px] absolute z-10 rounded-lg font1 py-5 px-5">
        <header class="w-full flex justify-between">
            <div class="flex items-center gap-2">
                <img src="{{ $picture }}" class="w-[50px] h-[50px] object-cover rounded-full">
                <p class="text-zinc-700 text-xl font-bold">{{ $name }} Profile</p>
            </div>
            <img onclick="closeModal()" src="{{ asset('Teacher/icons/cross.png') }}" class="size-6 bg-[#2A6DF4] hover:cursor-pointer">
        </header>
        <div class="">

        </div>
        <div class="w-full h-[100px] bg-[#D9D9D9] mt-8 px-10 flex items-center rounded-md">
            <p class="text-md sm:text-2xl md:text-3xl font-bold text-zinc-700">Total Score Achieved: {{ $totalscore }}</p>
        </div>

        <div class="w-full h-[100px] bg-[#D9D9D9] mt-5 px-10 flex items-center rounded-md">
            <p class="text-md sm:text-2xl md:text-3xl font-bold text-zinc-700">Current Rank: {{$rank}}</p>
        </div>
    </div>
    <div class="w-[90%] md:w-[60%] lg:w-[40%] h-[350px] bg-[#2A6DF4] rounded-lg absolute translate-x-1 translate-y-1">
    </div>
</div>

<script>
    const profileModal = document.getElementById('profile-modal');
    function toggleStudentProfile() {
        console.log('click');
        profileModal.classList.remove('hidden');
        profileModal.classList.add('flex');
    }

    function closeModal() {
        profileModal.classList.add('hidden');
        profileModal.classList.remove('flex');
    }
</script>
