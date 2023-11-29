<?php

namespace App\Http\Controllers;

use App\Models\courses;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    function createCourses(Request $request){
        $request->validate([
            'name' => 'required',
            'amount' => 'required'
        ]);
         
        $courses = courses::create([
            'name' => $request->name,
            'amount' => $request->amount
        ]);

        $coursesCheck = Courses::find($courses->id);

        if($coursesCheck){
            return response()->json($coursesCheck);
        }
    }

    function readAllCourses(){
        $courses = Courses::all();

        if($courses){
            return response()->json($courses);
        }
        else{
            return response('No Course Was Found');
        }
    }

    function readCourses($id){
        try{
            $courses = Courses::findorfail($id);
            return response()->json($courses);
        }
        catch(\Exception $e){
            return response()->json([
                'error'=>'Course not found'
            ], 404);
        }
    }

    function updateCourses(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'amount'=>'required'
        ]);

    
        $courses = Courses::find($id);

        if($courses){
            $courses->name = $request->name;

            $courses->save();
            return response()->json($courses);
        }
        else{
            return response("Update unsuccessful, no such course exists");
        }
    }

    function deleteCourses($id){
        try{
            $courses = Courses::findorfail($id);
            if($courses){
                $deletedCourses = $courses;
    
                $courses->delete();
                return response()->json($deletedCourses);
            }
            else{
                return response("Delete unsuccessful, no such course exits");
            }
        }
        catch(\Exception $e){
            return response()->json([
                'error'=> 'Course not found!'
            ], 404);
        }
    }

    
    function searchCourses($name){
        try{
            $courses = Courses::where('name', 'like', '%'.$name.'%')->get();
            if($courses){
    
                return response()->json($courses);
            }
            else{
                return response("No such matches");
            }
        }
        catch(\Exception $e){
            return response()->json([
                'error'=> 'Match not found!'
            ], 404);
        }
    }
}

    
