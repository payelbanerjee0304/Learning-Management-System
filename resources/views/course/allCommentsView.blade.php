@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .ldr_bx_flx{
        padding: 2rem;

    }
    .cmntImg {
        height: 75px;
        width: 75px;
        border-radius: 50%;
    }

    .arwImge{
        width: 35px;
    }

    .rating-container {
        text-align: center;
    }

    .rating-label {
        font-size: 12px;
        color: #333;
        margin-bottom: 1px; /* Adjust space between label and stars */
    }

    .star-rating {
        font-size: 20px; /* Adjust the size to match your layout */
        display: inline-block;
        position: relative;
    }

    .stars-outer {
        display: inline-block;
        position: relative;
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        color: #e4e4e4; /* Color for the empty stars */
    }

    .stars-inner {
        position: absolute;
        top: 0;
        left: 0;
        white-space: nowrap;
        overflow: hidden;
        color: #FFD700; /* Color for the filled stars */
        width: 0%; /* Initially set to 0%, dynamically updated via inline style */
    }

    /* Define 5 empty stars in the stars-outer container */
    .stars-outer::before {
        content: "\f005 \f005 \f005 \f005 \f005"; /* FontAwesome star unicode */
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
    }

    /* Define 5 filled stars in the stars-inner container, which will be clipped */
    .stars-inner::before {
        content: "\f005 \f005 \f005 \f005 \f005"; /* FontAwesome star unicode */
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
    }

    .rating-value {
        position: absolute;
        top: -20px; /* Adjust based on positioning */
        left: 0;
        font-size: 14px;
        font-weight: bold;
        color: #333;
        visibility: hidden; /* Hide by default */
    }

    .star-rating:hover .rating-value {
        visibility: visible; /* Show when hovering */
    }
</style>
    <section class="main_home_sec">
        <div class="main_home_ottr">
            <div class="hm_fst">
                <div class="leaderb_part">
                    <div class="fst_tp_flx">
                        <div class="fst_tp_lft">
                            <div class="fst_tp_lft_img">
                                <div class="fst_tp_lft_pc">
                                    <a href="javascript:window.history.back()">
                                        <img src="{{ asset('images/left_arrow.png') }}" alt="img" class="arwImge" />
                                    </a>
                                </div>
                            </div>
                            <div class="fst_tp_lft_txt">

                                <h5>All Comments</h5>
                            </div>
                        </div>
                    </div>
                    <div class="ldr_bttm_tabs">
                        <div id="ldrTab">
                            <ul class="resp-tabs-list">
                                {{-- <li>All</li>
                                <li>Terapanth</li>
                                <li>Mahasabha</li>
                                <li>Other</li> --}}
                            </ul>
                            <div class="resp-tabs-container">
                                <div class="ldr_bx_ttl">
                                    <div class="ldr_bx_flx">
                                        <div class="ldr_bx_flx_lft">
                                        @if($ratings->isEmpty())
                                            <p style=" font-size: 25px">There is no Comments.</p>
                                        @else
                                            @foreach($ratings as $rating)
                                            <div class="ldr_bx">
                                                <div class="ldr_tp_bx_top">
                                                    <div class="ldr_bx_tp_lft">
                                                        <div class="ldr_lft_img_ttl">
                                                            {{-- <span><img src="{{ asset('images/md-1.png') }}"
                                                                    alt="img" /></span> --}}
                                                            <div class="ldr_tp_lft_img">
                                                                <div class="ldr_tp_lft_pic">
                                                                    

                                                                    @php 

                                                                        $userImage = \App\Models\User::where('_id', $rating->userId)->value('imageFileLink');

                                                                    @endphp
                                                                    @if($userImage)
                                                                    <img src="{{ $userImage }}" alt="img" class="cmntImg" />
                                                                    @else
                                                                    <img src="{{ asset('images/no-img.png') }}"alt="img" class="cmntImg" />
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ldr_tp_lft_txt">
                                                            <h6 class="red">{{$rating->username}}</h6>
                                                            <span>{!!$rating->comment!!}</span>
                                                        </div>
                                                    </div>
                                                    <div class="ldr_bx_tp_rght">
                                                        {{-- <span class="pnt"><h6>{{$rating->ratings}}</h6></span> --}}
                                                        <div class="rating-container text-center">
                                                            <div class="star-rating" title="{{ number_format($rating->ratings, 1) }}">
                                                                <div class="stars-outer">
                                                                    <div class="stars-inner" style="width: {{ ($rating->ratings / 5) * 100 }}%;"></div>
                                                                </div>
                                                            </div>
                                                            <span class="rating-value" id="ratingValue">{{ number_format($rating->ratings, 1) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ldr_tp_bx_bttm">
                                                </div>
                                            </div>
                                            {{-- <div class="ldr_bx">
                                                <div class="ldr_tp_bx_top">
                                                    <div class="ldr_bx_tp_lft">
                                                        <div class="ldr_lft_img_ttl">
                                                            <span><img src="{{ asset('images/md-2.png') }}"
                                                                    alt="img" /></span>
                                                            <div class="ldr_tp_lft_img">
                                                                <div class="ldr_tp_lft_pic">
                                                                    <img src="{{ asset('images/ld-2.png') }}"
                                                                        alt="img" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ldr_tp_lft_txt">
                                                            <h6 class="red">संजीव बैद</h6>
                                                            <span>फरीदाबाद</span>
                                                        </div>
                                                    </div>
                                                    <div class="ldr_bx_tp_rght">
                                                    <span class="pnt"><h6>900</h6></span>
                                                    </div>
                                                </div>
                                                <div class="ldr_tp_bx_bttm">
                                                    <span>To do-<bdi>2</bdi></span>
                                                    <span>In Progress-<bdi>4</bdi></span>
                                                    <span>Due-<bdi>3</bdi></span>
                                                    <span>Completed-<bdi>11</bdi></span>
                                                </div>
                                            </div> --}}
                                            @endforeach
                                        @endif
                                        </div>
                                        <div class="ldr_bx_flx_rght">
                                            {{-- <div class="ldr_bx">
                                                <div class="ldr_tp_bx_top">
                                                    <div class="ldr_bx_tp_lft">
                                                        <div class="ldr_lft_img_ttl">
                                                            <span><img src="{{ asset('images/md-3.png') }}"
                                                                    alt="img" /></span>
                                                            <div class="ldr_tp_lft_img">
                                                                <div class="ldr_tp_lft_pic">
                                                                    <img src="{{ asset('images/ld-3.png') }}"
                                                                        alt="img" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ldr_tp_lft_txt">
                                                            <h6 class="red">संजय खटेड</h6>
                                                            <span>दिल्ली</span>
                                                        </div>
                                                    </div>
                                                    <div class="ldr_bx_tp_rght">
                                                    <span class="pnt"><h6>980</h6></span>
                                                    </div>
                                                </div>
                                                <div class="ldr_tp_bx_bttm">
                                                    <span>To do-<bdi>2</bdi></span>
                                                    <span>In Progress-<bdi>4</bdi></span>
                                                    <span>Due-<bdi>3</bdi></span>
                                                    <span>Completed-<bdi>11</bdi></span>
                                                </div>
                                            </div> --}}
                                            {{-- <div class="ldr_bx">
                                                <div class="ldr_tp_bx_top">
                                                    <div class="ldr_bx_tp_lft">
                                                        <div class="ldr_lft_img_ttl">
                                                            <span><bdi>4</bdi></span>
                                                            <div class="ldr_tp_lft_img">
                                                                <div class="ldr_tp_lft_pic">
                                                                    <img src="{{ asset('images/ld-1.png') }}"
                                                                        alt="img" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ldr_tp_lft_txt">
                                                            <h6 class="red">विजय चोपड़ा</h6>
                                                            <span>गुवाहाटी</span>
                                                        </div>
                                                    </div>
                                                    <div class="ldr_bx_tp_rght">
                                                    <span class="pnt"><h6>1000</h6></span>
                                                    </div>
                                                </div>
                                                <div class="ldr_tp_bx_bttm">
                                                    <span>To do-<bdi>2</bdi></span>
                                                    <span>In Progress-<bdi>4</bdi></span>
                                                    <span>Due-<bdi>3</bdi></span>
                                                    <span>Completed-<bdi>11</bdi></span>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="ldr_part_bttm">
                                        {{-- <a href="javacsript:void(0);">Show more</a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')

@endsection
