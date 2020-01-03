<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
class VideoController extends Controller
{
    public function __construct()
    {
        $channels = DB::table('channel')->get();
        View::share('channels',$channels);
    }
    public function index()
    {
        $videos = DB::table('detail_video')->paginate(35);
        $index = $videos->firstItem();
        $num_result = DB::table('detail_video')->count();
        return view('pages.video',compact('videos','index','num_result'));
    }

    public function update_channel()
    {
        $channels = DB::table('channel')->get();
        foreach ($channels as $channel)
        {
            $total_like = DB::table('detail_video')->where('id_channel',$channel->channel_id)->sum('num_like');
            $total_dislike = DB::table('detail_video')->where('id_channel',$channel->channel_id)->sum('dislike');
            $total_comment = DB::table('detail_video')->where('id_channel',$channel->channel_id)->sum('comment');
            DB::table('channel')->where('id',$channel->id)
                ->update([
                    'total_like' => $total_like,
                    'total_dislike' => $total_dislike,
                    'total_comment' => $total_comment,
                ]);
        }
    }

    public function Cron_Job_Video()
    {

        $arr_key = DB::table('youtube_account')->where('api_key','!=','')->get();

        $videos = DB::table('youtube_video')->where('status','=','1')->where('request_checked','=','1')->where('id','>',3310)->get();

        $dem = 0; // đếm số lượt api key sử dụng
        $index_key = 0; // bắt đầu dùng từ key số 1


        $i = 0;
        foreach ($videos as $num => $video)
        {
            if($video->id_youtube == '')
                continue;

            //$key = $arr_key[$index_key]->api_key;
            $key = $arr_key[$index_key];

            $video_id = $video->id_youtube;
            $package_name = $video->package_name;
            $type = $video->type;
            $email_channel = $video->email_channel;
            $model = $video->model;
            $language = $video->language;
            $created_at = $video->created_at;

            // lấy thông tin video
            $result = $this->get_Info_Video(['snippet','contentDetails','statistics','status'],$video_id,$key);
            if(empty($result['items']))
                continue;

            $snippet = $result['items'][0]['snippet'];                // chứa các trích dẫn video
            $contentDetails = $result['items'][0]['contentDetails'];  // chứa nội dung video
            $status = $result['items'][0]['status'];                  // chứa trạng thái video
            $statistics = $result['items'][0]['statistics'];          // chứa số liệu thống kê video

            // nếu video chưa có thì thêm mới ngược lại có rồi thi update
            $check_video = DB::table('detail_video')->where('id_video',$video_id)->first();
            if($check_video == null)
            {
                DB::table('detail_video')->insert([
                    'id_channel' => $snippet['channelId'],
                    'id_video' => $video_id,
                    'title' => $snippet['title'],
                    'thumbnail' => $snippet['thumbnails']['default']['url'],
                    'email' => $email_channel,
                    'package_name' => $package_name,
                    'type' => $type,
                    'model' => $model,
                    'language' => $language,
                    'duration' => $contentDetails['duration'],
                    'view' => $statistics['viewCount'],
                    'num_like' => $statistics['likeCount'],
                    'dislike' => $statistics['dislikeCount'],
                    'comment' => $statistics['commentCount'],
                    'status' => $status['privacyStatus'],
                    'created_at' => $created_at,
                    'updated_at' => Carbon::now('Asia/Ho_Chi_Minh')
                ]);
            }
            else
            {
                DB::table('detail_video')
                ->where('id_video',$video_id)
                ->update([
                    'view' => $statistics['viewCount'],
                    'num_like' => $statistics['likeCount'],
                    'dislike' => $statistics['dislikeCount'],
                    'comment' => $statistics['commentCount'],
                    'model' => $model,
                    'status' => $status['privacyStatus'],
                    'updated_at' => Carbon::now('Asia/Ho_Chi_Minh')
                ]);
            }
            //sleep(1);
            // mỗi api key sử dụng 500 lượt request
            $dem++;
            if($dem >= 500 && $index_key < count($arr_key)-1)
            {
                $index_key++;
                $dem=0;
            }
            var_dump($video_id.' checked - '.$i);
            $i++;
            $this->update_channel();
        }

    }

    // hàm lấy thông tin của một video
    public function get_Info_Video($part = array(), $video_id, $key)
    {
        $str = join(",", $part);
        $api_getAllInfoVideo = 'https://www.googleapis.com/youtube/v3/videos?part=' . $str . '&id=' . $video_id . '&key=' . $key;
        $response = file_get_contents($api_getAllInfoVideo);
        return json_decode($response, true);
    }

    // hàm lấy tất cả comment trong video
    public function get_Comment_Video($part = array(),$video_id,$key)
    {
        $str = join(",", $part);
        $api = 'https://www.googleapis.com/youtube/v3/commentThreads?key='.$key.'&textFormat=plainText&part='.$str.'&videoId='.$video_id;
        $response = file_get_contents($api);
        return json_decode($response, true);
    }

    //==========================================

    public function sortViewVideo()
    {
        $videos = DB::table('detail_video')->orderBy('view','desc') ->paginate(35);
        $index = $videos->firstItem();
        $num_result = DB::table('detail_video')->orderBy('view','desc')->count();
        return view('pages.video',compact('videos','index','num_result'));
    }

    public function sortLikeVideo()
    {
        $videos = DB::table('detail_video')->orderBy('num_like','desc') ->paginate(35);
        $index = $videos->firstItem();
        $num_result = DB::table('detail_video')->orderBy('num_like','desc')->count();
        return view('pages.video',compact('videos','index','num_result'));
    }

    public function sortDislikeVideo()
    {
        $videos = DB::table('detail_video')->orderBy('dislike','desc') ->paginate(35);
        $index = $videos->firstItem();
        $num_result = DB::table('detail_video')->orderBy('dislike','desc')->count();
        return view('pages.video',compact('videos','index','num_result'));
    }
    public function sortCommentVideo()
    {
        $videos = DB::table('detail_video')->orderBy('comment','desc')->paginate(35);
        $index = $videos->firstItem();
        $num_result = DB::table('detail_video')->orderBy('comment','desc')->count();
        return view('pages.video',compact('videos','index','num_result'));
    }

    public function filterVideo(Request $request)
    {
        $this->validate($request,[
            'view' => 'bail|numeric',
            'num_like' => 'bail|numeric',
            'dislike' => 'bail|numeric',
            'comment' => 'bail|numeric',
        ],[
            'view.numeric' => 'Dữ liệu không hợp lệ',
            'num_like.numeric' => 'Dữ liệu không hợp lệ',
            'dislike.numeric' => 'Dữ liệu không hợp lệ',
            'comment.numeric' => 'Dữ liệu không hợp lệ',
        ]);
        $params = $request->all();
        $where = [];
        foreach ($params as $key => $value)
        {
            if($key != 'id_channel' && $key != 'type')
            {
                array_push($where,[$key,'>=',$value]);
            }
            if(($key == 'id_channel' || $key == 'type') && $value != null)
            {
                array_push($where,[$key,'=',$value]);
            }
        }
        $noLink = 1;
        $num_result = DB::table('detail_video')->where($where)->count();
        $videos = DB::table('detail_video')->where($where)->get();
        return view('pages.video',compact('videos','num_result','noLink'));
    }


}
