<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    public function show(Course $course): View
    {
        return view('courses.show', compact('course'));
    }
}
