{{-- active status player component --}}

<div id="active-user-modal" class="absolute hidden left-[50%] top-[15%] translate-x-[-50%] w-[500px] h-[600px] border-[1px] border-black/50 round z-[999] round">
    <div class="w-full h-full bgwhite1 round absolute z-50">
        <div class="flex justify-between items-center px-2 w-full h-[50px] border-b-[1px] border-black/50">
            <h1 class="anton text-3xl">EDIT PLAYER</h1>
            <button id="close-modal-button" class="kode px-3 py-1 round border-[1px] hover:bg-black hover:text-white border-black/50">Close</button>
        </div>
        <form class="add-form-group">
            <div class="w-full h-[400px] round flex flex-col gap-[10px]">
                {{-- img section --}}
                <div class="w-full h-[200px] mt-2 flex items-center justify-center relative">
                    <div class="w-[40%] h-[180px] round">
                        <img id="profile-picture" class="w-full h-full round object-cover" src="">
                    </div>
                </div>
                {{-- TEXT SECTION --}}
                <div class="w-full h-[50px] mt-3 flex items-center justify-center gap-[3%] px-[2%]">
                    <div class="w-full h-[50px] bggray round px-2 flex items-center">
                        <div class="w-[40%]">
                            <h1 class="kode">Player Username:</h1>
                        </div>
                        <div class="w-[70%] h-[80%]">
                            <input name="username" type="text" class="kode w-full h-full bggray px-2" id="username" placeholder="">
                        </div>
                    </div>
                </div>
                <input type="hidden" id="game-token" name="game_token" value="">
{{--
                <div class="w-full h-[50px] mt-2 flex items-center justify-center gap-[3%] px-[2%]">
                    <div class="w-full h-[50px] bggray round px-2 flex items-center">
                        <div class="w-[25%]">
                            <h1 class="kode">GAME TOKEN:</h1>
                        </div>
                        <div class="w-[70%] h-[80%]">
                            <input name="game_token" id="game-token" class="kode w-full h-full bggray px-2" type="text" placeholder="">
                        </div>
                    </div>
                </div> --}}

                <div class="w-full h-[50px] mt-2 flex items-center justify-center gap-[3%] px-[2%]">
                    <div class="w-full h-[50px] bggray round px-2 flex items-center">
                        <div class="w-[25%]">
                            <h1 class="kode">School Code:</h1>
                        </div>
                        <div class="w-[70%] h-[80%]">
                            <input type="text" name="school_code" class="kode w-full h-full bggray px-2" id="school-code" placeholder="">
                            {{-- <h1 id="school-code" class="kode"></h1> --}}
                        </div>
                    </div>
                </div>

                <div class="w-full h-[50px] mt-2 flex items-center justify-center gap-[3%] px-[2%]">
                    <div class="w-full h-[50px] bggray round px-2 flex items-center">
                        <div class="w-[25%]">
                            <h1 class="kode">Assign Rank:</h1>
                        </div>
                        <div class="w-[70%] h-[80%]">
                            <input type="text" name="rank" class="kode w-full h-full bggray px-2" id="school-code" placeholder="Ex. Bronze, Silver, Gold">
                            {{-- <h1 id="school-code" class="kode"></h1> --}}
                        </div>
                    </div>
                </div>

                <div class="w-full h-[50px] mt-2 flex items-center justify-center gap-[3%] px-[2%]">
                    <div class="w-full h-[50px] bggray round px-2 flex items-center">
                        <div class="w-[35%]">
                            <h1 class="kode">Current Status:</h1>
                        </div>
                        <div class="w-[65%]">
                            <h1 id="user-status" class="kode"></h1>
                        </div>
                    </div>
                </div>

                <div class="w-full h-[100px] mt-2 flex items-center justify-center gap-[3%] px-[2%]">
                    <div class="w-full h-[50px] round px-2 flex justify-center gap-[10px] items-center">
                        <div class="">
                            <button type="submit" class="px-3 py-2 border-[1px] bg-[#7bfbaa] kode border-black rounded-[5px] active:scale-75 animate">Update Player Profile</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="h-full w-full bg-black/50 translate-x-2 translate-y-1 round absolute">

    </div>
</div>


