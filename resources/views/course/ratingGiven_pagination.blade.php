<div class="event_table">
    <table>
        <thead>
            <tr>
                <th>Course Name</th>
                <th>User Name</th>
                <th>Ratings</th>
                <th>Comment</th>
                {{-- <th>Edit Ratings</th>
                <th>Delete Ratings</th> --}}
            </tr>
        </thead>
        <tbody id="courseListingTable">
            @php 
            $i=1;
            @endphp
            @if($courseRating->isEmpty())
                <tr>
                    <td colspan="4" style="text-align: center;">There is no data</td>
                </tr>
            @else
                @foreach($courseRating->all() as $all)
                    <tr>
                        <td>{{$all->courseName}}</td>
                        <td>{{$all->username}}</td>
                        <td>{{$all->ratings}}</td>
                        <td>{!! $all->comment !!}</td>
                        {{-- <td>
                            <a href="{{ route('editpage.course', ['id' => $all->id]) }}" class="edit-icon" style=" margin-left: 10px; color: #990000; ">
                                <i class="fas fa-edit"></i> <!-- Font Awesome Edit Icon -->
                            </a>
                        </td>
                        <td>
                            <a href="javascript:void(0);" class="delete-icon" style=" margin-left: 10px; color: #990000; " onclick="confirmDelete('{{ $all->id }}')">
                                <i class="fas fa-trash"></i> <!-- Font Awesome Edit Icon -->
                            </a>
                        </td> --}}
                    </tr>
                @endforeach
            @endif
        </tbody>
        {{-- <input type="hidden" id="eventId" value="{{$eventId}}"> --}}
        <input type="hidden" id="startDate" name="startDate" placeholder="Start Date" />
        <input type="hidden" id="endDate" name="endDate" placeholder="End Date" />

    </table>
</div>

<div class="page_pegination">
    {{ $courseRating->links() }}
</div>