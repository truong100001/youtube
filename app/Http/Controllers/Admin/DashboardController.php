<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $num_channel = DB::table('channel')->count('*');
        $total_video = DB::table('channel')->sum('total_video');
        $total_view = DB::table('channel')->sum('total_view');
        $total_subscribe = DB::table('channel')->sum('subscribe');
        $total_like = DB::table('channel')->sum('total_like');
        $total_dislike = DB::table('channel')->sum('total_dislike');
        $total_comment = DB::table('channel')->sum('total_comment');

        // top kênh tương tác nhiều nhất
        $top_channel = DB::table('channel')->select(DB::raw('*, total_like + total_comment + total_dislike as tuongtac'))->orderBy('tuongtac','DESC')->limit(10)->get();

        // top video nhiều view nhất
        $videos = DB::table('detail_video')->orderBy('view','desc')->limit(10)->get();
        return view('pages.dashboard',compact('num_channel','total_video','total_view','total_subscribe','total_like','total_dislike','total_comment','top_channel','videos'));
    }
    public function statistical()
    {
        $data = DB::table('chart_view')->select(DB::raw('*,DATE_FORMAT(created_at,\'%d/%m/%Y\') AS date'))->get();
        return response()->json($data,200);
    }

}
