<?php

namespace App\Http\Controllers;
use DateInterval;

use App\Models\User;
use App\Models\Course;
use GuzzleHttp\Client;
use App\Models\QuizResult;

use MongoDB\BSON\ObjectId;

use App\Models\CourseRating;
use Illuminate\Http\Request;
use Aws\S3\MultipartUploader;
use Aws\Exception\AwsException;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf;

use Illuminate\Support\Facades\DB;
use App\Models\CourseCompletedUser;
use App\Models\CourseVideoProgress;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function createCourse()
    {
        return view('course/create_course');
    }

    public function insertCourse(Request $request, $id=null)
    {
        // print_r($id);die;
        // echo "<pre>";
        // print_r($request->all());die;
        $formData = $request->all();

        // $course = $id ? Course::find($id) : new Course();
        if ($id && $id !== 'create_course') {

            $course = Course::find($id);
            if (!$course) {
                return response()->json([
                    'success' => false,
                    'message' => 'Course not found.',
                ]);
            }
        } else {
            $course = new Course();
            $course->isDeleted = false;
        }

        $course->courseName = $formData['courseName'];
        $course->courseDescription = $formData['courseDescription'];
        $course->createdBy = $formData['createdBy'];

        if($request->file('thumbnail')){
            
            $thumbnail=$request->file('thumbnail');
            $thumbnailname=time()."_".$thumbnail->getClientOriginalName();
            // $s3BucketFolder = 'images';
            // $path = Storage::disk('s3')->putFileAs($s3BucketFolder, $thumbnail, $thumbnailname);
            // $thumbnailUrl = Storage::disk('s3')->url($path);
            // $course->thumbnail = $thumbnailUrl;

            $uploadlocationThumbnail="./thumbnail";
            $thumbnail->move($uploadlocationThumbnail,$thumbnailname);
            $thumbnailUrl = $uploadlocationThumbnail.'/'.$thumbnailname;
            $course->thumbnail = $thumbnailUrl;
        }else{
            if ($id) {
                $existingCourse = Course::find($id);
                if ($existingCourse && isset($existingCourse->thumbnail)) {
                    $course->thumbnail = $existingCourse->thumbnail; // Keep the previous thumbnail
                }
            }
        }
        $course->learningDesc = $formData['learningDesc'];

        $chapters = $formData['subtasks'];

        foreach ($chapters as $index => &$chapter) {
            $existingCourse = Course::find($id);

            if (!isset($existingCourse->chapters[$index]['_id'])) {
                $chapter['_id'] = new ObjectId();
            }else{
                $chapter['_id']=$existingCourse->chapters[$index]['_id'];
            }
            foreach ($chapter['topics'] as $detailIndex => &$detail) {

                if (!isset($existingCourse->chapters[$index]['topics'][$detailIndex]['_id'])) {
                    $detail['_id'] = new ObjectId();
                }else{
                    $detail['_id']=$existingCourse->chapters[$index]['topics'][$detailIndex]['_id'];
                }

                if($request->file("subtasks.{$index}.topics.{$detailIndex}.content")){
                    
                    $contentType = $request->input("subtasks.{$index}.topics.{$detailIndex}.contentType");
                    if ($contentType === "pdf") {
                        // Handle PDF upload
                        $file=$request->file("subtasks.{$index}.topics.{$detailIndex}.content");
                        $filename = time() . "_" . $file->getClientOriginalName();
                        $video_path = $file->getRealPath();

                        $getID3 = new \getID3;
                        $filetext = $getID3->analyze($video_path);
                        // $duration = date('H:i:s.v', $filetext['playtime_seconds']);

                        // $s3BucketFolder = 'images'; 
                        // $path = Storage::disk('s3')->putFileAs($s3BucketFolder, $file, $filename);

                        // $fileUrl = Storage::disk('s3')->url($path);

                        $uploadlocationContent="./content";
                        $file->move($uploadlocationContent,$filename);
                        $fileUrl=$uploadlocationContent.'/'.$filename;

                        $detail['content'] = $fileUrl;
                        $detail['duration'] = null;
            
                    } else if ($contentType === "file") {
                    $detail['content'] = $detail['content'];
                    $detail['duration'] = $detail['duration'];
                    }

                }else {
                    $contentType = $request->input("subtasks.{$index}.topics.{$detailIndex}.contentType");
                    if ($contentType === 'youtube') {
                        $youtubeUrl = $detail['content'];
                        $videoId = $this->extractYoutubeVideoId($youtubeUrl);
        
                        if ($videoId) {
                            $apiKey = env('YOUTUBE_API_KEY'); // Store your API key in the .env file
                            $duration = $this->getYoutubeVideoDuration($videoId, $apiKey);
        
                            if ($duration) {
                                $detail['duration'] = $duration;
                                // $detail['duration'] = null;
                            } else {
                                $detail['duration'] = null; // If duration can't be fetched, store null
                            }
                        }
                    }

                    if (isset($detail['content']) && is_string($detail['content'])) {

                        $detail['content'] = $detail['content']; 
                    }
                    else {
                        $existingDetail = Course::find($id)->chapters[$index]['topics'][$detailIndex] ?? null;
                        if ($existingDetail && isset($existingDetail['content'])) {
                            $detail['content'] = $existingDetail['content']; // Keep the previous file content
                            $detail['duration'] = $existingDetail['duration']?? null; // Keep the previous file content
                        }
                    }
                }
            }
            foreach ($chapter['quiz'] as $detailIndex => &$detail) {

                if (!isset($existingCourse->chapters[$index]['quiz'][$detailIndex]['_id'])) {
                    $detail['_id'] = new ObjectId();
                }else{
                    $detail['_id']=$existingCourse->chapters[$index]['quiz'][$detailIndex]['_id'];
                }
                // if (isset($detail['lecture']) && is_string($detail['lecture'])) {
                //     $detail['lecture'] = $detail['lecture']; 
                // }
            }
        }

        $course->chapters = $chapters;

        if ($course->save()) {
            
            return response()->json([
                'success' => true,
                'message' => $id ? 'Course updated successfully.' : 'Course created successfully.',
                'course_id' => (string) $course->_id,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Course creation failed.'
            ]);
        }
    }

    public function editCourse($id)
    {
        // Fetch course by ID
        $course = Course::find($id);

        if ($course) {
            return view('course/create_course', ['course' => $course]);
        } else {
            return redirect('/create_course')->with('error', 'Course not found.');
        }
    }

    public function editChapter($courseId, $chapterIndex)
    {
        $course = Course::find($courseId);
        if (!$course) {
            return redirect()->route('courses.create_course')->with('error', 'Course not found.');
        }
        if (!isset($course->chapters[$chapterIndex])) {
            return redirect()->route('courses.create_course', $courseId)->with('error', 'Chapter not found.');
        }
        $chapter = $course->chapters[$chapterIndex];
        return view('course.editCourse_chapter', compact('course', 'chapter', 'chapterIndex'));
    }

    public function updateChapter(Request $request, $courseId, $chapterIndex)
    {
        // echo "<pre>";
        // print_r($request->all());die;
        // Find the course by courseId
        $course = Course::find($courseId);

        // Check if the course exists
        if (!$course) {
            return response()->json(['success' => false, 'message' => 'Course not found'], 404);
        }

        // Ensure chapters are cast to an array
        $chapters = $course->chapters;

        // Check if chapterIndex is valid
        if (!isset($chapters[$chapterIndex])) {
            return response()->json(['success' => false, 'message' => 'Chapter not found'], 404);
        }

        // Update the chapter name
        $chapters[$chapterIndex]['name'] = $request->input('chaptername');

        // Get the subtasks directly from the request
        $subtasks = $request->input('subtasks', []); // Default to an empty array if not present

        // Clear existing topics and quizzes for the chapter
        $chapters[$chapterIndex]['topics'] = [];
        $chapters[$chapterIndex]['quiz'] = [];

        // Iterate through the subtasks to update or add new topics and quizzes
        foreach ($subtasks as $subtaskIndex => $subtask) {
            // Handle topics
            if (isset($subtask['topics'])) {
                foreach ($subtask['topics'] as $topicIndex => $topic) {
                    $existingCourse = Course::find($courseId);
                    $existingTopic = $existingCourse->chapters[$chapterIndex]['topics'][$topicIndex] ?? null;
                    
                    $newTopic = [
                        'name' => $topic['name'],
                        'contentType' => $topic['contentType'],
                        '_id' => $existingTopic['_id']?? new ObjectId(),
                        'duration' => $topic['duration']??null,
                    ];

                    // print_r($request->file("subtasks.{$subtaskIndex}.topics.{$topicIndex}.content"));die;
                    

                    // Handle file uploads for topic content
                    if ($request->file("subtasks.{$subtaskIndex}.topics.{$topicIndex}.content")) {
                        $contentType = $request->input("subtasks.{$subtaskIndex}.topics.{$topicIndex}.contentType");
                        if($contentType === "pdf"){
                            $file=$request->file("subtasks.{$subtaskIndex}.topics.{$topicIndex}.content");
                            $filename = time() . "_" . $file->getClientOriginalName();
                            $video_path = $file->getRealPath();

                            $getID3 = new \getID3;
                            $filetext = $getID3->analyze($video_path);
                            // $duration = date('H:i:s.v', $filetext['playtime_seconds']);
                
                            // Define the folder to store the file in S3
                            $s3BucketFolder = 'images'; // Customize as needed
                            $path = Storage::disk('s3')->putFileAs($s3BucketFolder, $file, $filename);
                
                            // Get the URL for the file stored in S3
                            $fileUrl = Storage::disk('s3')->url($path);
                
                            // Save the file URL and metadata to the database
                            $newTopic['content'] = $fileUrl;
                            $newTopic['duration'] = null;
                        }
                        else if ($contentType === "file") {
                            $newTopic['content'] = $topic['content']; 
                            // $newTopic['duration'] = $topic['duration']??'';
                        }
                    } elseif (!empty($topic['content'])) {
                        // Update non-file content if provided in the request
                        if ($topic['contentType'] === 'youtube') {
                            $youtubeUrl = $topic['content'];
                            $videoId = $this->extractYoutubeVideoId($youtubeUrl);

                            if ($videoId) {
                                $apiKey = env('YOUTUBE_API_KEY'); // Store your API key in the .env file
                                $duration = $this->getYoutubeVideoDuration($videoId, $apiKey);

                                if ($duration) {
                                    $newTopic['duration'] = $duration; // Store formatted duration
                                    // $newTopic['duration'] = null; // Store formatted duration
                                } else {
                                    $newTopic['duration'] = null; // If duration can't be fetched, store null
                                }
                            } else {
                                $newTopic['duration'] = null; // Invalid YouTube URL
                            }
                        }
                        $newTopic['content'] = $topic['content'];
                    } else {
                        // Preserve existing content if no new value is provided and no file is uploaded
                        $existingCourse = Course::find($courseId);
                        $existingTopic = $existingCourse->chapters[$chapterIndex]['topics'][$topicIndex] ?? null;
        
                        if ($existingTopic && isset($existingTopic['content'])) {
                            $newTopic['content'] = $existingTopic['content'];
                            $newTopic['duration'] = $existingTopic['duration'] ?? null;
                        } else {
                            $newTopic['content'] = null;
                        }
                    }
                    $chapters[$chapterIndex]['topics'][] = $newTopic;
                }
            }

            // Handle quizzes if provided
            if (isset($subtask['quiz'])) {
                foreach ($subtask['quiz'] as $quizIndex => $quiz) {
                    $existingCourse = Course::find($courseId);
                    $existingQna = $existingCourse->chapters[$chapterIndex]['quiz'][$quizIndex] ?? null;

                    $chapters[$chapterIndex]['quiz'][] = [
                        'question' => $quiz['question'],
                        'point' => $quiz['point'],
                        'options' => $quiz['options'],
                        'answer' => $quiz['answer'],
                        '_id' => $existingQna['_id']?? new ObjectId(),
                    ];
                }
            }
        }

        $chapters[$chapterIndex]['qualificationMarks'] = $request->input('passmarks');

        // Reassign modified chapters back to the course
        $course->chapters = $chapters;
        $course->save();

        return response()->json(['success' => true, 'message' => 'Chapter updated successfully']);
    }
    public function uploadChunk(Request $request)
    {
        $request->validate([
            'chunk' => 'required|file',
            'chunkNumber' => 'required|integer',
            'totalChunks' => 'required|integer',
            'fileName' => 'required|string',
        ]);
    
        $chunk = $request->file('chunk');
        $chunkNumber = $request->input('chunkNumber');
        $totalChunks = $request->input('totalChunks');
        $fileName = $request->input('fileName');
    
        // Create a temporary directory for chunk storage
        $tempDir = $this->createTempDirectory($fileName);
        $this->saveChunk($chunk, $chunkNumber, $tempDir);
    
        // If all chunks have been uploaded, reassemble the file
        if ($chunkNumber == $totalChunks) {
            return $this->assembleFile($fileName, $totalChunks, $tempDir);
        }
    
        return response()->json(['success' => true, 'message' => 'Chunk uploaded successfully.']);
    }
    
    private function createTempDirectory($fileName)
    {
        // Ensure the filename is sanitized
        $sanitizedFileName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $fileName);
        $tempDir = storage_path('app/course/temp_' . $sanitizedFileName); // Create a unique temp directory for chunks
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true); // Create the directory if it does not exist
        }
        return $tempDir;
    }
    
    private function saveChunk($chunk, $chunkNumber, $tempDir)
    {
        $chunkPath = $tempDir . '/' . $chunkNumber; // Define chunk file path
        // Save the chunk to the defined path
        file_put_contents($chunkPath, file_get_contents($chunk->getRealPath()));
    }
    
    private function assembleFile($fileName, $totalChunks, $tempDir)
    {
        // Path for the final assembled file
        $finalPath = storage_path('app/course/' . $fileName);
    
        // Check if a file or directory exists at the final path
        if (file_exists($finalPath)) {
            return response()->json(['success' => false, 'message' => "A file or directory already exists at: {$finalPath}"]);
        }
    
        // Open the final file for writing
        $finalFile = fopen($finalPath, 'wb'); // Open for writing binary
        if ($finalFile === false) {
            return response()->json(['success' => false, 'message' => "Failed to create final file: {$finalPath}"]);
        }
    
        // Iterate over all chunks and assemble the final file
        for ($i = 1; $i <= $totalChunks; $i++) {
            $chunkPath = $tempDir . '/' . $i; // Path for the chunk file
    
            // Check if the chunk file exists before trying to open it
            if (file_exists($chunkPath)) {
                $chunk = fopen($chunkPath, 'rb'); // Open the chunk file for reading
                stream_copy_to_stream($chunk, $finalFile); // Copy chunk content to final file
                fclose($chunk); // Close the chunk file
            } else {
                fclose($finalFile); // Close the final file if a chunk is missing
                return response()->json(['success' => false, 'message' => "Chunk file does not exist: {$chunkPath}"]);
            }
        }
    
        fclose($finalFile); // Close the final file
    
        // Clean up temporary chunk files
        array_map('unlink', glob($tempDir . '/*')); // Remove all chunk files
        rmdir($tempDir); // Remove the temp directory
    
        // Upload the assembled file to S3
        // return $this->uploadToS3($finalPath, $fileName);
        return $this->uploadToContentFolder($finalPath, $fileName);
    }

    private function uploadToContentFolder($finalPath, $fileName)
    {
        // Define the local content folder path
        $contentFolder = public_path('content');

        // Ensure the content folder exists
        if (!file_exists($contentFolder)) {
            mkdir($contentFolder, 0777, true); // Create directory if it doesn't exist
        }

        // Define the destination path for the video file
        $destinationPath = $contentFolder . '/' . $fileName;

        // Move the final file to the content folder
        if (!rename($finalPath, $destinationPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to move file to content folder.'
            ]);
        }

        // Convert the destination path to a relative path for database storage
        $relativePath = './content/' . $fileName;

        // Use getID3 to analyze the video file and get its duration
        $getID3 = new \getID3;
        $filetext = $getID3->analyze($destinationPath);

        $duration = isset($filetext['playtime_seconds'])
            ? gmdate('H:i:s.v', $filetext['playtime_seconds'])
            : null;

        // Return a success response with the file details
        return response()->json([
            'success' => true,
            'message' => 'File uploaded and saved successfully.',
            'content' => $relativePath, // Use relative path here
            'duration' => $duration
        ]);
    }


    private function uploadToS3($finalPath, $fileName)
    {
        $s3BucketFolder = 'images';
        $path = Storage::disk('s3')->putFileAs($s3BucketFolder, new \Illuminate\Http\File($finalPath), $fileName);
        $fileUrl = Storage::disk('s3')->url($path);
    
        // Use getID3 to get the duration of the video
        $getID3 = new \getID3;
        $filetext = $getID3->analyze($finalPath);
        $duration = date('H:i:s.v', $filetext['playtime_seconds']);
    
        // Clean up the local assembled file
        unlink($finalPath); // Delete the local assembled file
        
        return response()->json(['success' => true, 'message' => 'File uploaded and assembled successfully.', 'content' => $fileUrl, 'duration' => $duration]);
    }

    // Function to extract YouTube Video ID from the URL
    private function extractYoutubeVideoId($url)
    {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $matches);

        return $matches[1] ?? null;
    }

    // Function to get YouTube Video Duration using YouTube Data API
    private function getYoutubeVideoDuration($videoId, $apiKey)
    {
        $client = new Client();
        $response = $client->get('https://www.googleapis.com/youtube/v3/videos', [
            'query' => [
                'id' => $videoId,
                'part' => 'contentDetails',
                'key' => $apiKey,
            ]
        ]);

        $body = json_decode($response->getBody(), true);

        if (isset($body['items'][0]['contentDetails']['duration'])) {
            $isoDuration = $body['items'][0]['contentDetails']['duration'];
            $durationInSeconds = $this->convertISO8601ToSeconds($isoDuration);
            return $this->formatDuration($durationInSeconds);
        }

        return null;
    }

    // Function to convert ISO 8601 Duration to seconds
    private function convertISO8601ToSeconds($isoDuration)
    {
        $interval = new DateInterval($isoDuration);

        return ($interval->h * 3600) + ($interval->i * 60) + $interval->s;
    }

    private function formatDuration($durationInSeconds)
    {
        $hours = floor($durationInSeconds / 3600);
        $minutes = floor(($durationInSeconds % 3600) / 60);
        $seconds = $durationInSeconds % 60;

        // Format milliseconds
        // Here, you need to adjust how you get milliseconds as YouTube API doesn't provide it directly.
        // You can either hardcode to ".000" or implement your way of fetching it if available.
        $milliseconds = '.000'; // YouTube doesn't provide milliseconds, so defaulting to .000

        return sprintf('%02d:%02d:%02d%s', $hours, $minutes, $seconds, $milliseconds);
    }
        
    public function deleteTopic(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());die;
        $courseId = $request->courseId; 
        $chapterIndex = $request->chapterIndex;
        $topicIndex = $request->topicIndex;

        // Find the course
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json(['success' => false, 'message' => 'Course not found'], 404);
        }

        // Get the chapters array
        $chapters = $course->chapters;

        // Check if the chapterIndex and topicIndex are valid
        if (!isset($chapters[$chapterIndex]) || !isset($chapters[$chapterIndex]['topics'][$topicIndex])) {
            return response()->json(['success' => false, 'message' => 'Topic not found'], 404);
        }

        // Remove the topic from the chapters array
        unset($chapters[$chapterIndex]['topics'][$topicIndex]);

        // Re-index the topics array to avoid gaps
        $chapters[$chapterIndex]['topics'] = array_values($chapters[$chapterIndex]['topics']);

        // Update the course with modified chapters
        $course->chapters = $chapters;

        // Save the course
        $course->save();

        return response()->json(['success' => true, 'message' => 'Topic deleted successfully']);
    }
    public function deleteQna(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());die;
        $courseId = $request->courseId; 
        $chapterIndex = $request->chapterIndex;
        $quizIndex = $request->quizIndex;

        // Find the course
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json(['success' => false, 'message' => 'Course not found'], 404);
        }

        // Get the chapters array
        $chapters = $course->chapters;

        // Check if the chapterIndex and topicIndex are valid
        if (!isset($chapters[$chapterIndex]) || !isset($chapters[$chapterIndex]['quiz'][$quizIndex])) {
            return response()->json(['success' => false, 'message' => 'QnA not found'], 404);
        }

        // Remove the topic from the chapters array
        unset($chapters[$chapterIndex]['quiz'][$quizIndex]);

        // Re-index the topics array to avoid gaps
        $chapters[$chapterIndex]['quiz'] = array_values($chapters[$chapterIndex]['quiz']);

        // Update the course with modified chapters
        $course->chapters = $chapters;

        // Save the course
        $course->save();

        return response()->json(['success' => true, 'message' => 'Quiz deleted successfully']);
    }

    public function deleteQnaOption(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());die;
        $courseId = $request->courseId; 
        $chapterIndex = $request->chapterIndex;
        $quizIndex = $request->quizIndex;
        $optionsIndex = $request->optionsIndex;

        // Find the course
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json(['success' => false, 'message' => 'Course not found'], 404);
        }

        // Get the chapters array
        $chapters = $course->chapters;

        // Check if the chapterIndex and topicIndex are valid
        if (!isset($chapters[$chapterIndex]) || !isset($chapters[$chapterIndex]['quiz'][$quizIndex])) {
            return response()->json(['success' => false, 'message' => 'QnA not found'], 404);
        }

        // Remove the topic from the chapters array
        unset($chapters[$chapterIndex]['quiz'][$quizIndex]['options'][$optionsIndex]);

        // Re-index the topics array to avoid gaps
        $chapters[$chapterIndex]['quiz'][$quizIndex]['options'] = array_values($chapters[$chapterIndex]['quiz'][$quizIndex]['options']);

        // Update the course with modified chapters
        $course->chapters = $chapters;

        // Save the course
        $course->save();

        return response()->json(['success' => true, 'message' => 'Option deleted successfully']);
    }

    public function courseListing()
    {
        $course=Course::where('isDeleted', false)->OrderBy('created_at', 'desc')->paginate(5);
        return view('course.courseListing',compact('course'));
    }

    public function paginateCourse(Request $request)
    {
        $course=Course::where('isDeleted', false)->OrderBy('created_at', 'desc')->paginate(5);

        return view('course.courseListing_pagination', compact('course'))->render();
    }

    public function searchCourse(Request $request)
    {
        $keyword = $request->input('keyword');
        $course = Course::where('courseName', 'LIKE', "%{$keyword}%")->where('isDeleted', false)
                        ->OrderBy('created_at', 'desc')
                        ->paginate(5);

        return view('course.courseListing_search', compact('course'))->render();
    }

    public function deleteCourse(Request $request)
    {
        $course = Course::find($request->id);
        
        if ($course) {
            // $course->delete();
            $course->isDeleted = true;
            $course->save();
            return response()->json(['success' => 'Course deleted successfully.']);
        } else {
            return response()->json(['error' => 'Course not found.'], 404);
        }
    }
    
    public function editPageCourse($id)
    {

        $course = Course::find($id);

        if ($course) {
            return view('course.editCourse', ['course' => $course]);
        }
    }
    
    public function deleteVideo(Request $request)
    {
        $courseId = $request->input('courseId');
        $chapterIndex = $request->input('chapterIndex');
        $topicIndex = $request->input('topicIndex');

        // Find the course by its ID
        $course = Course::find($courseId);

        if ($course && isset($course->chapters[$chapterIndex])) {
            // Get the chapters array
            $chapters = $course->chapters;

            if (isset($chapters[$chapterIndex]['topics'][$topicIndex])) {

                $chapters[$chapterIndex]['topics'][$topicIndex]['content'] = null;

                $course->chapters = $chapters;
                $course->save();

                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Video not found']);
    }

    public function deletePdf(Request $request)
    {
        $courseId = $request->input('courseId');
        $chapterIndex = $request->input('chapterIndex');
        $topicIndex = $request->input('topicIndex');

        // Find the course by its ID
        $course = Course::find($courseId);

        if ($course && isset($course->chapters[$chapterIndex])) {
            // Get the chapters array
            $chapters = $course->chapters;

            if (isset($chapters[$chapterIndex]['topics'][$topicIndex])) {

                $chapters[$chapterIndex]['topics'][$topicIndex]['content'] = null;

                $course->chapters = $chapters;
                $course->save();

                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Pdf not found']);
    }

    public function deleteThumbnail(Request $request)
    {
        $course = Course::find($request->courseId);
        if ($course && $course->thumbnail) {
            $course->thumbnail = null;
            $course->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    public function courseStreaming(Request $request)
    {
        $userId = Session::get('user_id');
        if (Session::has('user_id')) {
            $course = Course::orderBy('created_at', 'desc')->paginate(5);
            return view("course.retrieveCourse", compact("course"));
        } else {
            return redirect('login');
        }
        
    }
    public function paginateCourseStreaming(Request $request)
    {
        $userId = Session::get('user_id');
        if (Session::has('user_id')) {
            $course=Course::where('isDeleted', false)->OrderBy('created_at', 'desc')->paginate(5);

            return view('course.retrieveCourse_pagination', compact('course'))->render();
        } else {
            return redirect('login');
        }
    }

    public function searchCourseStreaming(Request $request)
    {
        $userId = Session::get('user_id');
        if (Session::has('user_id')) {
            $keyword = $request->input('keyword');
            $course = Course::where('courseName', 'LIKE', "%{$keyword}%")->where('isDeleted', false)
                            ->OrderBy('created_at', 'desc')
                            ->paginate(5);

            return view('course.retrieveCourse_search', compact('course'))->render();
        } else {
            return redirect('login');
        }
    }

    public function courseStreamingChapters($id)
    {
        $userId = Session::get('user_id');

        if (Session::has('user_id')) {

            $course = Course::find($id);
            if ($course) {
                return view('course.retrieveCourseChapters', ['course' => $course]);
            }
        } else {
            return redirect('login');
        }
        
    }

    public function ratingGiven()
    {
        $courseRating=CourseRating::OrderBy('created_at', 'desc')->paginate(5);
        return view('course.ratingGiven',compact('courseRating'));
    }

    public function paginateRatingGiven(Request $request)
    {
        $courseRating=CourseRating::OrderBy('created_at', 'desc')->paginate(5);
        return view('course.ratingGiven_pagination', compact('courseRating'))->render();
    }

    public function searchRatingGiven(Request $request)
    {
        $keyword = $request->input('keyword');
        $courseRating = CourseRating::where('courseName', 'LIKE', "%{$keyword}%")
                        ->orWhere('username', 'LIKE', "%{$keyword}%")
                        ->orWhere('ratings', 'LIKE', "%{$keyword}%")
                        ->OrderBy('created_at', 'desc')
                        ->paginate(5);

        return view('course.ratingGiven_search', compact('courseRating'))->render();
    }

    public function filterRatingGiven(Request $request)
    {
        $keyword = $request->input('ratingStatus');
        $courseRating = CourseRating::where('ratings', 'LIKE', "%{$keyword}%")
                        ->OrderBy('created_at', 'desc')
                        ->paginate(5);

        return view('course.ratingGiven_search', compact('courseRating'))->render();
    }

    public function ratingCoursePage($id)
    {
        $userId = Session::get('user_id');
        $user= User::where('_id', $userId)->value('name');
        $course = Course::find($id);
        if ($course) {
            return view('course.ratingCoursePage', ['course' => $course, 'user' => $user, 'userId' => $userId]);
        }
    }

    public function ratingSubmit(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());die;
        $rating = new CourseRating;
        $rating->courseId = $request->courseId;
        $rating->courseName = $request->courseName;
        $rating->userId = $request->userId;
        $rating->username = $request->username;
        $rating->ratings = $request->ratings; 
        $rating->comment = $request->comment;
        $rating->save();

        if ($rating->save()) {

            $courseId = $request->courseId;

            $allRatings = CourseRating::where('courseId', $courseId)->pluck('ratings');
            $averageRating = $allRatings->avg();
            $course = Course::where('_id', $courseId)->first();
            if ($course) {
                $course->rating = $averageRating;
                $course->save();
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Thank You for your feedback',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Rating is not submitted!'
            ]);
        }

        
    }

    public function allCommentsView($id)
    {
        $userId = Session::get('user_id');
        $course = Course::find($id);
        $ratings= CourseRating::where('courseId', $id)->orderBy('created_at','desc')->get();

        if ($course) {
            return view('course.allCommentsView', ['course' => $course, 'ratings' => $ratings]);
        }
    }

    //user end
    // public function courses()
    // {
    //     $userId = Session::get('user_id');
    //     if($userId){
    //         $courses = Course::where('isDeleted',false)->orderBy('created_at', 'desc')->get();

    //     foreach ($courses as $course) {

    //         $expectedDurationInSeconds = 0;

    //         // Iterate through each chapter
    //         foreach ($course['chapters'] as $chapter) {

    //             foreach ($chapter['topics'] as $topic) {
    //                 // If duration is not null, convert it to seconds
    //                 if (isset($topic['duration'])) {
    //                     $expectedDurationInSeconds += $this->convertDurationToSeconds($topic['duration']);
    //                 }
    //             }
    //         }

    //         $totalProgress = CourseVideoProgress::where('user_id', $userId)
    //             ->where('course_id', $course->_id) 
    //             ->pluck('progress'); 

    //         $totalSeconds = 0;
    //         $notRoundTotalSeconds = 0;

    //         foreach ($totalProgress as $time) {

    //             $notRoundTotalSeconds += $time;
    //         }
    //         $totalSeconds= round($notRoundTotalSeconds);

    //         $progressPercentage = $expectedDurationInSeconds > 0 ? ($totalSeconds / $expectedDurationInSeconds) * 100 : 0;

    //         $course->expectedDurationInSeconds = $expectedDurationInSeconds;
    //         $course->totalProgress = round($totalSeconds);
    //         $course->progressPercentage  = number_format($progressPercentage);
    //         $course->isCompleted = CourseCompletedUser::where('user_id', $userId)->where('course_id', $course->_id)->exists();

    //         if ($progressPercentage >= 100 ) {
    //             // Check if an entry already exists in `completed_courses`
    //             $isAlreadyCompleted = CourseCompletedUser::where('user_id', $userId)
    //                 ->where('course_id', $course->_id)
    //                 ->exists();

    //             // If not completed before, insert a new entry
    //             if (!$isAlreadyCompleted) {

    //                 $CourseCompletedUser = new CourseCompletedUser();

    //                 $CourseCompletedUser->user_id = $userId;
    //                 $CourseCompletedUser->course_id = $course->_id;

    //                 $CourseCompletedUser->save();
    //             }
    //         }
    //     }

    //         return view("course.courseView", compact("courses"));
    //     }else {
    //         return redirect('/login')->with('error', 'You must be logged in');
    //     }
    // }

    public function courses()
    {
        $userId = Session::get('user_id');
        if($userId) {
            $courses = Course::where('isDeleted', false)->orderBy('created_at', 'desc')->get();

            foreach ($courses as $course) {
                $expectedDurationInSeconds = 0;

                // Calculate the expected duration
                foreach ($course['chapters'] as $chapter) {
                    foreach ($chapter['topics'] as $topic) {
                        if (isset($topic['duration'])) {
                            $expectedDurationInSeconds += $this->convertDurationToSeconds($topic['duration']);
                        }
                    }
                }

                $totalProgress = CourseVideoProgress::where('user_id', $userId)
                    ->where('course_id', $course->_id)
                    ->pluck('progress');

                $totalSeconds = 0;

                foreach ($totalProgress as $time) {
                    $totalSeconds += $time;
                }

                $progressPercentage = $expectedDurationInSeconds > 0 
                    ? ($totalSeconds / $expectedDurationInSeconds) * 100 
                    : 0;

                // Fetch the previous max progress from the database
                $courseCompleted = CourseCompletedUser::where('user_id', $userId)
                    ->where('course_id', $course->_id)
                    ->first();

                $maxProgressPercentage = $courseCompleted ? $courseCompleted->max_progress_percentage : 0;

                // Compare the current progress with the max saved progress
                $finalProgressPercentage = max($progressPercentage, $maxProgressPercentage);

                // Update the max progress if the current progress is higher
                if ($progressPercentage > $maxProgressPercentage) {
                    if ($courseCompleted) {
                        $courseCompleted->max_progress_percentage = $progressPercentage;
                        $courseCompleted->save();
                    } else {
                        // CourseCompletedUser::create([
                        //     'user_id' => $userId,
                        //     'course_id' => $course->_id,
                        //     'max_progress_percentage' => $progressPercentage,
                        // ]);
                        $CourseCompletedUser = new CourseCompletedUser();

                        $CourseCompletedUser->user_id = $userId;
                        $CourseCompletedUser->course_id = $course->_id;
                        $CourseCompletedUser->max_progress_percentage = $progressPercentage;
                        $CourseCompletedUser->save();
                    }
                }

                // Set progress data for each course
                $course->expectedDurationInSeconds = $expectedDurationInSeconds;
                $course->totalProgress = round($totalSeconds);
                $course->progressPercentage = number_format($finalProgressPercentage);
                $course->isCompleted = $finalProgressPercentage >= 100;
            }

            return view("course.courseView", compact("courses"));
        } else {
            return redirect('/login')->with('error', 'You must be logged in');
        }
    }

    private function convertDurationToSeconds($duration)
    {
        // Example format: "00:11:59.000"
        list($hours, $minutes, $seconds) = sscanf($duration, '%d:%d:%f');
        return ($hours * 3600) + ($minutes * 60) + $seconds;
    }

    public function courseDetails($id)
    {
        $userId = Session::get('user_id');
        if($userId){
            $course = Course::where('_id', $id)->first();

            $totalTopics = 0;
            $totalDurationInSeconds = 0;

            foreach ($course['chapters'] as $chapter) {
                $totalTopics += count($chapter['topics']);

                foreach ($chapter['topics'] as $topic) {
                    if (isset($topic['duration'])) {
                        $totalDurationInSeconds += $this->durationToSeconds($topic['duration']);
                    }
                }
            }
            $totalHours = floor($totalDurationInSeconds / 3600);
            $totalMinutes = floor(($totalDurationInSeconds % 3600) / 60);
            $totalSeconds = $totalDurationInSeconds % 60;
            // $total
            $totalRuntime = '';

            if ($totalHours > 0) {
                $totalRuntime .= $totalHours . ' ' . ($totalHours == 1 ? 'hour' : 'hours');
            }

            if ($totalMinutes > 0) {
                if (!empty($totalRuntime)) {
                    $totalRuntime .= ' and ';
                }
                $totalRuntime .= $totalMinutes . ' ' . ($totalMinutes == 1 ? 'minute' : 'minutes');
            }

            if ($totalSeconds > 0) {
                if (!empty($totalRuntime)) {
                    $totalRuntime .= ' and ';
                }
                $totalRuntime .= $totalSeconds . ' ' . ($totalSeconds == 1 ? 'second' : 'seconds');
            }

            if (empty($totalRuntime)) {
                $totalRuntime = '-';
            }

            $progressExists = [];
            foreach ($course['chapters'] as $chapter) {
                $chapterId = isset($chapter['_id']) ? (string) $chapter['_id'] : null;;
                if ($chapterId) {
                    $exists = CourseVideoProgress::where('user_id', $userId)
                        ->where('chapter_id', $chapterId)
                        ->exists();

                    $progressExists[$chapterId] = $exists;
                }
            }


            return view("course.courseViewDetails", compact("course", "totalTopics", "totalRuntime", "id", "progressExists"));
        }else {
            return redirect('/login')->with('error', 'You must be logged in');
        }
    }

    public function submitAnswer(Request $request)
    {
        $userId = (string) Session::get('user_id');
        $quizId = $request->input('quiz_id');
        $chapterId = $request->input('chapter_id');
        $userAnswer = $request->input('answer');

        // Fetch the quiz from the courses table (assuming a JSON structure for quizzes)
        $course = Course::where('chapters.quiz._id', $quizId)->first();

        if (!$course) {
            return response()->json(['success' => false, 'message' => 'Quiz not found.']);
        }

        // Extract the specific quiz details
        $quiz = collect($course->chapters)
            ->pluck('quiz')
            ->flatten(1)
            ->firstWhere('_id', $quizId);

        if (!$quiz) {
            return response()->json(['success' => false, 'message' => 'Quiz details not found.']);
        }

        // Check if the user's answer matches the correct answer
        $correctAnswer = $quiz['answer'][0]; // Assuming only one correct answer
        $isCorrect = $userAnswer === $correctAnswer;

        // Calculate points
        $pointsEarned = $isCorrect ? (int)$quiz['point'] : 0;

        // Save the quiz result
        $quizResult = new QuizResult();
        $quizResult->user_id = $userId;
        $quizResult->quiz_id = $quizId;
        $quizResult->chapter_id = $chapterId;
        $quizResult->answer = $userAnswer;
        $quizResult->is_correct = $isCorrect;
        $quizResult->points_earned = $pointsEarned;
        $quizResult->save();

        // Return a response to the frontend
        return response()->json([
            'success' => true,
            'is_correct' => $isCorrect,
            'points_earned' => $pointsEarned,
            'message' => $isCorrect ? 'Correct answer!' : 'Wrong answer!',
        ]);
    }

    public function generateReportCard($courseId)
    {
        $userId = (string) session()->get('user_id');

        $course = Course::find($courseId);
        
        if (!$course) {
            return response()->json(['success' => false, 'message' => 'Course not found.']);
        }

        $reportData = [];
        $totalPointsEarned  = 0;
        $totalPointsAvailable = 0;

        foreach ($course->chapters as $chapter) {
            $chapterTotalPointsEarned = 0;
            $chapterTotalPointsAvailable = 0;
            $qualificationMarks = isset($chapter['qualificationMarks']) ? (int) $chapter['qualificationMarks'] : 0;
            
            $chapterData = [
                'chapter_name' => $chapter['name'],
                'qualification_marks' => $qualificationMarks,
                'quizzes' => [],
                'status' => 'null', 
            ];

            $allUnattempted = true;

            foreach ($chapter['quiz'] as $quiz) {

                $quizPoint = isset($quiz['point']) ? (int) $quiz['point'] : 0;
                $totalPointsAvailable += $quizPoint; // Add quiz points to the course total
                $chapterTotalPointsAvailable += $quizPoint;

                $quizResult = QuizResult::where('user_id', $userId)
                    ->where('quiz_id', (string) $quiz['_id'])
                    ->first();

                if (!$quizResult) {
                    $chapterData['quizzes'][] = [
                        'question' => $quiz['question'],
                        'user_answer' => 'Not Attempted',
                        'correct_answer' => null, 
                        'points_earned' => null,
                        'status' => 'Not Attempted',
                    ];
                    continue;
                }
                    
                $allUnattempted = false; 
                $pointsEarned = $quizResult->points_earned;
                $isCorrect = $quizResult->is_correct;

                $chapterTotalPointsEarned += $pointsEarned;
                $totalPointsEarned += $pointsEarned;

                $chapterData['quizzes'][] = [
                    'question' => $quiz['question'],
                    'user_answer' => $quizResult->answer,
                    'correct_answer' => $quiz['answer'][0],
                    'points_earned' => $pointsEarned,
                    'status' => $isCorrect ? 'Correct' : 'Incorrect',
                ];
            }

            if ($allUnattempted) {
                $chapterData['status'] = 'Not Attempted';
            } else {
                $chapterData['status'] = $chapterTotalPointsEarned >= $qualificationMarks ? 'Pass' : 'Fail';
            }

            $reportData[] = $chapterData;
        }

        return view('course.reports', [
            'courseId' => $courseId,
            'courseName' => $course->courseName,
            'totalPointsEarned' => $totalPointsEarned,
            'totalPointsAvailable' => $totalPointsAvailable,
            'reportData' => $reportData,
        ]);
    }

    public function downloadReportCard($courseId)
    {
        $userId = (string) session()->get('user_id');

        $course = Course::find($courseId);
        
        if (!$course) {
            return response()->json(['success' => false, 'message' => 'Course not found.']);
        }

        $reportData = [];
        $totalPointsEarned  = 0;
        $totalPointsAvailable = 0;

        foreach ($course->chapters as $chapter) {
            $chapterTotalPointsEarned = 0;
            $chapterTotalPointsAvailable = 0;
            $qualificationMarks = isset($chapter['qualificationMarks']) ? (int) $chapter['qualificationMarks'] : 0;
            
            $chapterData = [
                'chapter_name' => $chapter['name'],
                'qualification_marks' => $qualificationMarks,
                'quizzes' => [],
                'status' => 'null', 
            ];

            $allUnattempted = true;

            foreach ($chapter['quiz'] as $quiz) {

                $quizPoint = isset($quiz['point']) ? (int) $quiz['point'] : 0;
                $totalPointsAvailable += $quizPoint; // Add quiz points to the course total
                $chapterTotalPointsAvailable += $quizPoint;

                $quizResult = QuizResult::where('user_id', $userId)
                    ->where('quiz_id', (string) $quiz['_id'])
                    ->first();

                if (!$quizResult) {
                    $chapterData['quizzes'][] = [
                        'question' => $quiz['question'],
                        'user_answer' => 'Not Attempted',
                        'correct_answer' => null, 
                        'points_earned' => null,
                        'status' => 'Not Attempted',
                    ];
                    continue;
                }
                    
                $allUnattempted = false; 
                $pointsEarned = $quizResult->points_earned;
                $isCorrect = $quizResult->is_correct;

                $chapterTotalPointsEarned += $pointsEarned;
                $totalPointsEarned += $pointsEarned;

                $chapterData['quizzes'][] = [
                    'question' => $quiz['question'],
                    'user_answer' => $quizResult->answer,
                    'correct_answer' => $quiz['answer'][0],
                    'points_earned' => $pointsEarned,
                    'status' => $isCorrect ? 'Correct' : 'Incorrect',
                ];
            }

            if ($allUnattempted) {
                $chapterData['status'] = 'Not Attempted';
            } else {
                $chapterData['status'] = $chapterTotalPointsEarned >= $qualificationMarks ? 'Pass' : 'Fail';
            }

            $reportData[] = $chapterData;
        }

        // Load the view and generate the PDF
        $pdf = PDF::loadView('course.report_pdf', [
            'courseName' => $course->courseName,
            'totalPointsEarned' => $totalPointsEarned,
            'totalPointsAvailable' => $totalPointsAvailable,
            'reportData' => $reportData,
        ]);

        return $pdf->setPaper('A4')->download('report-card.pdf');
    }

    private function durationToSeconds($duration)
    {
        list($hours, $minutes, $seconds) = explode(':', $duration);
        return ($hours * 3600) + ($minutes * 60) + (float)$seconds;
    }

    public function courseContent($id, $chapter_id, $topic_id)
    {
        $userId = Session::get('user_id');
        if ($userId) {
            $topicObjectId = new ObjectId($topic_id);

            $course = Course::raw(function ($collection) use ($topicObjectId) {

                return $collection->aggregate([
                    ['$unwind' => '$chapters'],
                    ['$unwind' => '$chapters.topics'],
                    ['$match' => ['chapters.topics._id' => $topicObjectId]],
                    ['$project' => [
                        'chapters.topics' => 1
                    ]]
                ]);
            });

            $course = json_decode($course, true);

            $allChapters = Course::find($id, ['chapters']);
            $nextTopic = null;
            $nextChapterId = null;
            $previousTopic = null;
            $previousChapterId = null;

            foreach ($allChapters['chapters'] as $chapter) {
                if ((string)$chapter['_id'] === $chapter_id) {
                    foreach ($chapter['topics'] as $index => $topic) {
                        if ((string)$topic['_id'] === $topic_id) {
                            // Check for next topic
                            if (isset($chapter['topics'][$index + 1])) {
                                $nextTopic = $chapter['topics'][$index + 1];
                                $nextChapterId = $chapter['_id'];
                            }
                            // Check for previous topic
                            if (isset($chapter['topics'][$index - 1])) {
                                $previousTopic = $chapter['topics'][$index - 1];
                                $previousChapterId = $chapter['_id'];
                            }
                            break;
                        }
                    }
                    break;
                }
            }

            $progress = CourseVideoProgress::where('user_id', $userId)
                        ->where('course_id', $id)
                        ->where('chapter_id', $chapter_id)
                        ->where('topic_id', $topic_id)
                        ->first(['progress']);

            $lastPlayedTime = $progress ? $progress['progress'] : 0;

            Course::where('_id', $id)->update([
                '$addToSet' => ['subscribedUsers' => (string) $userId] // Only adds userId if it doesn’t already exist in the array
            ]);

            return view("course.courseViewDetailsContent", compact('course','lastPlayedTime','id','chapter_id','topic_id', 'nextTopic', 'nextChapterId','previousTopic', 'previousChapterId'));
        } else {
            return redirect('/login')->with('error', 'You must be logged in');
        }
    }

    public function saveVideoProgress(Request $request)
    {
        $userId = Session::get('user_id');

        if (Session::has('user_id')) {
            // Attempt to find an existing record
            $courseVideoProgress = CourseVideoProgress::where([
                'user_id' => $userId,
                'course_id' => $request->input('course_id'),
                'chapter_id' => $request->input('chapter_id'),
                'topic_id' => $request->input('topic_id'),
            ])->first();

            // If no record exists, create a new instance
            if (!$courseVideoProgress) {
                $courseVideoProgress = new CourseVideoProgress();
                $courseVideoProgress->user_id = $userId;
                $courseVideoProgress->course_id = $request->input('course_id');
                $courseVideoProgress->chapter_id = $request->input('chapter_id');
                $courseVideoProgress->topic_id = $request->input('topic_id');
            }

            $seconds = $request->input('progress');
            // $formattedTime = gmdate('H:i:s', intval($seconds)) . '.' . sprintf('%03d', ($seconds - intval($seconds)) * 1000);

            // Set and save the progress
            $courseVideoProgress->progress = $seconds;

            // Save the record
            $courseVideoProgress->save();

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 403);
    }

    public function generateCertificate($course_id)
    {
        $userId = Session::get('user_id');

        // Fetch user and course details
        $user = User::find($userId);
        $course = Course::find($course_id);

        if (!$user || !$course) {
            return redirect()->back()->with('error', 'User or course not found.');
        }

        // Generate PDF certificate with user and course data
        $pdf = Pdf::loadView('course.certificatePdf', [
            'userName' => $user->name,
            'courseName' => $course->courseName,
            'logoPath' => '/var/www/html/public/images/ad_1.png'
        ]);

        return $pdf->download('certificate.pdf');
    }

}
