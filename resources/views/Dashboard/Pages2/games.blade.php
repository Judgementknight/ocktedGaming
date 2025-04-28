@php
use Illuminate\Support\Str;
@endphp

@extends('Dashboard.Pages2.layout')
@section('title')  <!-- Overriding the title with dynamic game title -->
@section('content')


<x-sidebar/>
<div id="modal" class="fixed hidden top-0 left-0 w-full h-screen z-50 bg-[#00000038] opacity-0 transition-opacity duration-200 ease-linear">
    <div class="w-[700px] h-auto rounded-lg bg-white absolute left-[50%] -translate-x-[50%] -translate-y-[50%] top-[50%] font1 p-3">
        <div class="flex items-center justify-between">
            <h1 class="text-lg text-zinc-500">Add Game</h1>
            <img id="close-modal" class="size-6 hover:cursor-pointer" src="{{ asset('dash/cancel.png')}}">
        </div>
        <form action="{{ route('add-game') }}" method="POST">
            <div class="flex items-center mt-2 gap-3">
                <div class="flex flex-col gap-1 w-full">
                    <label class="px-1 text-lg">Game Title</label>
                    <input name="game_title" class="w-full rounded-[10px] px-2 border-2 border-zinc-400 text-zinc-500 h-[40px] outline-none ring-0 focus:outline-none focus:ring-0 focus:border-zinc-400" placeholder="Title...">
                </div>

            </div>

            <div class="flex items-center mt-2 gap-3">
                <div class="flex flex-col gap-1 w-full">
                    <label class="px-1 text-lg">Game Description</label>
                    <textarea name="game_description" class="w-full rounded-[10px] px-2 border-2 border-zinc-400 text-zinc-500 h-[70px] outline-none ring-0 focus:outline-none focus:ring-0 focus:border-zinc-400" placeholder="Description..."></textarea>
                </div>
            </div>

            <div class="flex items-center mt-2 gap-3">

                <div class="flex flex-col gap-1 w-full">
                    <label class="px-1 text-lg">Game URL</label>
                    <input name="game_url" type="text" class="w-full rounded-[10px] px-2 border-2 border-zinc-400 text-zinc-500 h-[40px] outline-none ring-0 focus:outline-none focus:ring-0 focus:border-zinc-400" placeholder="URL..">
                </div>

            </div>

            <div class="flex items-center mt-2 gap-3">
                <div class="flex flex-col gap-1 w-full">
                    <label class="px-1 text-lg">Game Source</label>
                    <input name="game_source" type="text" class="w-full rounded-[10px] px-2 border-2 border-zinc-400 text-zinc-500 h-[40px] outline-none ring-0 focus:outline-none focus:ring-0 focus:border-zinc-400" placeholder="Source...">
                </div>
                <div class="flex flex-col gap-1 w-full">
                    <label class="px-1 text-lg">Game Banner (link)</label>
                    <input name="game_banner" type="text" class="w-full rounded-[10px] px-2 border-2 border-zinc-400 text-zinc-500 h-[40px] outline-none ring-0 focus:outline-none focus:ring-0 focus:border-zinc-400" placeholder="Link...">
                </div>

            </div>

            <div class="w-full flex items-center justify-between">
                <!-- Hidden input to store base64 result -->
                {{-- <input name="profile_picture" type="hidden" id="cropped-image"> --}}
                <div class=" mt-10 w-[100px] h-[40px] flex items-center justify-center rounded-[5px] bgteal text-zinc-200">
                    <button type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>

</div>

<div id="assign-modal" class="fixed hidden top-0 left-0 w-full h-screen z-50 bg-[#00000038] opacity-0 transition-opacity duration-200 ease-linear">
    <div class="w-[98%] md:w-[80%] h-auto rounded-lg bg-white absolute left-[50%] pb-5 -translate-x-[50%] -translate-y-[25%] top-[25%] font1 p-3">
        <div class="flex items-center justify-between">
            <h1 class="text-xl text-zinc-500">Games Server</h1>
            <img id="close-assign-modal" class="size-6 hover:cursor-pointer" src="{{ asset('dash/cancel.png')}}">
        </div>

        <div class="w-full shadow-2xl h-auto rounded-md mt-3" id="game-container" >
        </div>



    </div>

</div>


<section id="page-container" class="py-10 px-2 md:px-10 w-full h-screen bg-white">

    <header class="w-full h-[50px] flex items-center justify-between">
        <h1 class="font1 text-4xl font-semibold text-zinc-800">GAMES DATA</h1>
        <div class="flex gap-3">
            <div id="open-assign-modal" class="w-auto px-2 h-[50px] group hover:bg-[#28978E] transition-all duration-200 ease-linear rounded-lg flex items-center hover:cursor-pointer">
                <div class="w-full flex items-center justify-center">
                    <p class="font1 text-zinc-500 group-hover:text-zinc-50">Games Server</p>
                </div>
            </div>
            <div id="open-modal" class="w-[150px] h-[50px] bgteal rounded-lg flex px-4 items-center hover:cursor-pointer">
                <div class="w-[50%] flex items-center">
                    <img class="size-6" src="{{asset('dash/add.png')}}">
                </div>
                <div class="w-[70%] flex items-center justify-center">
                    <p class="font1 text-zinc-200">Add Games</p>
                </div>
            </div>
        </div>
    </header>

    <div class="w-full h-[40px] mt-10 flex items-center justify-end">
        <div class="w-[300px] h-full rounded-[8px] border-2 border-zinc-400 relative font1">
            <img src="{{asset('dash/search.png')}}" class="size-5 absolute left-2 top-[10px]">
            <input id="search-data" class="w-full rounded-[20px] px-8 text-zinc-500 h-full outline-none ring-0 focus:outline-none focus:ring-0 focus:border-none text-sm" placeholder="Search Games...">
        </div>
    </div>

    <div class="w-full h-[60vh] lg:w-full overflow-hidden overflow-x-scroll overflow-y-scroll mt-3 relative z-10">
        <table class="w-[120vh] lg:w-full text-left text-sm text-white font1 ">
          <thead class="w-full uppercase font-medium text-zinc-400 text-md ">
            <tr class="sticky top-0 bg-white whitespace-nowrap">
              {{-- <th class="px-4 py-2">
                  ID
              </th> --}}
              <th class="px-4 py-2 flex gap-1 items-center">
                Game Title
                <img id="sort-by-name" src="{{asset('dash/sort.png')}}" class="size-[15px] hover:cursor-pointer"></img>
              </th>
              <th>Game Banner</th>

              <th>Description</th>

              <th class="px-4 py-2">Game Code</th>

              <th class="px-4 py-2 ">
                <div class="flex items-center gap-1">
                    Game Source
                    <img id="sort-by-classroom" src="{{asset('dash/sort.png')}}" class="size-[15px] hover:cursor-pointer"></img>
                </div>
              </th>

              <th class="px-4 py-2 ">
                <div class="flex items-center gap-1">
                    URL
                    <img id="sort-by-assignment" src="{{asset('dash/sort.png')}}" class="size-[15px] hover:cursor-pointer"></img>
                </div>
              </th>

              <th class="px-4 py-2">Game Status</th>
              {{-- <th class="px-4 py-2">Status</th> --}}
              <th class="px-4 py-2 bg-white">Action</th>
            </tr>
          </thead>
          <tbody id="data-table-body" class=" min-w-[80vh] text-zinc-900">

          </tbody>
        </table>

    </div>
    <div id="pagination-links" class="mt-4 flex gap-2">

    </div>

    {{-- <script type="text/template" id="loader-row-tpl">
        <div id="fullpage-loader" class="hidden absolute inset-0 bg-white bg-opacity-90 z-50 flex items-center justify-center">
            <x-loader-table/>
        </div>
    </script> --}}

    <div id="fullpage-loader" class="hidden absolute inset-0 bg-white z-50 bg-opacity-90 flex items-center justify-center">
        <x-loader-table/>
    </div>
</section>


<div class="absolute w-[300px] h-[80px] right-[-100%] top-8 toast-container1 transition-all duration-300 ease-linear z-[999]">
    <div class="w-full h-full bg-white absolute z-20 rounded-[5px] border-[1px] border-black/50 flex items-center px-4">
        <div class="h-[3rem] w-[5rem]">
            <img id="toast-icon" src="{{ asset('dashboard/icons/error.gif') }}" alt="Toast Icon">
        </div>
        <div class="kode">
            <p id="toast-message"></p>
        </div>
    </div>
    <div class="w-full h-full bg-black absolute translate-x-2 translate-y-1 rounded-[5px]">

    </div>
</div>

@endsection


@push('scripts')

<script>
    const modal = document.getElementById('modal');
    const closeModal = document.getElementById('close-modal');
    const openModal = document.getElementById('open-modal');

    openModal.addEventListener('click', ()=> {
        console.log('click');
        modal.classList.add('flex');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            modal.classList.remove('opacity-0');
        }, 300);

    });

    closeModal.addEventListener('click', () => {

        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
        }
    });
</script>

<script>
    const assignmodal = document.getElementById('assign-modal');
    const assignCloseModal = document.getElementById('close-assign-modal');
    const assignOpenModal = document.getElementById('open-assign-modal');

    assignOpenModal.addEventListener('click', ()=> {
        console.log('enter');
        assignmodal.classList.add('flex');
        assignmodal.classList.remove('hidden');
        setTimeout(() => {
            assignmodal.classList.add('opacity-100');
            assignmodal.classList.remove('opacity-0');
        }, 300);

    });

    assignCloseModal.addEventListener('click', () => {
        assignmodal.classList.remove('opacity-100');
        assignmodal.classList.add('opacity-0');
        setTimeout(() => {
            assignmodal.classList.add('hidden');
            assignmodal.classList.remove('flex');
        }, 300);
    });

    window.addEventListener('click', (e) => {
        if (e.target === assignmodal) {
            assignmodal.classList.remove('opacity-100');
            assignmodal.classList.add('opacity-0');
            setTimeout(() => {
            assignmodal.classList.add('hidden');
            assignmodal.classList.remove('flex');
        }, 300);
        }
    });
</script>

{{-- CROPPIE SCRIPT --}}
<script>
    const croppedImage = $('#cropped-image').val();
    let croppieInstance;

    // Open file dialog on div click
    $('#upload-container').on('click', function () {
        $('#upload-photo').click();
    });

    // Handle file input change
    $('#upload-photo').on('change', function () {
        const reader = new FileReader();
        reader.onload = function (e) {
            if (croppieInstance) {
                croppieInstance.destroy(); // Destroy previous instance if exists
            }

            $('#croppie-container').removeClass('hidden');

            croppieInstance = new Croppie(document.getElementById('croppie-demo'), {
                viewport: { width: 150, height: 150, type: 'circle' },
                boundary: { width: 200, height: 200 },
                enableOrientation: true
            });

            croppieInstance.bind({
                url: e.target.result
            });
        };
        reader.readAsDataURL(this.files[0]);
    });

    // Crop and save
    $('#crop-image').on('click', function () {
        croppieInstance.result({
            type: 'base64',
            size: 'viewport'
        }).then(function (base64) {
            $('#cropped-image').val(base64); // Store base64 in hidden input

            // Optionally, preview or send to server
            console.log("Cropped image:", base64);
            $('#upload-complete').text('Uploaded!').addClass('text-green-500 font-semibold');
            // You can hide croppie now or show a thumbnail preview
            $('#croppie-container').addClass('hidden');
        });
    });
</script>


<script>
    document.addEventListener('submit', async function(event) {
        if (event.target.classList.contains('game-form')) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);

            try {
                const response = await fetch("{{ route('add-game') }}", {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        "Accept": "application/json", // Uncommented this
                        "Authorization": "Bearer {{ session('admin_token') }}",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: formData,
                });

                const result = await response.json(); // Always parse JSON

                if (response.ok) {
                    console.log("DATA SENT!!", result);
                    updateToast(result.message, 'success');
                    form.closest("tr")?.remove();
                } else {
                    console.error("DATA NOT SENT", result);
                    updateToast(result.message || 'Operation failed', 'error');
                }
            } catch (error) {
                console.error("FETCH ERROR", error);
                updateToast('Network error - please try again', 'error');
            }
        }
    });

    function updateToast(message, type) {
        const toast = document.querySelector('.toast-container1');
        const icon = document.getElementById('toast-icon');
        const messageEl = document.getElementById('toast-message');

        // Update content
        messageEl.textContent = message;
        icon.src = type === 'success'
            ? "{{ asset('dashboard/icons/done.gif') }}"
            : "{{ asset('dashboard/icons/error.gif') }}";

        // Show toast
        toast.classList.remove('right-[-100%]');
        toast.classList.add('right-4');

        // Hide after 4 seconds
        setTimeout(() => {
            toast.classList.remove('right-4');
            toast.classList.add('right-[-100%]');
        }, 2000);
    }
</script>


{{-- FETCH SCRIPT --}}
<script>
    $(document).ready(function() {
        let sortDirection = 'asc';
        const deleteIcon1 = @json(asset('dash/delete.png'));
        const deleteIcon2 = @json(asset('dash/delete2.png'));

        // Function to update the UI with new data
        function updateUI(data) {
            // Update the table body
            let html = '';
            const games = data.data.data || [];
            if (games.length === 0) {
                html = '<tr><td colspan="7" class="text-center text-zinc-800">No Games Found.</td></tr>';
            } else {
                $.each(games, function(index, game) {
                    html += '<tr class="border-t text-zinc-500 text-md">';
                    html += '<td class="px-4 py-2 text-zinc-800 font-semibold">' + game.game_title + '</td>';
                    html += '<td class="px-4 py-2"><img src="' + game.game_banner + '" class="size-12 object-cover rounded-md"></td>';
                    html += '<td class="px-4 py-2">' + game.game_description ?? '-' + '</td>';
                    html += '<td class="px-4 py-2">' + (game.game_code ?? '-') + '</td>';
                    html += '<td class="px-4 py-2">' + (game.game_source ?? '-') + '</td>';
                    html += '<td class="px-4 py-2">' + (game.game_url ?? '-') + '</td>';
                    html += '<td class="px-4 py-2">' + (game.game_status ?? '-') + '</td>';
                    html += '<td class="px-4 py-2 flex">';
                    html += '<div id="deletediv" class="size-10 hover:bg-[#28978E] rounded-[50%] flex items-center justify-center hover:cursor-pointer relative">';
                    html += '<img class="delete1 w-[50%] h-[50%] absolute opacity-100 -z-10" src="' + deleteIcon1 + '">';
                    html += '<img class="delete2 w-[50%] h-[50%] absolute opacity-0 z-50" src="' + deleteIcon2 + '">';
                    html += '</div>';
                    html += '</td>';
                    html += '</tr>';
                });
            }
            $('#data-table-body').html(html);

            // Update pagination links
            let paginationHtml = '';
            data.data.links.forEach(link => {
                if (link.url !== null) {
                    paginationHtml += `<button data-url="${link.url}" class="px-3 py-1 border rounded ${link.active ? 'bg-teal-500 text-white' : 'bg-white text-black'}">${link.label.replace('&laquo;', '«').replace('&raquo;', '»')}</button>`;
                }
            });
            $('#pagination-links').html(paginationHtml);


            const gameServer = data["game server"];
            let cardHtml = "";

            if (!gameServer || Object.keys(gameServer).length === 0) {
                cardHtml = '<div class="text-center text-zinc-400">No Server found.</div>';
            } else {
                let hasGames = false; // track if at least one game exists

                $.each(gameServer, function(serverName, serverData) {
                    if (serverData?.['Game Data']?.length > 0) {
                        hasGames = true;

                        let sender = serverData.sender || 'Unknown Server';

                        let serverBlock = `
                        <div class="p-2">
                            <div class="w-full flex items-center gap-3">
                                <h1 class="text-lg font-medium">${sender}</h1>
                                <div class="h-5 bg-[#cbf3f0] w-auto rounded-2xl flex items-center justify-center border-2 px-2 border-[#2ec4b6]">
                                    <span class="truncate leading-none text-xs text-black">
                                        ${serverName}
                                    </span>
                                </div>
                            </div>

                            <div class="w-full h-[300px] grid md:grid-cols-2 gap-4 pb-1 overflow-y-auto">`;

                        $.each(serverData['Game Data'], function(i, game) {
                            serverBlock += `
                            <div class="w-full h-[100px] shadow-lg bg-white rounded-md py-2 px-2 flex items-center gap-3">
                                <div class="h-full w-[50%] rounded-md">
                                    <img src="${game.game_banner}" class="w-full h-full rounded-md object-cover object-top">
                                </div>
                                <div class="h-full w-full rounded-md flex flex-col text-sm">
                                    <span class="font-normal">Title: ${game.game_title}</span>
                                    <span class="font-normal text-sm">
                                        Description: ${game.game_description}
                                    </span>
                                    <span class="font-normal text-sm">
                                        Link: <span class="text-blue-400">${game.game_url}</span>
                                    </span>
                                </div>
                                <div class="h-full w-[10%] rounded-md flex items-center justify-center">
                                    <form class="game-form">
                                        <input type="hidden" name="game_title" value="${game.game_title}">
                                        <input type="hidden" name="game_source" value="${serverData.sender}">
                                        <input type="hidden" name="game_description" value="${game.game_description}">
                                        <input type="hidden" name="game_banner" value="${game.game_banner}">
                                        <input type="hidden" name="game_url" value="${game.game_url}">
                                        <input type="hidden" name="game_code" value="${game.game_code}">
                                        <button type="submit">
                                            <img src="/dash/add2.png" class="h-[70%] w-[70%]">
                                        </button>
                                    </form>
                                </div>
                            </div>`;
                        });

                        serverBlock += `</div></div>`;
                        cardHtml += serverBlock;
                    }
                });

                if (!hasGames) {
                    cardHtml = '<div class="text-center text-red-400">No Server found.</div>';
                }
            }

            // Finally inject into the container
            $('#game-container').html(cardHtml);




            // Re-attach hover events for delete buttons
            const deleteDivs = document.querySelectorAll('#deletediv');
            deleteDivs.forEach(div => {
                const delete1 = div.querySelector('.delete1');
                const delete2 = div.querySelector('.delete2');

                div.addEventListener('mouseenter', () => {
                    console.log('hey');
                    delete1.classList.add('opacity-0');
                    delete1.classList.remove('opacity-100');
                    delete2.classList.remove('opacity-0');
                    delete2.classList.add('opacity-100');
                });

                div.addEventListener('mouseleave', () => {
                    console.log('bye')
                    delete1.classList.add('opacity-100');
                    delete1.classList.remove('opacity-0');
                    delete2.classList.remove('opacity-100');
                    delete2.classList.add('opacity-0');
                });
            });
        }

        // Pagination click handler
        $(document).on('click', '#pagination-links button', function(e) {
            e.preventDefault();
            const url = $(this).data('url');
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    updateUI(data);
                }
            });
        });

        // Search input handler
        $('#search-data').on('keyup', function() {
            const query = $(this).val();
            fetchData({ query });
        });

        // Sort name handler
        $('#sort-by-name').on('click', function() {
            sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
            const query = $('#search-data').val();
            fetchData({ query, sortByName: sortDirection });
        });

        $('#sort-by-classroom').on('click', function() {
            sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
            const query = $('#search-data').val();
            fetchData({ query, sortByClassroom: sortDirection});
        });

        $('#sort-by-assignment').on('click',function(){
            sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
            const query = $('#search-data').val();
            fetchData({query, sortByAssignment: sortDirection});
        });

        // Function to fetch data with parameters
        function fetchData(params = {}) {
            $.ajax({
                url: "{{ route('games-query') }}",
                type: 'GET',
                data: params,
                dataType: 'json',

                beforeSend() {
                    $('#fullpage-loader').removeClass('hidden');
                const loaderRow = $('#loader-row-tpl').html();
            },


                success: function(data) {
                     // Show full page loader
                     $('#fullpage-loader').addClass('hidden');
                     updateUI(data);
                },
                error() {
                    $('#data-table-body').html(
                        '<tr><td colspan="8" class="text-center text-red-500 py-8">Failed to load games.</td></tr>'
                    );
                }
            });
        }

        // Initial fetch
        fetchData();
    });


    const deleteDivs = document.querySelectorAll('#deletediv');
            deleteDivs.forEach(div => {
                const delete1 = div.querySelector('.delete1');
                const delete2 = div.querySelector('.delete2');

                div.addEventListener('mouseenter', () => {
                    console.log('hey');
                    delete1.classList.add('opacity-0');
                    delete1.classList.remove('opacity-100');
                    delete2.classList.remove('opacity-0');
                    delete2.classList.add('opacity-100');
                });

                div.addEventListener('mouseleave', () => {
                    console.log('bye')
                    delete1.classList.add('opacity-100');
                    delete1.classList.remove('opacity-0');
                    delete2.classList.remove('opacity-100');
                    delete2.classList.add('opacity-0');
                });
            });
</script>

@endpush
