<?php

namespace App\Http\Controllers;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpseclib\Crypt\Random;

class BotViewVideoController extends Controller
{
    public function BotViewVideoController()
    {
        try{
            $this->Bot();
        }catch (\Exception $exception){
            $this->Bot();
        }

    }
    public function Bot(){
        $page = file_get_contents(public_path() . '/page_video.txt');
        $db_video = DB::select(DB::raw("SELECT * FROM video_combo WHERE type_video = 4 limit $page, 20"));
        $db_youtube_account = DB::select(DB::raw("SELECT * FROM youtube_account WHERE stt != 3 ORDER BY RAND() LIMIT 1"));
        $email = $db_youtube_account[0]->username;
        $pass = $db_youtube_account[0]->password;

        $host = 'http://localhost:4444/wd/hub';
        $USE_FIREFOX = true; // if false, will use chrome.
        $caps = DesiredCapabilities::chrome();
        $prefs = array();
        $options = new ChromeOptions();
        $prefs['profile.default_content_setting_values.notifications'] = 2;
        $options->setExperimentalOption("prefs", $prefs);
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);
        $caps->setCapability('userAgent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0');
        $driver = RemoteWebDriver::create($host, DesiredCapabilities::firefox());

        $driver->get("https://studio.youtube.com/");
        sleep(5);

        $driver->findElement(WebDriverBy::cssSelector("input"))->sendKeys($email);
        sleep(1);
        $driver->findElement((WebDriverBy::id('identifierNext')))->click();
        sleep(1);
        $driver->findElement(WebDriverBy::id('password'))->findElement(WebDriverBy::cssSelector('input'))->sendKeys($pass);
        sleep(1);
        $driver->findElement((WebDriverBy::id('passwordNext')))->click();
        sleep(10);
        var_dump('open youtube');
        sleep(10);
        foreach ($db_video as $video) {
            $youtube_link = $video->youtube_id;
            $driver->get($youtube_link);
            var_dump($youtube_link);
            sleep(60);
            $driver->findElement(WebDriverBy::className('ytp-large-play-button'))->click();
            sleep(260);
            $driver->findElement(WebDriverBy::xpath('/html/body/ytd-app/div/ytd-page-manager/ytd-watch-flexy/div[4]/div[1]/div/div[5]/div[2]/ytd-video-primary-info-renderer/div/div/div[3]/div/ytd-menu-renderer/div/ytd-toggle-button-renderer[1]'))->click();
            sleep(30);

            var_dump('Video done !');
            sleep(10);
        }
        file_put_contents(public_path() . '/page_video.txt', $page + 1);
        sleep(5);
        exec('rasphone -h "Viettel"');
        sleep(10);
        $this->BotViewVideoController();
    }
}
