@foreach($courses as $course)
    <a href="{{ route('coursesViewDetails', ['id' => $course['_id']]) }}">
        <div class="course-card">
            <div class="image-container">
                <img src="{{ $course['thumbnail'] }}" alt="Course Image" class="course-image">
                <!-- Play Icon Only -->
                <a href="{{ route('coursesViewDetails', ['id' => $course['_id']]) }}" class="play-icon-overlay">
                    <i class="fas fa-play play-icon" style="color: #990000;"></i>
                </a>
            </div>
        </a>
        <a href="{{ route('coursesViewDetails', ['id' => $course['_id']]) }}">
            <div class="course-details">
                <h2 class="course-title">{{ $course['courseName'] }}</h2>
                <p class="course-description">{{ $course['createdBy'] }}</p>
                {{-- <p>progress: {{ round($course->totalProgress) }}</p> --}}
                {{-- <p>total time: {{ $course->expectedDurationInSeconds }}</p> --}}

                <!-- Progress Tracker -->
                <div class="progress-container">
                    <label for="progress"></label>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $course->progressPercentage }}%;"></div>
                    </div>
                </div>
                {{-- <p class="course-description">{{ round($progressPercentage) }}% Complete</p> --}}
                <p class="course-description">{{ min($course->progressPercentage, 100) }}% Complete</p>
        </a>
                @php
                    $userName = \App\Models\User::where('_id', session('user_id'))->value('name'); 
                @endphp
                
                <div class="d-flex justify-content-between align-items-center">
                @if (!($course->isCompleted || $course->progressPercentage>= 100))
                <a href="{{ route('allCommentsView', ['id' => $course['_id']]) }}">
                    <div class="rating-container text-center"> <!-- Wrap the rating label and stars in a div -->
                        <p class="rating-label">Complete Course Rating</p> <!-- Rating label above the stars -->
                        <div class="star-rating" title="{{ number_format($course['rating'], 1) }}">
                            <div class="stars-outer">
                                <div class="stars-inner" style="width: {{ ($course['rating'] / 5) * 100 }}%;"></div>
                            </div>
                        </div>
                        <span class="rating-value" id="ratingValue">{{ number_format($course['rating'], 1) }}</span>
                    </div>
                </a>
                @else

                    <div class="rating-container text-center"> <!-- Wrap the rating label and stars in a div -->
                         <!-- Rating label above the stars -->
                        
                        @php
                            $userRating = \App\Models\CourseRating::where('userId', (string) session('user_id'))
                                ->where('courseId', $course['_id'])
                                ->value('ratings');
                        @endphp

                        @if (!$userRating)
                        <a href="{{ route('ratingCoursePage', ['id' => $course['_id']]) }}">
                        <p class="rating-label">Leave a rating</p>
                        @else
                        <p class="rating-label">Your Rating</p>
                        @endif
                            <div class="star-rating" title="{{ number_format($userRating, 1) }}">
                                <div class="stars-outer">
                                    <div class="stars-inner" style="width: {{ ($userRating / 5) * 100 }}%;"></div>
                                </div>
                            </div>
                            <span class="rating-value" id="ratingValue">{{$userRating}}</span>
                        @if (!$userRating)
                        </a>
                        @endif
                    </div>
                    <button id="certificateButton" class="mainsb_btn" data-course-id="{{ $course->_id }}" data-course-name="{{ $course->courseName }}" data-user-name="{{ $userName }}"  type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" style="float: right">Get Certificate</button>

                @endif
                </div>
        <a href="{{ route('coursesViewDetails', ['id' => $course['_id']]) }}">
            </div>
        
    </div>
        </a>
    @endforeach

    {{-- <div class="page_pegination">
        {{ $courses->links() }}
    </div> --}}
