@extends('layouts.app')


@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<style>
    .assignment .d_brd_otr {
        background-color: transparent !important;
    }

    .course-details-container {
        max-width: 800px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    h1 {
        text-align: center;
        margin-bottom: 10px;
    }

    p {
        text-align: center;
        color: #666;
        margin-bottom: 20px;
        font-size: 1.5rem;
    }

    .chapters {
        margin-top: 20px;
    }

    h2 {
        margin-bottom: 15px;
        font-size: 1.2em;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    .chapter-item {
        padding: 15px;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    .topic-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }

    .topic-item:last-child {
        border-bottom: none;
    }

    .topic-item span {
        flex-grow: 1;
        max-width: calc(100% - 120px);
        /* Adjust to make space for duration and button */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 1.5rem;
    }

    .duration {
        width: 60px;
        /* Fixed width for consistent alignment */
        text-align: right;
        /* Align text to the right */
        font-size: 0.9em;
        color: #666;
        padding-right: 10px;
    }

    button {
        padding: 5px 10px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    button:hover {
        background-color: #218838;
    }

    .chaptersHeader {
        font-size: 1.8rem;
    }

    .videoIcon {
        height: 15px;
        width: 15px;
        margin-right: 5px;
    }

    .playButton {
        background-color: #990000 !important;
        font-size: 1.2rem;
    }
</style>

<div class="d_brd_otr">
    <div class="knwledg_section">
        <div class="d_brd_tp">
            <a href="{{ route('coursesViewDetails', ['id' => $id]) }}"><img src="{{ asset('images/left_arrow.png') }}" /></a>
            <h3>Course Contents</h3>
        </div>
    </div>

</div>


<div class="course-details-container">
    {{-- <video height="500px" width="500px" controls>
        <source src={{$course[0]['chapters']['topics']['content']}} type="video/mp4">
    </video> --}}

    {{-- <p>{{$course[0]['chapters']['topics']['contentType']}}</p> --}}

    @if($course[0]['chapters']['topics']['contentType'] == 'pdf')
        <iframe src="{{asset($course[0]['chapters']['topics']['content'])}}" width="100%" height="500px" id="currentpdfLink" class="currentpdfLink"></iframe>
    @elseif($course[0]['chapters']['topics']['contentType'] == 'file')
        <video class="edit_vide" controls id="videoPlayer">
            <source src={{asset($course[0]['chapters']['topics']['content'])}} type="video/mp4">
        </video>
    @elseif($course[0]['chapters']['topics']['contentType'] == 'text')
        <div style="font-size: 18px; line-height: 1.6;">
            {!! $course[0]['chapters']['topics']['content'] !!}
        </div>
    @elseif($course[0]['chapters']['topics']['contentType'] == 'youtube')
        @php
            // Extract the video ID from the YouTube URL
            $videoId = preg_replace('/https:\/\/youtu\.be\/([a-zA-Z0-9_-]+).*/', '$1', $course[0]['chapters']['topics']['content']);
        @endphp

        <div id="player"></div>

        <!-- <iframe width="100%" height="500px" 
            src="https://www.youtube.com/embed/{{ $videoId }}" 
            frameborder="0" allowfullscreen>
        </iframe> -->
    @endif
    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
        <button id="previousButton" class="btn btn-primary btn-lg" data-previous-chapter="{{ $previousChapterId }}" data-previous-topic="{{ $previousTopic['_id'] ?? '' }}">Previous</button>

        <button class="btn btn-primary btn-lg" id="nextButton" data-next-chapter="{{ $nextChapterId ?? '' }}" data-next-topic="{{ $nextTopic['_id'] ?? '' }}">Next</button>
    </div>
</div>


@endsection
@section('customJs')
<script src="{{ asset('js/course/streaming.js') }}"></script>
<script>
    $(document).ready(function() {
        var lastPlayedTime = {{ $lastPlayedTime ?? 0 }}; // Get last played time from the server
        
        // Handle video player
        var videoPlayer = $('#videoPlayer')[0];
        if (videoPlayer) {
            videoPlayer.currentTime = lastPlayedTime;

            $(videoPlayer).on('timeupdate', function() {
                saveProgress(videoPlayer.currentTime);
            });

            $(window).on('beforeunload', function() {
                saveProgress(videoPlayer.currentTime);
            });
        }

        // Handle YouTube player
        var player;
        var videoId = '{{ $videoId ?? "" }}'; // Get the video ID if it's a YouTube video
        if (videoId) {
            loadYouTubeAPI();
        }

        function loadYouTubeAPI() {
            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        }

        // This function creates an <iframe> (and YouTube player)
        window.onYouTubeIframeAPIReady = function() {
            player = new YT.Player('player', {
                height: '500',
                width: '100%',
                videoId: videoId,
                playerVars: { 'playsinline': 1 },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        };

        function onPlayerReady(event) {
            player.seekTo(lastPlayedTime); // Set the video to start from last played time
        }

        function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.PAUSED) {
                saveProgress();
            }
        }

        // Save progress for both video types
        function saveProgress(currentTime) {
            var progress = currentTime !== undefined ? currentTime : (player ? player.getCurrentTime() : 0);
            $.ajax({
                url: '/save-video-progress',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    course_id: '{{ $id }}',
                    chapter_id: '{{ $chapter_id }}',
                    topic_id: '{{ $topic_id }}',
                    progress: progress
                },
                success: function(response) {
                    console.log("Progress saved", response);
                },
                error: function(xhr, status, error) {
                    console.error("Error saving progress: ", error);
                }
            });
        }

        $('#nextButton').click(function () {
            const nextChapterId = $(this).data('next-chapter');
            const nextTopicId = $(this).data('next-topic');

            if (nextChapterId && nextTopicId) {
                const nextUrl = `/coursesView-content/{{ $id }}/${nextChapterId}/${nextTopicId}`;
                window.location.href = nextUrl;
            } else {
                alert('No more topics available.');
            }
        });
        $('#previousButton').click(function () {
            const previousChapterId = $(this).data('previous-chapter');
            const previousTopicId = $(this).data('previous-topic');

            if (previousChapterId && previousTopicId) {
                const previousUrl = `/coursesView-content/{{ $id }}/${previousChapterId}/${previousTopicId}`;
                window.location.href = previousUrl;
            } else {
                alert('No previous topics available.');
            }
        });
    });
</script>
@endsection