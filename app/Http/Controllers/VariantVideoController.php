<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DTS\eBaySDK\Inventory\Types\Dimension;
use Facebook\WebDriver\WebDriverDimension;
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


class VariantVideoController extends Controller
{
    public function RenderAuto()
    {
        try {
            $this->VariantVideoController();
        } catch (Exception $e) {
            $this->RenderAuto();
        }
    }

    public function VariantVideoController()
    {
        $logo_source = 'C:\Users\Admin\Desktop\BOT-PC\apktoVi\Variants\logo\unnamed.png';
        $h1_source = 'C:\Users\Admin\Desktop\BOT-PC\apktoVi\Variants\1-1\3-bg.png';
        $h2_source = 'C:\Users\Admin\Desktop\BOT-PC\apktoVi\Variants\1-2\3-info.png';
        $h3_source = 'C:\Users\Admin\Desktop\BOT-PC\apktoVi\Variants\1-3\4-bg.png';

        $id_page = 'C:\Users\Admin\Downloads\variant\variant.txt';
        $logo_source_scr = 'C:\Xampp\htdocs\image-html\images\logo.png';
        $source_project_1 = 'C:\Users\Admin\Desktop\BOT-PC\apktoVi\Variants\Variants-Final-1.aep';
        $source_project_2 = 'C:\Users\Admin\Desktop\BOT-PC\apktoVi\Variants\Variants-Final-2.aep';
        $source_variant = 'C:/Users/Admin/Downloads/variant';

        $page = file_get_contents($id_page);

        $url = "https://api.tovicorp.com/listAppVideo?page=$page&size=50&type=0&variant=1";

        $value = $this->cUrl($url);

        if (!empty($value['data'])) {
            $datas = $value['data'];
            foreach ($datas as $data) {

                $app_name = $data['title'];
                $package_name = $data['appid'];
                $size = $data['size_convert'];
                $img = $data['image'];
                $img_2 = $data['image_1'];
                $img_3 = $data['image_2'];
                $file_down = $data['file_down'];
                $author = $data['offerby'];
                $category = $data['category'];
                $url_title = $data['urltitle'];
                $number_variant = $data['total_variants'];
                $height_1 = $data['height'];
                $height_2 = $data['height_1'];
                $position = $data['position'];

                if ( !empty($height_1) && !empty($height_2) && !empty($position) && !empty($img) && !empty($img_2) && !empty($img_3)) {

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
                        $source_video = 'C:\Users\Admin\Downloads\variant\v_' . $name;

                        $logo = $data['cover'];

                        sleep(1);

                        $this->downloadDistantFile($logo . "=w125", $logo_source);
                        $this->downloadDistantFile($logo . "=w258", $logo_source_scr);
                        $this->downloadDistantFile($img, $h1_source);
                        $this->downloadDistantFile($img_2, $h2_source);
                        $this->downloadDistantFile($img_3, $h3_source);

                        file_put_contents('C:/Xampp/htdocs/image-html/name.txt', $app_name);
                        var_dump("Start Rendering $name .... ");

                        $content = File::get("C:\Users\Admin\Downloads\demoVariant.js");
                        $content = str_replace("App_name", $app_name, $content);
                        $content = str_replace("package_name", $package_name, $content);
                        $content = str_replace("app_size", $size, $content);
                        $content = str_replace("file_down", $file_down, $content);
                        $content = str_replace("name_cut", $name_cut, $content);
                        $content = str_replace("number_variant", $number_variant, $content);
                        $content = str_replace("short_name", $name, $content);
                        if ($height_1 < 160) {
                            $content = str_replace("size_height_1", '522', $content);
                        } else {
                            $content = str_replace("size_height_1", '536', $content);
                        }
                        if ($height_2 < 150) {
                            $content = str_replace("size_height_2", "510.4", $content);
                        } elseif ($height_2 > 150 && $height_2 < 165) {
                            $content = str_replace("size_height_2", "530.4", $content);
                        } else {
                            $content = str_replace("size_height_2", "560.4", $content);
                        }
                        var_dump($content);
                        file_put_contents("C:\Users\Admin\Desktop\demoVariant.js", $content);

                        var_dump("Rendering...");
                        if($position == 1) {
                            exec('aerender -project ' . $source_project_1 . ' -comp render -output ' . $source_variant . '/v_' . $name . '.mov');
                        }else{
                            exec('aerender -project ' . $source_project_2 . ' -comp render -output ' . $source_variant . '/v_' . $name . '.mov');
                        }

                        var_dump("Render Complete !");
                        sleep(1);
                        $this->ConvertToMp4($source_video . '.mov', $source_video . '.mp4');
                        var_dump("convert complete");


                        sleep(5);
                        $this->screenShot($name);
                        $url_image = 'C:\Users\Admin\Downloads\screenshot\v_' . $name . '.png';
                        $this->UploadController($app_name, $source_video . '.mp4', $url_image, $author, $url_app,
                            $category, $type_vi, $page, $package_name, $number_variant);

                        var_dump("All Complete.......");
                        sleep(15);

                        $this->Shutdown();
                    } else {
                        var_dump("Video has been exist !");
                    }
                }
            }

            file_put_contents($id_page, $page + 1);
            $this->VariantVideoController();
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

        $d = new WebDriverDimension(1920, 1080);
        $driver->manage()->window()->setSize($d);

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

    public function UploadController($app_name, $url_video, $url_image, $author, $url_app, $category, $type_vi, $page, $package_name, $number_variant)
    {
        $type_vi = str_replace(' ', '', $type_vi);
        $mail = "apktovi1@gmail.com";
        $pass = "apktovi@2019";

        $title = "How to download and install " . $app_name . ' Apk (Variant) on Android Mobile';

        $desc = "Here's our step-by-step guide on how to download and install $app_name Apk on Android Mobile. The latest version of $app_name APK comes in $number_variant variants. To select the proper one, you need to know your phone's info via a third-part app called \"AIDA64\"

Step 1: Access the website https://apktovi.com and search \"AIDA64\".
Step 2: Tap on the app - Hit “Download APK” - Choose “OK” - Tap “Open”.
Step 3: Touch “Install” and wait for the process to complete.

Then, see the details of your Android device. Go to CPU to see Architecture (Supported ABIs).
Go to Display to see Pixel Density (DPI)
Go to Android to see the Android Version.

Now, go back to apktovi.com and search for \"$app_name\" and compare the phone's specifications with each variant's as guided in the video. After comparing, choose one of the two suitable variants to download.

Then, the steps to install $app_name are similar to downloading and installing AIDA64.

$app_name, developed by #$author, is an amazing $type_vi that has gained a massive number of downloads (100,000,000+). This $type_vi is listed in the Social category of app store. 

$app_name free download is available at #ApkTovi, which provides 100% original and virus-free apk files of not only the latest and updated version but also older versions of $app_name. You can get the app installed on your phone with ease by watching our video on how to download and install $app_name apk on Android Mobile. Also, this video is especially useful for those who cannot find the app they want on Google Play. 

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
        DB::table('check_video')->insert(['id_video' => $package_name, 'created_at' => $time, 'page_id' => $page, 'obb'=>2,'stt' => 2, 'youtube_id' => $youtube_link]);

    }

    public function Shutdown()
    {
        $time = Carbon::now();
        $time_now = strtotime($time);
        $time_off = strtotime("22:00:00");

        if ($time_now > $time_off) {
            exec("shutdown /s");
        }
    }

    public function check_height($drive, $package_name)
    {
        $url = "https://apktovi.com/$package_name";
        $host = 'http://localhost:4444/wd/hub';
        $USE_FIREFOX = true; // if false, will use chrome.
        $caps = DesiredCapabilities::chrome();
        $prefs = array();
        $options = new ChromeOptions();

        $prefs['profile.default_content_setting_values.notifications'] = 2;
        $options->setExperimentalOption("prefs", $prefs);
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);

        $driver = RemoteWebDriver::create($host, DesiredCapabilities::firefox());

        $d = new WebDriverDimension(500, 1000);
        $driver->manage()->window()->setSize($d);
        $driver->get($url);

    }
}
