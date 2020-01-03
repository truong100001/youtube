<?php

namespace App\Http\Controllers;

use alchemyguy\YoutubeLaravelApi\LiveStreamService;
use alchemyguy\YoutubeLaravelApi\YoutubeLaravelApiServiceProvider;
use Facebook\WebDriver\Remote\LocalFileDetector;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Http\Request;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Facades\DB;

class AutoDeleVideoController extends Controller
{
    public function Delete()
    {
//        $table = DB::select(DB::raw("SELECT *  FROM `video_combo` WHERE `bot_number` > 0 and request_checked < 2"));
//
//        foreach ($table as $item) {
//            $api_key = "AIzaSyDY2nd0c1fFDBKmY7EgKr-tQDbMqwNUHzk";
//            $video_id = $item->youtube_id;
//            $id = $item->id;
//            $video_id = str_replace('https://youtu.be/', '', $video_id);
//
//            $response = file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=id&id=' . $video_id . '&key=' . $api_key);
//
//            $json = json_decode($response, true);
//
//
//            if (!empty($json['items'])) { // nếu video đã tồn tại trên youtube
//                if (count($json['items'])) {
//                    //DB::table('video_combo')->where('id', $id)->update(['request_checked' => 2]);
//                    var_dump("Video id $video_id has been update");
//
//                    // to do
//
//
//
//                } else {
//                    //DB::table('video_combo')->where('id', $id)->delete();
//                    var_dump("Video id $video_id has been deleted");
//                }
//            }else {
//                //DB::table('video_combo')->where('id', $id)->delete();
//                var_dump("Video id $video_id has been deleted");
//            }
//
//            sleep(1);
//        }
        //echo 'ok';
        $a = new LiveStreamService();

        $this->convert_String_To_Seconds('PT1H1M32S');
        $result = $this->get_Info_Video(['contentDetails','snippet','status'],'FZ4ZBPiAfc0','AIzaSyDY2nd0c1fFDBKmY7EgKr-tQDbMqwNUHzk');
        dd($result);
//        $result = file_get_contents('https://i.ytimg.com/vi/FZ4ZBPiAfc0/maxresdefault.jpg');
//        echo '<pre>';
//        var_dump($result);

    }

    // hàm lấy thông tin video, part là một mảng có thể có nhiều tham số chúng ta có thể truyền để lấy nhiều hoặc ít
    public function get_Info_Video($part = array(),$video_id,$key)
    {
        $str = join(",",$part);
        $api_getAllInfoVideo = 'https://www.googleapis.com/youtube/v3/videos?part='.$str.'&id='.$video_id.'&key='.$key;
        $response = file_get_contents($api_getAllInfoVideo);
        return json_decode($response,true);
    }

    // hàm chuyển chuỗi duration lấy từ api youtube thành giây vd: 1M20 -> 80
    public function convert_String_To_Seconds($string)
    {
        $string = str_replace('PT','',$string);
        preg_match('/((?<h>[\d]+)H)?((?<m>[\d]+)M)?((?<s>[\d]+)S?)/', $string, $m);

        if($m['h'] == '')
            $m['h'] = 0;
        if($m['m'] == '')
            $m['m'] = 0;

        return ($m['h']* 60 + $m['m']) * 60 + $m['s'];
    }


}
