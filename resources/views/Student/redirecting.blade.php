@extends('Student.student-layout')

@section('OCKTED GAMING')

@section('content')
<body class="pb-10">
    <div class="w-full h-full fixed top-0 left-0 -z-30">
        <img class="w-full h-full object-cover" src="{{ asset('Teacher/bg3.jpg') }}">
    </div>

    <div class="w-full h-screen flex flex-col justify-center items-center gap-4">
        <p class="text-lg md:text-4xl font-bold text-[#2776F9]">You’re being redirected to the game.</p>
        <p class="text-lg text-gray-200">Click the button below to continue.</p>
        <button onclick="launchGame()" class="bg-[#2776F9] text-white px-6 py-3 rounded-md hover:bg-blue-700">
            Launch Game
        </button>
    </div>

    {{-- <script>
        const gameUrl = @json($combinedData->gameUrl . '?token=' . urlencode($combinedData->token) . '&url=' . urlencode($combinedData->returnUrl) . '&gamecode=' . urlencode($combinedData->code));
        console.log(gameUrl);
        function launchGame() {
            const ocktedUrl = "{{ route('ockted') }}";


            window.open(gameUrl, "_blank", "noopener,noreferrer"); // new tab
            window.location.href = ocktedUrl; // this tab
        }
    </script> --}}

{{-- <script>
    const gameUrl = @json($combinedData->gameUrl . '?token=' . urlencode($combinedData->token) . '&url=' . urlencode($combinedData->returnUrl) . '&gamecode=' . urlencode($combinedData->code));

    function launchGame() {
        const ocktedUrl = "{{ route('ockted') }}";

        // Try opening the game in a new tab
        const newTab = window.open(gameUrl, "_blank", "noopener,noreferrer");

        // If blocked or failed, fallback to redirecting in the same tab
        if (!newTab || newTab.closed || typeof newTab.closed === "undefined") {
            window.location.href = gameUrl;
        } else {
            // Allow time for new tab to open before redirecting current tab
            setTimeout(() => {
                window.location.href = ocktedUrl;
            }, 500);
        }
    }
</script> --}}

<script>
    const gameUrl = @json($combinedData->gameUrl . '?token=' . urlencode($combinedData->token) . '&url=' . urlencode($combinedData->returnUrl) . '&gamecode=' . urlencode($combinedData->code));

    function launchGame() {
        // Just redirect to the game in the same tab
        window.location.href = gameUrl;
    }
</script>
</body>
@endsection
