<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseAssignment;
use App\Models\CourseStudent;
use App\Models\Rank;
use App\User;
use App\WebsiteInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function getHome(){
        $website_info = WebsiteInfo::orderBy('id','desc')->get()->first();
        if (!$website_info->status){
            $title = 'Maintenance';
            $message = 'We are working on maintaining the site';
            return view('error.404')->with([
                'title'    =>  $title,
                'message'  => $message
            ]);
        }


        $courses = Course::with('students')->get()->sortBy(function($hackathon)
        {
            return $hackathon->students->count();
        })->reverse()->take(3);


       /* $ranks = DB::table('ranks')
            ->groupBy('name')
            ->orderBy(DB::raw('count(name)'), 'DESC')
            ->take(3)
            ->get('id');
        dd($ranks);
        foreach ($ranks as $rank){
            dd($rank);
        }
        dd($ranks);*/


        $website_info->total_courses = Course::all()->count();
        $website_info->total_students = User::where('rank_id',Rank::where('name','student')->select('id')->first()->id)->get()->count();
        $website_info->total_teachers = User::where('rank_id',Rank::where('name','teacher')->select('id')->first()->id)->get()->count();
        $website_info->total_assignments = CourseAssignment::all()->count();

       /* $mosts_courses = CourseStudent::where('status',1)->select('course_id')
        $courses = Course::where('id',CourseStudent::where('status',1)->select('course_id')->get()->take(3))*/

        return view('home')->with([
            'website_info' => $website_info,
            'courses'  =>  $courses
        ]);
    }
}
