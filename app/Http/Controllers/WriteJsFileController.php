<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Intervention\Image\Facades\Image;
use Facebook\WebDriver\Remote\LocalFileDetector;
use Facebook\WebDriver\WebDriverBy;
use Matrix\Exception;


class WriteJsFileController extends Controller
{
    public function RenderAuto()
    {
        try {
            $this->WriteJsFileController();
        } catch (Exception $e) {
            $this->RenderAuto();
        }
    }

    public function WriteJsFileController()
    {
        $logo_source = 'C:\Users\Admin\Desktop\apktovi-bot\source\3logo\popcashlogo.png';
        $h2_source = 'C:\Users\Admin\Desktop\apktovi-bot\source\2\2.png';
        $id_page = 'C:\Users\Admin\Downloads\video\id_page.txt';
        $logo_source_scr = 'C:\Xampp\htdocs\image-html\images\logo.png';

        $page = file_get_contents($id_page);
        //type = 0 là apk thường, type = 1 là obb
        $url = "https://api.tovicorp.com/listAppVideo?page=$page&size=100&type=0";

        $value = $this->cUrl($url);

        if (!empty($value['data'])) {
            $datas = $value['data'];
            foreach ($datas as $data) {

                $app_name = $data['title'];
                $package_name = $data['appid'];
                $size = $data['size_convert'];
                $img = $data['image'];
                $file_down = $data['file_down'];
                $author = $data['offerby'];
                $category = $data['category'];
                $url_title = $data['urltitle'];
               
                    if (intval($data['game']) == 1) {
                        $type_vi = "game";
                    } else {
                        $type_vi = "app";
                    }
                    $url_app = $url_title . '-' . $package_name;

                    $check_video = DB::table('check_video')->where(['id_video' => $package_name])->first();

                    if ($check_video == null) {

                        $name = Str::slug($app_name);
                        $name_cut = substr(urlencode($app_name), 0, 7);
                        $source_video = 'C:\Users\Admin\Downloads\video\v_' . $name;

                        $logo = $data['cover'];

                        sleep(1);

                        $this->downloadDistantFile($logo . "=w125", $logo_source);
                        $this->downloadDistantFile($logo . "=w258", $logo_source_scr);
                        $this->downloadDistantFile($img, $h2_source);
                        file_put_contents('C:\Xampp\htdocs\image-html\name.txt', $app_name);
                        var_dump("Start Rendering $name .... ");

                        $content = File::get("C:\Users\Admin\Downloads\abc.js");
                        $content = str_replace("App_name", $app_name, $content);
                        $content = str_replace("package_name", $package_name, $content);
                        $content = str_replace("app_size", $size, $content);
                        $content = str_replace("file_down", $file_down, $content);
                        $content = str_replace("name_cut", $name_cut, $content);
                        var_dump($content);
                        file_put_contents("C:\Users\Admin\Desktop\demo.js", $content);

                        $source_project = 'C:\Users\Admin\Desktop\apktovi-bot\Project\Project.aep';
                        var_dump("Rendering...");
                        exec('aerender -project ' . $source_project . ' -comp render -output C:\Users\Admin\Downloads\video\v_' . $name . '.mov');
                        var_dump("Render Complete !");
                        sleep(1);
                        $this->ConvertToMp4($source_video . '.mov', $source_video . '.mp4');
                        var_dump("convert complete");


                        sleep(5);
                        $this->screenShot($name);
                        $url_image = 'C:\Users\Admin\Downloads\screenshot\v_' . $name . '.png';
                        $this->UploadController($app_name, $source_video . '.mp4', $url_image, $author, $url_app,
                            $category, $type_vi, $page, $package_name);

                        var_dump("All Complete.......");
                        sleep(15);
                        
                       // $this->Shutdown();
                    } else {
                        var_dump("Video has been exist !");
                    }
                }
            
            file_put_contents($id_page, $page + 1);
            $this->WriteJsFileController();
        } else {
            var_dump($value);
        }
    }

    public function cUrl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);
        $value = json_decode(json_encode($data), true);

        return $value;
    }

    public function downloadDistantFile($url, $dest)
    {
        $options = array(
            CURLOPT_FILE => is_resource($dest) ? $dest : fopen($dest, 'w'),
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_URL => $url,
            CURLOPT_FAILONERROR => true,
            // HTTP code > 400 will throw curl error
        );

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $return = curl_exec($ch);

        if ($return === false) {
            return curl_error($ch);
        } else {
            var_dump('Saved image !');
        }
    }

    public function ConvertToMp4($path_in, $path_out)
    {
        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open($path_in);
        $type = new Mp3();
        $video->save($type, $path_out);
        var_dump("Convert success full !");
        unlink($path_in);
    }

    public function screenShot($name)
    {
        $host = 'http://localhost:4444/wd/hub';
        $USE_FIREFOX = true; // if false, will use chrome.
        $caps = DesiredCapabilities::chrome();
        $prefs = array();
        $options = new ChromeOptions();

        $prefs['profile.default_content_setting_values.notifications'] = 2;
        $options->setExperimentalOption("prefs", $prefs);
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);

        $driver = RemoteWebDriver::create($host, DesiredCapabilities::firefox());

        $driver->get("http://localhost/image-html/");
        sleep(2);
        $screenshot = 'C:\Users\Admin\Downloads\screenshot\v_' . $name . '.png';
        $driver->takeScreenshot($screenshot);
        $img = Image::make($screenshot);
        $img->crop(1280, 720, 0, 0);
        $img->save($screenshot);
        var_dump('Screenshot complete !.....');

        sleep(1);

        $driver->quit();
    }

    public function UploadController($app_name, $url_video, $url_image, $author, $url_app, $category, $type_vi, $page, $package_name)
    {
        $type_vi = str_replace(' ', '', $type_vi);
        $mail = "apktovi1@gmail.com";
        $pass = "seoapk@2019";

        $title = "How to download and install " . $app_name . ' Apk on Android Mobile';

        $desc = "Here's our step-by-step guide on how to download and install $app_name Apk on Android Mobile
Step 1: Access the website https://apktovi.com and search \"$app_name\".
Step 2: Tap on the app - Hit “Download APK” - Choose “OK” - Tap “Open”.
Step 3: Touch “Install” and wait for the process to complete.

$app_name, developed by #$author, is an amazing $type_vi that has gained a massive number of downloads (100,000,000+). This app is listed in the $category category of app store. 

$app_name free download is available at #ApkTovi, which provides 100% original and virus-free apk files of not only the latest and updated version but also older versions of $app_name. You can get the $type_vi installed on your phone with ease by watching our video on how to download and install $app_name apk on Android Mobile. Also, this video is especially useful for those who cannot find the $type_vi they want on Google Play. 

These are apk files of multiple possible apps for download at our website. Check out apk store here: https://apktovi.com/$url_app

Thanks for watching----------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------- 
Subscribe : https://www.youtube.com/channel/UCXoMchgPQye4qsOgnP_FHdw
Website : https://apktovi.com/
Twitter : https://twitter.com/apktovi
Fanpage : https://www.facebook.com/ApktoVi";
        $tags = "";

        $host = 'http://localhost:4444/wd/hub';
        $USE_FIREFOX = true; // if false, will use chrome.
        $caps = DesiredCapabilities::chrome();
        $prefs = array();
        $options = new ChromeOptions();

        $prefs['profile.default_content_setting_values.notifications'] = 2;
        $options->setExperimentalOption("prefs", $prefs);
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);

        $driver = RemoteWebDriver::create($host, DesiredCapabilities::firefox());

        $driver->get("https://www.youtube.com/upload");
        sleep(5);

        $driver->findElement(WebDriverBy::cssSelector("input"))->sendKeys($mail);
        sleep(1);
        $driver->findElement((WebDriverBy::id('identifierNext')))->click();
        sleep(1);
        $driver->findElement(WebDriverBy::id('password'))->findElement(WebDriverBy::cssSelector('input'))->sendKeys($pass);
        sleep(1);
        $driver->findElement((WebDriverBy::id('passwordNext')))->click();
        sleep(4);
        $upload = $driver->findElement((WebDriverBy::id('upload-prompt-box')))->findElement(WebDriverBy::cssSelector('input'));
        sleep(1);
        $upload->setFileDetector(new LocalFileDetector());
        $upload->sendKeys($url_video);

        sleep(10);
        $driver->findElement(WebDriverBy::className('video-settings-title'))->clear()->sendKeys($title);
        sleep(1);
        $driver->findElement(WebDriverBy::className('video-settings-description'))->sendKeys($desc);
        sleep(1);
        $driver->findElement(WebDriverBy::className('video-settings-add-tag'))->sendKeys($tags);
        sleep(60);

        try {
            $youtube_link = $driver->findElement(WebDriverBy::className("watch-page-link"))->getText();
            $youtube_link = str_replace("Video của bạn sẽ được phát trực tuyến tại: ", '', $youtube_link);
            var_dump("URL VIDEO: " . $youtube_link);
        } catch (Exception $exception) {
            $youtube_link = '';
        }
        try {
            $thumb_upload = $driver->findElement(WebDriverBy::className('custom-thumb-container'))->findElement(WebDriverBy::cssSelector('input'));
            sleep(1);
            $thumb_upload->setFileDetector(new LocalFileDetector());
            $thumb_upload->sendKeys($url_image);
        } catch (Exception $e) {
            var_dump("cannot click");
        }
        sleep(10);
        try {
            $driver->findElement(WebDriverBy::className('save-changes-button'))->click();
            var_dump("Video uploaded");
            sleep(5);
            $driver->close();
        } catch (Exception $e) {
            sleep(15);
            $driver->findElement(WebDriverBy::className('save-changes-button'))->click();
            var_dump("Video uploaded");
            sleep(5);
            $driver->close();
        }

        sleep(2);
        $time = Carbon::now();
        DB::table('check_video')->insert(['id_video' => $package_name, 'created_at' => $time, 'page_id' => $page, 'stt' => 2,
            'youtube_id' => $youtube_link]);

    }

    public function Shutdown()
    {
        $time = Carbon::now();
        $time_now = strtotime($time);
        $time_off = strtotime("19:00:00");

        if ($time_now > $time_off) {
            exec("shutdown /s");
        }
    }

}
