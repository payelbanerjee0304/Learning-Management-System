<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Course;

class SubscriptionController extends Controller
{
    public function courseValue()
    {
        $course=Course::where('isDeleted', false)->OrderBy('created_at', 'desc')->paginate(5);
        return view('admin.courseValue',compact('course'));
    }

    public function paginateCourseValue(Request $request)
    {
        $course=Course::where('isDeleted', false)->OrderBy('created_at', 'desc')->paginate(5);

        return view('admin.courseValue_pagination', compact('course'))->render();
    }

    public function searchCourseValue(Request $request)
    {
        $keyword = $request->input('keyword');
        $course = Course::where('courseName', 'LIKE', "%{$keyword}%")->where('isDeleted', false)
                        ->OrderBy('created_at', 'desc')
                        ->paginate(5);

        return view('admin.courseValue_search', compact('course'))->render();
    }

    public function updateCourseValue(Request $request, $id)
    {

        $courseValue = $request->input('courseValueOption') === 'custom'
            ? $request->input('customCourseValue')
            : $request->input('courseValueOption');

        if ($courseValue === null || $courseValue === '') {
            return back()->withErrors(['error' => 'Please provide a valid course value.']);
        }

        $course = Course::findOrFail($id);
        $course->coursevalue = $courseValue;
        $course->save();

        return back()->with('success', 'Course value updated successfully.');
    }

}
