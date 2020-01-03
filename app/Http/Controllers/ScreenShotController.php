<?php

namespace App\Http\Controllers;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ScreenShotController extends Controller
{
    public function ScreenShot(){

        $id_page = 'C:\Users\Admin\Downloads\id_page.txt';
        $logo_source = 'C:\Xampp\htdocs\image-html\images\logo.png';
        $page = file_get_contents($id_page);
        $url = "https://api.tovicorp.com/listAppVideo?page=$page&size=10&type=0";

        $value = $this->cUrl($url);
        $i = 1;
        if (!empty($value['data'])) {
            $datas = $value['data'];
            foreach ($datas as $data) {

                $app_name = $data['title'];
                $name = Str::slug($app_name);
                $logo = $data['cover'];
                $this->downloadDistantFile($logo . "=w258", $logo_source);

                file_put_contents('C:\Xampp\htdocs\image-html\name.txt',$app_name);

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
                $screenshot = 'C:\Users\Admin\Downloads\screenshot\v_'.$name.'.png';
                $driver->takeScreenshot($screenshot);
                $img = Image::make($screenshot);
                $img->crop(1280, 720,0,0);
                $img->save($screenshot);
                var_dump('Success full !.....');

                sleep(1);

                $driver->quit();

                sleep(5);
                $i++;
                if ($i == 11) {
                    file_put_contents($id_page, $page + 1);
                    $this->ScreenShot();
                }
            }
        }
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
}
