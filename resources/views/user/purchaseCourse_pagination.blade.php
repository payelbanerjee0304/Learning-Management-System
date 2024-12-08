<div class="event_table">
    <table>
        <thead>
            <tr>
                {{-- <th>Thumbnail</th> --}}
                <th>Course Name</th>
                <th>Creator</th>
                <th>Cost</th>
                <th>Rating</th>
                <th>Pay</th>
            </tr>
        </thead>
        <tbody id="courseListingTable">
            @php 
            $i=1;
            @endphp
            @foreach($course->all() as $all)
            <tr>
                {{-- <td>
                    <div class="thumbnail-box">
                        <img src="{{$all->thumbnail}}" height="10" width="50" alt="img" class="thumbnailImg">
                    </div>
                </td> --}}
                <td>{{$all->courseName}}</td>
                {{-- <td>{{$all->courseDescription}}</td> --}}
                <td>{{$all->createdBy}}</td>
                <td>{{ $all->coursevalue ? '$' . $all->coursevalue : 'Free' }}</td>
                <td>
                <div class="star-rating" title="{{ number_format($all->rating, 1) }}">
                    <div class="stars-outer">
                        <div class="stars-inner" style="width: {{ ($all->rating / 5) * 100 }}%;"></div>
                    </div>
                </div>
                <span class="rating-value" id="ratingValue">{{ number_format($all->rating, 1) }}</span>
                </td>

                

                <td>
                    <a href="javascript:void(0);" class="cart-icon" id="cartIcon_{{ $all->_id }}" 
                        style="margin-left: 10px; color: #990000;" 
                        onclick="addToCart('{{ $all->_id }}', '{{ $all->courseName }}', '{{ $all->coursevalue }}')">
                        <i class="fa-solid fa-cart-shopping"></i> <!-- Font Awesome Edit Icon -->
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="page_pegination">
    {{ $course->links() }}
</div>