<div class="event_table">
    <table>
        <thead>
            <tr>
                <th>Thumbnail</th>
                <th>Course Name</th>
                <th>Creator</th>
                <th>Course Description</th>
                <th>View Chapters</th>
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
                        <img src="{{$all->thumbnail}}" height="10" alt="img" class="thumbnailImg">
                    </div>
                </td>
                <td>{{$all->courseName}}</td>
                <td>{{$all->createdBy}}</td>
                <td>{{$all->courseDescription}}</td>
                <td>
                    <a href="{{ route('courseStreaming-chapters', ['id' => $all->id]) }}" class="edit-icon" style=" margin-left: 10px; color: #990000; ">
                        <i class="fa-solid fa-book"></i>
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