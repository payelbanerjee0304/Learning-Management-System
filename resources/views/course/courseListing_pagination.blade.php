<div class="event_table">
    <table>
        <thead>
            <tr>
                <th>Thumbnail</th>
                <th>Course Name</th>
                {{-- <th>Course Description</th> --}}
                <th>Creator</th>
                <th>No. of Subscibers</th>
                <th>Rating</th>
                <th>Edit Course Details</th>
                <th>Delete Course</th>
            </tr>
        </thead>
        <tbody id="courseListingTable">
            @php 
            $i=1;
            @endphp
            @foreach($course->all() as $all)
            <tr>
                <td>
                    <div class="thumbnail-box">
                        <img src="{{$all->thumbnail}}" height="10" width="50" alt="img" class="thumbnailImg">
                    </div>
                </td>
                <td>{{$all->courseName}}</td>
                {{-- <td>{{$all->courseDescription}}</td> --}}
                <td>{{$all->createdBy}}</td>
                <td>{{ count($all->subscribedUsers ?? []) }}</td>
                <td>
                <div class="star-rating" title="{{ number_format($all->rating, 1) }}">
                    <div class="stars-outer">
                        <div class="stars-inner" style="width: {{ ($all->rating / 5) * 100 }}%;"></div>
                    </div>
                </div>
                <span class="rating-value" id="ratingValue">{{ number_format($all->rating, 1) }}</span>
                </td>

                

                <td>
                    <a href="{{ route('editpage.course', ['id' => $all->id]) }}" class="edit-icon" style=" margin-left: 10px; color: #990000; ">
                        <i class="fas fa-edit"></i> <!-- Font Awesome Edit Icon -->
                    </a>
                </td>
                <td>
                    <a href="javascript:void(0);" class="delete-icon" style=" margin-left: 10px; color: #990000; " onclick="confirmDelete('{{ $all->id }}')">
                        <i class="fas fa-trash"></i> <!-- Font Awesome Edit Icon -->
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
        {{-- <input type="hidden" id="eventId" value="{{$eventId}}"> --}}
        <input type="hidden" id="startDate" name="startDate" placeholder="Start Date" />
        <input type="hidden" id="endDate" name="endDate" placeholder="End Date" />

    </table>
</div>

<div class="page_pegination">
    {{ $course->links() }}
</div>