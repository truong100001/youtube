<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelController extends Controller
{
    public function index()
    {
        $channels = DB::table('channel')->get();
        return view('pages.channel', compact('channels'));
    }

    public function AddChannel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_channel' => 'bail|required|max:255',
            'name' => 'bail|required|max:255',
            'email' => 'bail|required|email',
            'phone' => 'bail|required|numeric',
            'type' => 'bail|required'
        ], [
            'id_channel.required' => 'ID kênh không được để trống',
            'id_channel.max' => 'ID kênh chỉ tối đa 255 ký tự',
            'name.required' => 'Tên kênh không được để trống',
            'name.max' => 'Tên kênh chỉ tối đa 255 ký tự',
            'email.required' => 'Email kênh không được để trống',
            'email.email' => 'Email không hợp lệ',
            'phone.required' => 'Số điện thoại kênh không được để trống',
            'phone.numeric' => 'Số điện thoại không hợp lệ',
            'type.required' => 'Loại video của kênh không được để trống'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 401, [], JSON_UNESCAPED_UNICODE);
        } else {
            DB::table('channel')->insert([
                'channel_id' => $request->id_channel,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'type' => $request->type,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                'updated_at' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);
        }

    }

    //---------------------------- CRON JOB CHANNEL ------------------------------------------------------------------
    public function Cron_Job_Channel()
    {
        $key = 'AIzaSyCk-MfTlGh-lkj_igVc4sjeSEGj1NxlNw8';
        $channels = DB::table('channel')->get();
        foreach ($channels as $channel) {
            $result = $this->get_Info_Channel(['snippet', 'contentDetails', 'statistics'], $channel->channel_id, $key);
            $statistics = $result['items'][0]['statistics'];

            DB::table('channel')
                ->where('id', $channel->id)
                ->update([
                    'total_view' => $statistics['viewCount'],
                    'total_video' => $statistics['videoCount'],
                    'subscribe' => $statistics['subscriberCount'],
                    'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                ]);
            var_dump($channel->channel_id . ' checked');
        }

        $total_view  = DB::table('channel')->sum('total_view');
        DB::table('chart_view')->insert([
            'view' => $total_view,
            'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
            'updated_at' => Carbon::now('Asia/Ho_Chi_Minh')
        ]);
        var_dump('success');
    }


    // hàm lấy thông tin của kênh
    public function get_Info_Channel($part = array(), $channel_id, $key)
    {
        $str = join(",", $part);
        $api_getAllInfoVideo = 'https://www.googleapis.com/youtube/v3/channels?part=' . $str . '&id=' . $channel_id . '&key=' . $key;
        $response = file_get_contents($api_getAllInfoVideo);
        return json_decode($response, true);
    }

    //---------------------------------- END CRON JOB CHANNEL --------------------------------------------------------


    //--------------------------------------------- SORT ----------------------------------------------------------
    public function Sort_Video_Channel()
    {
        $sortVideoChannel = DB::table('channel')->orderBy('total_video','desc')->get();
        return view('components.ajax.sortVideo',compact('sortVideoChannel'));
    }

    public function Sort_Subscribe_Channel()
    {
        $sortSubscribeChannel = DB::table('channel')->orderBy('subscribe','desc')->get();
        return view('components.ajax.sortSubscribe',compact('sortSubscribeChannel'));
    }

    public function Sort_View_Channel()
    {
        $sortViewChannel = DB::table('channel')->orderBy('total_view','desc')->get();
        return view('components.ajax.sortView',compact('sortViewChannel'));
    }

    public function Sort_Like_Channel()
    {
        $sortViewChannel = DB::table('channel')->orderBy('total_like','desc')->get();
        return view('components.ajax.sortView',compact('sortViewChannel'));
    }

    public function Sort_Dislike_Channel()
    {
        $sortViewChannel = DB::table('channel')->orderBy('total_dislike','desc')->get();
        return view('components.ajax.sortView',compact('sortViewChannel'));
    }

    public function Sort_Comment_Channel()
    {
        $sortViewChannel = DB::table('channel')->orderBy('total_comment','desc')->get();
        return view('components.ajax.sortView',compact('sortViewChannel'));
    }

    // -------------------------------------------- END SORT --------------------------------------------------------


    //--------------------------------------------- FILTER -----------------------------------------------------------
    public function Filter_Channel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'filter_subscribe' => 'bail|numeric',
            'filter_video' => 'bail|numeric',
            'filter_view' => 'bail|numeric',
            'filter_like' => 'bail|numeric',
            'filter_dislike' => 'bail|numeric'
        ], [
            'filter_subscribe.numeric' => 'Dữ liệu không hợp lệ',
            'filter_video.numeric' => 'Dữ liệu không hợp lệ',
            'filter_view.numeric' => 'Dữ liệu không hợp lệ',
            'filter_like.numeric' => 'Dữ liệu không hợp lệ',
            'filter_dislike.numeric' => 'Dữ liệu không hợp lệ',
        ]);
        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->all()], 401, [], JSON_UNESCAPED_UNICODE);
        else
        {
            $filterChannel = DB::table('channel')->where('subscribe','>=',$request->filter_subscribe)->where('total_video','>=',$request->filter_video)
                ->where('total_like','>=',$request->filter_like)->where('total_dislike','>=',$request->filter_dislike)
                ->where('total_comment','>=',$request->filter_comment)->get();

            return view('components.ajax.filterChannel',compact('filterChannel'));
        }
    }
    //------------------------------------- END FILTER --------------------------------------------------------------

    public function Refresh()
    {
        $channels = DB::table('channel')->get();
        return view('components.ajax.refresh', compact('channels'));
    }

    public function Search(Request $request)
    {
        $channels = DB::table('channel')->where('name','like','%'.$request->key.'%')->orWhere('email','like','%'.$request->key.'%')->orWhere('phone','like','%'.$request->key.'%')
            ->get();
        return view('components.ajax.search',compact('channels'));
    }

}
