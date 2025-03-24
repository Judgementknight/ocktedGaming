{{-- active status games component --}}

<div id="active-game-modal" class="absolute hidden left-[50%] top-[20%] translate-x-[-50%] w-[500px] h-[500px] border-[1px] border-black/50 round z-[999] round">
    <div class="w-full h-full bgwhite1 round absolute z-50">
        <div class="flex justify-between items-center px-2 w-full h-[50px] border-b-[1px] border-black/50">
            <h1 class="anton text-3xl">EDIT GAME</h1>
            <button id="close-modal-button" class="kode px-3 py-1 round border-[1px] hover:bg-black hover:text-white border-black/50">Close</button>
        </div>

            <div class="w-full h-[400px] round">
                {{-- img section --}}
                <div class="w-full h-[200px] flex items-center justify-center relative">
                    <div class="w-[80%] h-[180px] round">
                        <img id="game-banner" class="w-full h-full round object-cover" src="">
                    </div>
                </div>
                {{-- TEXT SECTION --}}
                <div class="w-full h-[50px] mt-3 flex items-center justify-center gap-[3%] px-[2%]">
                    <div class="w-full h-[50px] bggray round px-2 flex items-center">
                        <div class="w-[25%]">
                            <h1 class="kode">GAME TITLE:</h1>
                        </div>
                        <div class="w-[70%]">
                            <h1><h1 id="game-title" class="kode"></h1></h1>
                        </div>
                    </div>
                </div>

                <div class="w-full h-[50px] mt-2 flex items-center justify-center gap-[3%] px-[2%]">
                    <div class="w-full h-[50px] bggray round px-2 flex items-center">
                        <div class="w-[25%]">
                            <h1 class="kode">GAME CODE:</h1>
                        </div>
                        <div class="w-[70%]">
                            <h1><h1 id="game-code" class="kode"></h1></h1>
                        </div>
                    </div>
                </div>
                <div class="w-full h-[50px] mt-2 flex items-center justify-center gap-[3%] px-[2%]">
                    <div class="w-full h-[50px] bggray round px-2 flex items-center">
                        <div class="w-[35%]">
                            <h1 class="kode">Current Status:</h1>
                        </div>
                        <div class="w-[65%]">
                            <h1 id="game-status" class="kode"></h1>
                        </div>
                    </div>
                </div>
                <form class="add-form-group">
                    <input id="input-game-code" type="hidden" name="game_code" value="">
                    <input id="input-game-status" type="hidden" name="game_status" value="">

                <div class="w-full h-[50px] mt-2 flex items-center justify-center gap-[3%] px-[2%]">
                    <div class="w-full h-[50px] round px-2 flex justify-center gap-[10px] items-center">
                        <div class="">
                            <button type="submit" id="set-active" class="px-3 py-2 border-[1px] bg-[#7bfbaa] kode border-black rounded-[5px] active:scale-75 animate">Change Game Status</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="h-full w-full bg-black/50 translate-x-2 translate-y-1 round absolute">

    </div>
</div>

<script>


</script>
