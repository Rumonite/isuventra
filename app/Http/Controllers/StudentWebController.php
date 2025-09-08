<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentWebController extends Controller
{
    public function index()
    {
        $studentsList = Student::all();
        return view('dashboard', compact('studentsList'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string|max:50|unique:students,student_id',
            'name'       => 'required|string|max:255',
            'course'     => 'required|string|max:100',
            'year_level' => 'required|integer|min:1|max:5',
            'campus'     => 'required|string|max:100',
        ]);

        Student::create($request->only([
            'student_id',
            'name',
            'course',
            'year_level',
            'campus'
        ]));

        return redirect()->back()->with('success', 'Student added successfully!');
    }


    public function destroy(Student $student)
    {
        $student->delete();

        return back()->with('success', 'Student deleted successfully!');
    }
}
