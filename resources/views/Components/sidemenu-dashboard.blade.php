<div id="sidemenu" class="fixed bg-white h-full w-[300px] lg:w-[480px] hidden lg:block border-[1px] border-black/50 top-0 z-[999] right-[-100%] round overflow-hidden transition-all duration-500 ease-linear">
    <div class="w-full h-[70px] flex items-center px-2 justify-between border-b-[1px] border-black/50 py-2">
        <h1 class="anton text-3xl">ADD GAME</h1>
        <div class="w-[100px] h-[40px] animate hover:bg-black hover:text-white round active:scale-90">
            <button class="kode border-[1px] w-full h-full border-black/50 round" id="close-sidemenu">Close</button>
        </div>
    </div>
        <form class="add-game-form">
            <div class="w-full h-auto flex flex-col gap-[30px]">

                <div class="w-full h-[50px] mt-5 px-5 kode">
                    <label>Game Title</label>
                    <input name="game_title" placeholder="Insert Game Title..." class="w-full h-full px-2 border-[1px] border-black/50 round">
                </div>
                <div class="w-full h-[100px] mt-5 px-5 kode">
                    <label>Game Description (Optional)</label>
                    <textarea name="game_description" placeholder="Description..." class="w-full h-full px-2 py-2 border-[1px] border-black/50 round"></textarea>
                </div>
                <div class="w-full h-[50px] mt-5 px-5 kode">
                    <label>Game Code</label>
                    <input name="game_code" placeholder="Code..." class="w-full h-full px-2 border-[1px] border-black/50 round">
                </div>
                <div class="w-full h-[50px] mt-5 px-5 kode">
                    <label>Game Source</label>
                    <input name="game_source" placeholder="Source..." class="w-full h-full px-2 border-[1px] border-black/50 round">
                </div>
                <div class="w-full h-[50px] mt-5 px-5 kode">
                    <label>Game URL</label>
                    <input name="game_url" placeholder="URL..." class="w-full h-full px-2 border-[1px] border-black/50 round">
                </div>
                <div class="w-full h-[50px] mt-5 px-5 kode">
                    <label>Game Banner (Optional)</label>
                    <input name="game_banner" placeholder="Banner Link..." class="w-full h-full px-2 border-[1px] border-black/50 round">
                </div>
                <div class="w-full h-[50px] mt-3  px-5 kode flex justify-center items-center">
                    <button type="submit" class="w-[50%] h-full bg-green-500 border-[1px] border-black text-white">SUBMIT</button>
                </div>
            </div>
        </form>
</div>
