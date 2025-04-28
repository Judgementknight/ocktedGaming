@extends('Dashboard.Pages2.layout')
@section('title')  <!-- Overriding the title with dynamic game title -->
@section('content')


<x-sidebar/>
<section class="py-10 px-2 md:px-10 w-full h-screen bg-white">
    <header class="w-full h-[50px] flex items-center justify-between">
        <h1 class="font1 text-4xl font-semibold text-zinc-800">STUDENT DATA</h1>
        <div class="flex gap-3">
            <div id="open-assign-modal" class="w-auto px-2 h-[50px] group hover:bg-[#28978E] transition-all duration-200 ease-linear rounded-lg flex items-center hover:cursor-pointer">
                <div class="w-full flex items-center justify-center">
                    <p class="font1 text-zinc-500 group-hover:text-zinc-50">Assign Student</p>
                </div>
            </div>
            <div id="open-modal" class="w-[150px] h-[50px] bgteal rounded-lg flex px-4 items-center hover:cursor-pointer">
                <div class="w-[30%] flex items-center">
                    <img class="size-6" src="{{asset('dash/add.png')}}">
                </div>
                <div class="w-[70%] flex items-center justify-center">
                    <p class="font1 text-zinc-200">Add Student</p>
                </div>
            </div>
        </div>
    </header>

    <div class="w-full h-[40px] mt-10 flex items-center justify-end">
        <div class="w-[300px] h-full rounded-[8px] border-2 border-zinc-400 relative font1">
            <img src="{{asset('dash/search.png')}}" class="size-5 absolute left-2 top-[10px]">
            <input id="search-student" class="w-full rounded-[20px] px-8 text-zinc-500 h-full outline-none ring-0 focus:outline-none focus:ring-0 focus:border-none" placeholder="Search Student...">
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
                Name
                <img id="sort-name" src="{{asset('dash/sort.png')}}" class="size-[15px] hover:cursor-pointer"></img>
              </th>

              <th>Profile Picture</th>

              <th class="px-4 py-2">School Code</th>

              <th class="px-4 py-2 ">
                <div class="flex items-center gap-1">
                    Games Played
                    <img id="sort-by-game" src="{{asset('dash/sort.png')}}" class="size-[15px] hover:cursor-pointer"></img>
                </div>
              </th>

              <th class="px-4 py-2 ">
                <div class="flex items-center gap-1">
                    Total Score
                    <img id="sort-by-score" src="{{asset('dash/sort.png')}}" class="size-[15px] hover:cursor-pointer"></img>
                </div>
              </th>

              <th class="px-4 py-2">Rank</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2 bg-white">Action</th>
            </tr>
          </thead>
          <tbody id="students-table-body" class=" max-w-[150vh] lg:min-w-[80vh] text-zinc-900">
            @foreach ($students as $student)
                <tr class="border-t text-zinc-500 text-md">
                <td class="px-4 py-2 text-zinc-800 font-semibold">{{$student->student_name}}</td>
                <td class="px-4 py-2"><img src="{{$student->profile_picture}}" class="size-12 object-cover rounded-lg"></td>
                <td class="px-4 py-2">{{$student->school_code}}</td>
                <td class="px-4 py-2">{{$student->game_count}}</td>
                <td class="px-4 py-2">{{$student->total_score ?? '0'}}</td>
                <td class="px-4 py-2">{{$student->rank}}</td>
                <td class="px-4 py-2">{{$student->student_status ?? 'N/A'}}</td>
                <td class="px-4 py-2 flex">
                    <div id="deletediv" class="size-10 hover:bg-[#28978E] rounded-[50%] flex items-center justify-center hover:cursor-pointer relative">
                        <img id="" class="delete1 w-[50%] h-[50%] absolute opacity-100 -z-10" src="{{ asset('dash/delete.png') }}">
                        <img id="" class="delete2 w-[50%] h-[50%] absolute opacity-0 -z-10" src="{{ asset('dash/delete2.png') }}">
                    </div>
                </td>
                </tr>
            @endforeach
          </tbody>
        </table>
    </div>
    <div id="pagination-links" class="mt-4 flex gap-2">

    </div>
</section>

@endsection


@push('scripts')

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
            const list = data.data;
            if (list.length === 0) {
                html = '<tr><td colspan="7" class="text-center text-zinc-400">No students found.</td></tr>';
            } else {
                $.each(data.data, function(index, student) {
                    html += '<tr class="border-t text-zinc-500 text-md">';
                    html += '<td class="px-4 py-2 text-zinc-800 font-semibold">' + student.student_name + '</td>';
                    html += '<td class="px-4 py-2"><img src="' + student.profile_picture + '" class="size-12 object-cover rounded-md"></td>';
                    html += '<td class="px-4 py-2">' + student.school_code + '</td>';
                    html += '<td class="px-4 py-2">' + (student.game_count ?? '0') + '</td>';
                    html += '<td class="px-4 py-2">' + (student.total_score ?? '0') + '</td>';
                    html += '<td class="px-4 py-2">' + (student.rank ?? '-') + '</td>';
                    html += '<td class="px-4 py-2">' + student.student_status + '</td>';
                    html += '<td class="px-4 py-2 flex">';
                    html += '<div id="deletediv" class="size-10 hover:bg-[#28978E] rounded-[50%] flex items-center justify-center hover:cursor-pointer relative">';
                    html += '<img class="delete1 w-[50%] h-[50%] absolute opacity-100 -z-10" src="' + deleteIcon1 + '">';
                    html += '<img class="delete2 w-[50%] h-[50%] absolute opacity-0 " src="' + deleteIcon2 + '">';
                    html += '</div>';
                    html += '</td>';
                    html += '</tr>';
                });
            }
            $('#students-table-body').html(html);

            // Update pagination links
            let paginationHtml = '';
            data.links.forEach(link => {
                if (link.url !== null) {
                    paginationHtml += `<button data-url="${link.url}" class="px-3 py-1 border rounded ${link.active ? 'bg-teal-500 text-white' : 'bg-white text-black'}">${link.label.replace('&laquo;', '«').replace('&raquo;', '»')}</button>`;
                }
            });
            $('#pagination-links').html(paginationHtml);

            // Re-attach hover events for delete buttons
            const deleteDivs = document.querySelectorAll('#deletediv');
            deleteDivs.forEach(div => {
                const delete1 = div.querySelector('.delete1');
                const delete2 = div.querySelector('.delete2');

                div.addEventListener('mouseenter', () => {
                    console.log('hey')
                    delete1.classList.add('opacity-0');
                    delete1.classList.remove('opacity-100');
                    delete2.classList.remove('opacity-0');
                    delete2.classList.add('opacity-100');
                });

                div.addEventListener('mouseleave', () => {
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
        $('#search-student').on('keyup', function() {
            const query = $(this).val();
            fetchStudents({ query });
        });

        // Sort name handler
        $('#sort-name').on('click', function() {
            sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
            const query = $('#search-student').val();
            fetchStudents({ query, sortByName: sortDirection });
        });

        $('#sort-by-score').on('click', function() {
            sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
            const query = $('#search-student').val();
            fetchStudents({ query, sortByScore: sortDirection});
        });

        $('#sort-by-game').on('click',function(){
            sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
            const query = $('#seach-students').val();
            fetchStudents({query, sortByGame: sortDirection});
        });

        // Function to fetch students with parameters
        function fetchStudents(params = {}) {
            $.ajax({
                url: "{{ route('student-query') }}",
                type: 'GET',
                data: params,
                dataType: 'json',
                success: function(data) {
                    updateUI(data);
                },
                error: function(xhr) {
                    console.error('Error fetching students:', xhr);
                }
            });
        }

        // Initial fetch
        fetchStudents();
    });
</script>

@endpush
