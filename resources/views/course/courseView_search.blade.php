@foreach($courses as $course)
        <div class="course-card">
            <div class="image-container">
                <img src="{{ $course['thumbnail'] }}" alt="Course Image" class="course-image">
                <!-- Play Icon Only -->
                <a href="{{ route('coursesViewDetails', ['id' => $course['_id']]) }}" class="play-icon-overlay">
                    <i class="fas fa-play play-icon" style="color: #990000;"></i>
                </a>
            </div>
            <div class="course-details">
                <h2 class="course-title">{{ $course['courseName'] }}</h2>
                <p class="course-description">{{ $course['createdBy'] }}</p>
                {{-- <p>progress: {{ $course->totalProgress }}</p> --}}
                {{-- <p>progress: {{ $course->expectedDurationInSeconds }}</p> --}}

                <!-- Progress Tracker -->
                <div class="progress-container">
                    @php
                        $progressPercentage= ($course->totalProgress/$course->expectedDurationInSeconds)*100;
                    @endphp
                    
                    <label for="progress"></label>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $progressPercentage }}%;"></div>
                    </div>
                </div>
                <p>{{ number_format($progressPercentage) }}% Complete</p>
            </div>
        </div>
    @endforeach

    {{-- <div class="page_pegination">
        {{ $courses->links() }}
    </div> --}}