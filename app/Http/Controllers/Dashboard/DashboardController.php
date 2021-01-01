<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Rank;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpParser\ErrorHandler\Collecting;

class DashboardController extends Controller
{
    public $dashboard;
    public function _dashboard(){
        $rank = strtolower(Rank::where('id',Auth::user()->rank_id)->first()->name);
        $dashboard = new Collecting();
        $dashboard->total_users = User::select('id')->get()->count();
        $dashboard->total_students = User::select('id')->where('rank_id',Rank::where('name','Student')->first()->id)->get()->count();
        $dashboard->total_teachers = User::select('id')->where('rank_id',Rank::where('name','Teacher')->first()->id)->get()->count();

        if ($rank == "admin"){
            $dashboard->sidebar['teachers'] = true;
            $dashboard->sidebar['mail'] = true;
            $dashboard->sidebar['assignments'] = true;
            $dashboard->sidebar['students'] = true;
            $dashboard->sidebar['courses'] = true;
            $dashboard->sidebar['system'] = true;
            $dashboard->sidebar['logs'] = true;
        }else if ($rank == "teacher"){
            $dashboard->sidebar['mail'] = true;
            $dashboard->sidebar['assignments'] = true;
            $dashboard->sidebar['students'] = true;
            $dashboard->sidebar['courses'] = true;
        }else if ($rank == "student"){
            $dashboard->sidebar['mail'] = true;
            $dashboard->sidebar['assignments'] = true;
            $dashboard->sidebar['courses'] = true;
            $dashboard->sidebar['teachers'] = true;
        }else{
            Auth::guard()->logout();
            return redirect(route('home'));
        }
        return $dashboard;
    }
    public function dashobard(){
        $dashboard = $this->_dashboard();
        return view('dashboard.index')->with([
            'dashboard' => $dashboard,
        ]);
    }
    public function courses(){
        $dashboard = $this->_dashboard();
        $courses = Course::all();
        return view('dashboard.courses.list')->with([
            'dashboard' => $dashboard,
            'courses' => $courses,
        ]);
    }
    public function add_course(Request $request){
        $validate = $this->add_course_validator($request->toArray());
        if ($validate->fails()){
            return response()->json(['error'=>$validate->errors()]);
        }
        $course = new Course();
        $course->name = $request->course_name;
        $course->duration = $request->course_duration;
        $course->start_date = $request->course_start_date;
        $course->end_date = $request->course_end_date;
        $course->status = $request->course_status;
        $course->save();
        if ($course)
            return response()->json(['success'=>'Course will added successfully']);
        else
            return response()->json(['error'=>'Cant added the course']);
    }
    public function edit_course(Request $request,$id){
        $validate = $this->edit_course_validator($request->toArray());
        if ($validate->fails()){
            return response()->json(['error'=>$validate->errors()]);
        }
        $course = Course::findOrfail($id);
        $course->name = $request->course_name;
        $course->duration = $request->course_duration;
        $course->start_date = $request->course_start_date;
        $course->end_date = $request->course_end_date;
        $course->status = $request->course_status;
        $course->save();
        if ($course)
            return response()->json(['success'=>'Course will edited successfully']);
        else
            return response()->json(['error'=>'Cant edited the course']);
    }
    public function delete_course($id){
        $course = Course::findOrfail($id);
        $course->delete();
        return response()->json(['success'=>'Course will deleted successfully']);
    }

    protected function add_course_validator(array $data)
    {
        return Validator::make($data, [
            'course_name' => ['required', 'string', 'max:255'],
            'course_duration' => ['required', 'string', 'max:255'],
            'course_start_date' => ['required', 'date', 'after:tomorrow'],
            'course_end_date' => ['required', 'date', 'after:course_start_date'],
            'course_status' => ['required', 'boolean'],
        ]);
    }
    protected function edit_course_validator(array $data)
    {
        return Validator::make($data, [
            'course_name' => ['required', 'string', 'max:255'],
            'course_duration' => ['required', 'string', 'max:255'],
            'course_start_date' => ['required', 'date'],
            'course_end_date' => ['required', 'date', 'after:course_start_date'],
            'course_status' => ['required', 'boolean'],
        ]);
    }
}
