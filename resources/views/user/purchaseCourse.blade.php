@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    .pagination-links {
        font-size: 2rem;
    }

    .select2-results__option,
    .select2-search__field,
    .select2-selection__placeholder {
        font-size: 2rem;

    }
    .thumbnailImg{
        height: 40px;
    }
    .thumbnail-box {
        display: inline-block;
        padding: 10px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
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
<div id="cartPanel" class="cart-panel">
    <div id="arrowToggle" class="arrow-toggle">&gt;</div>
    <div class="cart-header">
        <h3>Your Cart</h3>
        <button class="close-cart" onclick="toggleCart()">✖</button>
    </div>
    <div class="cart-body" id="cartBody">
        <p>Your cart is empty.</p>
    </div>
    <div class="cart-footer">
        <button class="checkout-btn">Checkout</button>
    </div>
</div>

<div class="d_brd_otr">
    <div class="d_brd_tp">
        <a href="javascript:window.history.back()"><img src="{{asset('images/left_arrow.png')}}" /></a>
        <h3>Purchase Course</h3>
    </div>
    <div class="evnt-srch">
        <div class="options">
            
        </div>
        <div class="search_bar">
            <input type="text" id="keyword" name="keyword" placeholder="Name Search" class="search_holder" />
            <input type="button" class="search-btn" />
            <div class="icon" id="searchSubmit">
                <img src="{{asset('images/search_icn.png')}}" alt="search_icn" />
            </div>
        </div>
    </div>
</div>
<div id="tableData" class="tabBLE">
    @include('user.purchaseCourse_pagination')

</div>
@endsection
@section('customJs')
<script>
    function showEditForm(id) {
        // Hide all open forms and show edit icons for other rows
        document.querySelectorAll('[id^="editForm_"]').forEach((form) => {
            form.style.display = 'none';
        });
        document.querySelectorAll('[id^="editIcon_"]').forEach((icon) => {
            icon.style.display = 'inline-block';
        });

        // Show the selected form and hide the edit icon
        const form = document.getElementById(`editForm_${id}`);
        const icon = document.getElementById(`editIcon_${id}`);
        if (form) {
            form.style.display = 'block';
        }
        if (icon) {
            icon.style.display = 'none';
        }
    }
    function toggleCustomInput(selectElement, id) {
        const customInput = document.getElementById(`customCourseValue_${id}`);
        if (selectElement.value === 'custom') {
            customInput.style.display = 'inline-block';
        } else {
            customInput.style.display = 'none';
            customInput.value = ''; // Clear custom input value
        }
    }

    function fetch_data(page) {
        $.ajax({
            url: "{{route('purchaseCourse.pagination')}}",
            data:{page:page},
            success: function(data) {
                $('#tableData').html(data);
            }
        });
    }

    function search_data(keyword, page = 1) {
        $.ajax({
            url: "{{ route('purchaseCourse.search') }}",
            data:{keyword: keyword, page: page},
            success: function(data) {
                $('#tableData').html(data);
            }
        });
    }

    $(document).on('click', '.pagination a', function(event) {

        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var keyword = $('#keyword').val();
        console.log(keyword);
        if(keyword)
        {
            search_data(keyword,page);
        }
        else
        {
            fetch_data(page);
        }
    });

    $('#searchSubmit').on('click', function(event) {

        event.preventDefault();
        var keyword = $('#keyword').val();
        search_data(keyword);
    });

    $('#keyword').on('keydown', function(event) {
        if (event.keyCode === 13) {  
            event.preventDefault();
            var keyword = $(this).val();
            search_data(keyword);
        }
    });

    let cartItems = [];

    // Toggle the cart visibility
    function toggleCart() {
        const $cartPanel = $('#cartPanel');
        const $arrowToggle = $('#arrowToggle');

        // Toggle the cart panel class
        $cartPanel.toggleClass('open');

        // Change arrow direction
        if ($cartPanel.hasClass('open')) {
            $arrowToggle.html('&lt;'); // Left arrow
        } else {
            $arrowToggle.html('&gt;'); // Right arrow
        }
    }

    // Add a course to the cart
    function addToCart(courseId, courseName, courseValue) {
        // Check if the course is already in the cart
        const existingItem = cartItems.find((item) => item.id === courseId);
        if (existingItem) {
            Swal.fire('This course is already in your cart.');
            return;
        }

        // Add new course to the cart
        cartItems.push({ id: courseId, name: courseName, price: courseValue || 'Free' });

        // Update the cart UI
        updateCartUI();

        // Open the cart
        if (!$('#cartPanel').hasClass('open')) {
            toggleCart();
        }

        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                courseId: courseId,
                name: courseName,
                price: courseValue || 'Free',
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                // Update UI with the backend cart response (total, etc.)
                updateCartUI(response.cart);
            }
        });
    }

    // Update the cart UI
    function updateCartUI() {
        const $cartBody = $('#cartBody');
        const $cartFooter = $('.cart-footer');

        if (cartItems.length === 0) {
            $cartBody.html('<p>Your cart is empty.</p>');
            $cartFooter.html(`
                <button class="checkout-btn" disabled>Checkout</button>
            `);
        } else {
            let totalAmount = 0;

            let cartHTML = `
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="text-align: left; padding: 10px;">Course Name</th>
                            <th style="text-align: right; padding: 10px;">Price</th>
                            <th style="text-align: center; padding: 10px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            cartItems.forEach((item) => {
                const price = item.price === 'Free' ? 0 : parseFloat(item.price);
                totalAmount += price;

                cartHTML += `
                    <tr>
                        <td style="padding: 10px;">${item.name}</td>
                        <td style="text-align: right; padding: 10px;">${item.price === 'Free' ? 'Free' : '$' + price.toFixed(2)}</td>
                        <td style="text-align: center; padding: 10px;">
                            <button class="remove-item" data-id="${item.id}" 
                                    style="color: white; border: none; cursor: pointer;">
                                ✖
                            </button>
                        </td>
                    </tr>
                `;
            });

            cartHTML += `
                        </tbody>
                    </table>
                `;

            $cartBody.html(cartHTML);

            // Update cart footer with total and checkout button
            $cartFooter.html(`
                <div style="margin: 10px 0; font-size: 16px; text-align: right;">
                    <strong>Total:</strong> $${totalAmount.toFixed(2)}
                </div>
                <button class="checkout-btn">Checkout</button>
            `);
        }
    }


    // Remove a course from the cart
    function removeFromCart(courseId) {
        // Filter out the item with the matching ID
        cartItems = cartItems.filter((item) => item.id !== courseId);

        // Update the cart UI
        updateCartUI();

        $.ajax({
            url: '/cart/remove',
            method: 'POST',
            data: {
                courseId: courseId,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                // Handle backend response and update cart UI
                updateCartUI(response.cart);
            }
        });

        // Show a message when the cart is empty
        if (cartItems.length === 0) {
            Swal.fire('Your cart is now empty.');
        }
    }

    // jQuery Document Ready
    $(document).ready(function () {
        // Bind click event for the toggle button
        $('#arrowToggle').on('click', toggleCart);

        // Delegate click event for remove buttons in the cart
        $('#cartBody').on('click', '.remove-item', function () {
            const courseId = $(this).data('id');
            removeFromCart(courseId);
        });

        $.ajax({
            url: '/cart',
            method: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    cartItems = response.cart;  // Store the cart items in the global variable
                    updateCartUI();  // Update the cart UI
                } else {
                    cartItems = [];  // No cart data, initialize as empty
                    updateCartUI();  // Update the UI with empty cart
                }
            },
            error: function() {
                console.log('Error fetching cart data');
            }
        });
    });



</script>
@endsection