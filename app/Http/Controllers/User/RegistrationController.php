<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Course;
use App\Models\UserCart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('user/registration');
    }

    public function register(Request $request)
    {
        $phone = $request->input('mobile');
        $existingUser = User::where('phone', $phone)->first();

        if ($existingUser) {
            return response()->json(['status' => 'exists'], 200);
        }

        $registration = new User();
        $registration->name = $request->input('name');
        $registration->email = $request->input('email');
        $registration->phone = $phone;
        $registration->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function purchaseCourse()
    {
        $course=Course::where('isDeleted', false)->OrderBy('created_at', 'desc')->paginate(5);
        return view('user.purchaseCourse',compact('course'));
    }

    public function paginatePurchaseCourse(Request $request)
    {
        $course=Course::where('isDeleted', false)->OrderBy('created_at', 'desc')->paginate(5);

        return view('user.purchaseCourse_pagination', compact('course'))->render();
    }

    public function searchPurchaseCourse(Request $request)
    {
        $keyword = $request->input('keyword');
        $course = Course::where('courseName', 'LIKE', "%{$keyword}%")->where('isDeleted', false)
                        ->OrderBy('created_at', 'desc')
                        ->paginate(5);

        return view('user.purchaseCourse_search', compact('course'))->render();
    }

    public function addToCart(Request $request)
    {
        $userId = Session::get('user_id');
        $course = $request->only(['courseId', 'name', 'price']);
        $cartData = UserCart::where('user_id', $userId)->first();

        $cart = []; // Default to an empty cart

        if ($cartData) {
            // Decode the existing cart only if it's not already an array
            $cart = is_array($cartData->cart) ? $cartData->cart : json_decode($cartData->cart, true);

            // Check if the course is already in the cart
            $existingItem = collect($cart)->firstWhere('courseId', $course['courseId']);
            if ($existingItem) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This course is already in your cart.'
                ]);
            }

            // Add the new course to the cart
            $cart[] = $course;
        } else {
            // Initialize the cart as an array with the new course
            $cart = [$course];
        }

        $totalCartValue = $this->calculateTotalCartValue($cart);

        // Save or update the cart in the database
        UserCart::updateOrInsert(
            ['user_id' => $userId],
            [
                'cart' => $cart, // Save as an array (Laravel will handle JSON conversion)
                'total_cart_value' => $totalCartValue,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Course added to cart',
            'cart' => $cart,
            'total' => $totalCartValue
        ]);
    }

    private function calculateTotalCartValue(array $cart): float
    {
        return array_reduce($cart, function ($carry, $item) {
            return $carry + floatval($item['price']);
        }, 0);
    }

    // Remove a course from the cart
    public function removeFromCart(Request $request)
    {
        $userId = Session::get('user_id');
        $courseId = $request->input('courseId');

        // Fetch the user's cart from the database
        $cartData = UserCart::where('user_id', $userId)->first();

        if ($cartData) {
            // Decode the existing cart or use it directly if it's already an array
            $cart = is_array($cartData->cart) ? $cartData->cart : json_decode($cartData->cart, true);

            // Filter out the course with the matching ID
            $updatedCart = array_filter($cart, function ($item) use ($courseId) {
                return $item['courseId'] !== $courseId;
            });

            // Re-index the array (optional, for cleaner structure)
            $updatedCart = array_values($updatedCart);

            // Calculate the new total cart value
            $totalCartValue = $this->calculateTotalCartValue($updatedCart);

            if (empty($updatedCart)) {
                // If the cart is empty, delete the cart entry for the user
                UserCart::where('user_id', $userId)->delete();
            } else {
                // Otherwise, update the cart
                UserCart::where('user_id', $userId)->update([
                    'cart' => $updatedCart, // Laravel handles JSON conversion
                    'total_cart_value' => $totalCartValue,
                    'updated_at' => now(),
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Course removed from the cart.',
                'cart' => $updatedCart,
                'total' => $totalCartValue,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Cart not found or already empty.',
        ]);
    }

    public function getCart(Request $request)
    {
        $userId = Session::get('user_id');  // Get the user ID from the session
        
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'User not found.']);
        }

        $cartData = UserCart::where('user_id', $userId)->first();

        if ($cartData) {
            // No need to decode, as it's already an array
            return response()->json([
                'status' => 'success',
                'cart' => $cartData->cart,  // cart is an array now
                'total' => $cartData->total_cart_value
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No cart found for this user.'
        ]);
    }


}
