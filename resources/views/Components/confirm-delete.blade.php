{{-- active status player component --}}

<div id="confirm-delete-modal" class="absolute left-[50%] hidden top-[35%] translate-x-[-50%] w-[500px] h-[200px] round z-[999] round">

        <div class="w-full h-full bgwhite1  absolute z-20 round border-[1px] border-black/50 gap-3">
            <div class="w-full h-[70px] flex items-center justify-center">
                <h1 class="kode">CONFIRM REMOVING PLAYER??</h1>


                <form class="remove-player">
                <input type="hidden" name="game_token" id="remove-token" value="">
            </div>
            <div class="flex justify-center items-center w-full h-[130px] gap-10">
                <button type="submit" class="px-3 py-2 border-[1px] border-black bg-red-500 kode">Remove</button>
                </form>

                <button id="close-modal" class="px-3 py-2 border-[1px] border-black bg-lime-500 kode">Cancel</button>
            </div>
        </div>

    <div class="w-full h-full absolute bg-black/50 translate-x-2 translate-y-1 round"></div>
</div>


