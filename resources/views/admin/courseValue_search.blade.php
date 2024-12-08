<div class="event_table">
    <table>
        <thead>
            <tr>
                <th>Thumbnail</th>
                <th>Course Name</th>
                <th>Creator</th>
                <th>Subscibers</th>
                <th>Rating</th>
                <th>Edit Course Payment</th>
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

                

                <td>$ {{ $all->coursevalue }}
                    <a href="javascript:void(0);" class="edit-icon" id="editIcon_{{ $all->_id }}" style="margin-left: 10px; color: #990000;" 
                    onclick="showEditForm('{{ $all->_id }}')">
                        <i class="fas fa-edit"></i> <!-- Font Awesome Edit Icon -->
                    </a>
                    <div id="editForm_{{ $all->_id }}" style="display: none; margin-top: 10px;">
                        <form action="{{ route('updateCourseValue', ['id' => $all->_id]) }}" method="POST">
                            @csrf
                            <select name="courseValueOption" id="courseValueOption_{{ $all->_id }}" onchange="toggleCustomInput(this, '{{ $all->_id }}')">
                                <option value="">Select</option>
                                <option value="0">Free</option>
                                <option value="299">$299</option>
                                <option value="399">$399</option>
                                <option value="599">$599</option>
                                <option value="custom">Custom</option>
                            </select>
                            <input 
                                type="text" 
                                name="customCourseValue" 
                                id="customCourseValue_{{ $all->_id }}" 
                                placeholder="Value in Dollar" 
                                style="display: none; margin-left: 10px;"
                            >
                            <button type="submit" class="edit-icon" style="margin-left: 10px; color: #990000;">
                                save <!-- Font Awesome Save Icon -->
                            </button>
                        </form>
                    </div>
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