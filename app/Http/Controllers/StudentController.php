<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        return Student::all();
    }
    public function store(Request $r)
    {
        $data = $r->validate([
            'student_id' => 'required|string|unique:students,student_id',
            'name' => 'required',
            'course' => 'required',
            'year_level' => 'required|integer|min:1|max:6',
            'campus' => 'required'
        ]);
        return Student::create($data);
    }
    public function show(Student $student)
    {
        return $student;
    }
    public function update(Request $r, Student $student)
    {
        $data = $r->validate([
            'student_id' => 'sometimes|string|unique:students,student_id,' . $student->id,
            'name' => 'sometimes',
            'course' => 'sometimes',
            'year_level' => 'sometimes|integer|min:1|max:6',
            'campus' => 'sometimes'
        ]);
        $student->update($data);
        return $student;
    }
    public function destroy(Student $student)
    {
        $student->delete();
        return response()->noContent();
    }
}
