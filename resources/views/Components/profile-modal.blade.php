<div id="profile-modal" class="w-full h-full fixed hidden opacity-0 left-0 z-20 bg-red-400 items-center justify-center transition-all duration-200 ease-in">
    <div class="w-full md:w-[700px] h-[400px] glass border-2 px-4 py-4 font1 text-white bg-red-300 relative">
        <div class="w-full h-[50px] flex items-center justify-between">
            <div class="">
                <h1 class="text-4xl">Profile</h1>
            </div>
            <div class="h-[40px] w-[40px] rounded-[5px] relative">
                <img class="w-full h-full rounded-[5px] object-cover" src="{{$picture}}"/>
            </div>
        </div>
        <div class="w-full mt-3 h-[100px] bg-amber-400/25 glass text-center rounded-[5px] flex items-center justify-center">
            <h1 class="text-4xl">TOTAL SCORE ACHIEVED: {{$total}}</h1>
        </div>
        <div class="w-full mt-3 h-[100px] bg-amber-400/25 glass text-center rounded-[5px] flex items-center justify-center">
            <h1 class="text-4xl">CURRENT RANK: {{$rank ?? 'refresh'}}</h1>
        </div>
        <div class="flex items-center justify-center mt-8 active:scale-75 transition-all duration-200 ease-in text-center rounded-[5px]">
            <button onclick="closeProfileModal()" class="hover:bg-black/20 px-3 py-2 rounded-[5px] transition-all duration-200 ease">Cancel</button>
        </div>
    </div>
</div>

<script>
    const profileModal = document.getElementById('profile-modal');

    function openProfileModal(){
        profileModal.classList.remove('hidden');
        profileModal.classList.add('flex');
        gsap.to(profileModal, {
            opacity: 1,
            duration: 0.1,
        })
    }

    function closeProfileModal(){

        profileModal.classList.remove('flex');
        profileModal.classList.add('hidden');
        profileModal.classList.add('opacity-0');
        profileModal.classList.remove('opacity-100');

    }
</script>
