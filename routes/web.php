<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\User\RegistrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/login',[AdminController::class, 'login'])->name('admin.login')->middleware('admin.redirect');
 
    Route::post('/save', [AdminController::class, 'save'])->name('admin.save');
    Route::post('/verifyAndLogin', [AdminController::class, 'verifyAndLogin'])->name('admin.verifyAndLogin');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

Route::get('/login', function () {
    return view('user.login');
})->name('login')->middleware('user.redirect');
Route::post('/save', [UserController::class, 'save']);
Route::post('/verifyAndLogin', [UserController::class, 'verifyAndLogin']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware(['adminLoggedIn'])->group(function () {
    Route::get('/create_course', [CourseController::class, 'createCourse'])->name("create_course");

    Route::post('/submit_course/{id?}', [CourseController::class, 'insertCourse'])->name('submit_course');
    // Route::post('/submit_course/{id}', [CourseController::class, 'insertCourse'])->name('update_course');
    Route::get('/create_course/{id}', [CourseController::class, 'editCourse'])->name('edit.course');

    Route::get('/edit_chapter/{courseId}/{chapterIndex}', [CourseController::class, 'editChapter'])->name('edit.chapter');
    Route::post('/update-chapter/{courseId}/{chapterIndex}', [CourseController::class, 'updateChapter'])->name('update.chapter');
    Route::post('/upload-chunk', [CourseController::class, 'uploadChunk'])->name('upload-chunk');

    Route::get('/delete-topic', [CourseController::class, 'deleteTopic'])->name('delete.topic');
    Route::get('/delete-qna', [CourseController::class, 'deleteQna'])->name('delete.qna');
    Route::get('/delete-qna-option', [CourseController::class, 'deleteQnaOption'])->name('delete.qna.option');

    Route::get('/course-listing',[CourseController::class, 'courseListing'])->name('courseListing');
    Route::get('/course-pagination', [CourseController::class, 'paginateCourse'])->name('courseListing.pagination');
    Route::get('/course-search', [CourseController::class, 'searchCourse'])->name('courseListing.search');

    Route::get('/edit_course/{id}', [CourseController::class, 'editPageCourse'])->name('editpage.course');
    Route::delete('/course/delete', [CourseController::class, 'deleteCourse'])->name('deletepage.course');

    Route::get('/deleteVideo', [CourseController::class, 'deleteVideo'])->name('delete.video');
    Route::get('/deletePdf', [CourseController::class, 'deletePdf'])->name('delete.pdf');
    Route::get('/deleteThumbnail', [CourseController::class, 'deleteThumbnail'])->name('delete.thumbnail');


    Route::get('/course-value', [SubscriptionController::class, 'courseValue'])->name('courseValue');
    Route::get('/course-value-pagination', [SubscriptionController::class, 'paginateCourseValue'])->name('courseValue.pagination');
    Route::get('/course-value-search', [SubscriptionController::class, 'searchCourseValue'])->name('courseValue.search');
    Route::post('/course/update-value/{id}', [SubscriptionController::class, 'updateCourseValue'])->name('updateCourseValue');

});

Route::get('/rating-course-page/{id}',[CourseController::class, 'ratingCoursePage'])->name('ratingCoursePage');
Route::post('/submit_rating', [CourseController::class, 'ratingSubmit'])->name('submit_rating');
Route::get('/all-comments-view/{id}',[CourseController::class, 'allCommentsView'])->name('allCommentsView');

Route::get('/rating-given',[CourseController::class, 'ratingGiven'])->name('ratingGiven');
Route::get('/paginateRatingGiven', [CourseController::class, 'paginateRatingGiven'])->name('ratingGiven.pagination');
Route::get('/searchRatingGiven', [CourseController::class, 'searchRatingGiven'])->name('ratingGiven.search');
Route::get('/filterRatingGiven', [CourseController::class, 'filterRatingGiven'])->name('ratingGiven.filter');

Route::get('/course-streaming', [CourseController::class, 'courseStreaming'])->name('courseStreaming');
Route::get('/course-streaming-pagination', [CourseController::class, 'paginateCourseStreaming'])->name('courseStreaming.pagination');
Route::get('/course-streaming-search', [CourseController::class, 'searchCourseStreaming'])->name('courseStreaming.search');
Route::get('/courseStreaming-chapters/{id}', [CourseController::class, 'courseStreamingChapters'])->name('courseStreaming-chapters');

Route::get('/course/{courseId}/download-report', [CourseController::class, 'downloadReportCard'])->name('downloadReportCard');


//user end
Route::middleware(['userLoggedIn'])->group(function () {
    Route::get('/coursesView', [CourseController::class, 'courses'])->name('coursesView');
    Route::get('/paginateCoursesView', [CourseController::class, 'paginateCoursesView'])->name('coursesView.pagination');
    Route::get('/searchCoursesView', [CourseController::class, 'searchCoursesView'])->name('coursesView.search');

    Route::get('/coursesView/{id}', [CourseController::class, 'courseDetails'])->name('coursesViewDetails');
    Route::post('/submit-quiz-answer', [CourseController::class, 'submitAnswer'])->name('submit.quiz.answer');
    Route::get('/course/{id}/report-card', [CourseController::class, 'generateReportCard'])->name('course.report-card');

    Route::get('/coursesView-content/{id}/{chapter_id}/{topic_id}', [CourseController::class, 'courseContent'])->name('coursesViewContent');
    Route::post('/save-video-progress', [CourseController::class, 'saveVideoProgress']);
    Route::post('/check-course-completion', [CourseController::class, 'checkCourseCompletion']);
    Route::get('/generate-certificate/{course_id}', [CourseController::class, 'generateCertificate'])->name('generate.certificate');

    Route::get('/purchase-course', [RegistrationController::class, 'purchaseCourse'])->name('purchaseCourse');
    Route::get('/purchase-course-pagination', [RegistrationController::class, 'paginatePurchaseCourse'])->name('purchaseCourse.pagination');
    Route::get('/purchase-course-search', [RegistrationController::class, 'searchPurchaseCourse'])->name('purchaseCourse.search');

    Route::post('/cart/add', [RegistrationController::class, 'addToCart']);
    Route::post('/cart/remove', [RegistrationController::class, 'removeFromCart']);
    Route::get('/cart', [RegistrationController::class, 'getCart']);
});

Route::get('/user-registration', [RegistrationController::class, 'index'])->name('userRegistration.index');
Route::post('/user-registration-submit', [RegistrationController::class, 'register'])->name('userRegistration.register');