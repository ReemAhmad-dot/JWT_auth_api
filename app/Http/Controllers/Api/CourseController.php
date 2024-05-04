<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;

class CourseController extends Controller
{
    // COURSE ENROLLMENT API - POST
    public function courseEnroll(Request $request)
    {

        // validation
        $request->validate([
            "title" => "required",
            "total_videos" => "required"
        ]);

        // create course object
        $userId = auth()->user()->id;
        Course::create([
            "user_id"=> $userId,
            "title"=> $request->title,
            "description"=> $request->description,
            "total_videos"=> $request->total_videos,

        ]);

        // send response
        return response()->json([
            "status" => true,
            "message" => "Course enrollment saved for user successfully"
        ]);
    }

    // TOTAL COURSE ENROLLMENT API - GET
    public function totalCourses()
    {
        $courses = auth()->user()->courses;
        if(!empty($courses)) {
            return response()->json([
                "status" => true,
                "message" => "Total Courses enrolled",
                "data" => $courses
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => "No Courses found",
        ]);
    }

    // DELETE COURSE API - GET
    public function deleteCourse($course_id)
    {
        $user_id = auth()->user()->id;

        if (Course::where([
            "id" => $course_id,
            "user_id" => $user_id
        ])->exists()) {

            $course = Course::find($course_id);
            $course->delete();
            return response()->json([
                "status" => true,
                "message" => "Course deleted successfully"
            ]);
        } else {

            return response()->json([
                "status" => false,
                "message" => "Course not found"
            ]);
        }
    }
}
