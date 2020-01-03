<?php

namespace App\Http\Controllers;

use Facebook\WebDriver\Remote\LocalFileDetector;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Http\Request;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UploadVideoController extends Controller {
	public function UploadController() {

				$id_page = 'C:\Users\Admin\Downloads\id_page.txt';
		        $logo_source = 'C:\Xampp\htdocs\image-html\images\logo.png';
		        $page = file_get_contents($id_page);
		        $url = "https://api.tovicorp.com/listAppVideo?page=$page&size=10&type=0";

		        $mail = "saonguyen001@gmail.com";
		        $pass = "123456@a";

		        $url_video = 'C:\Users\Admin\Downloads\video\v_cats-crash-arena-turbo-stars.mp4';

		        $value = $this->cUrl($url);
		        $i = 1;
		        if (!empty($value['data'])) {
		            $datas = $value['data'];
		            foreach ($datas as $data) {

		                $app_name = $data['title'];
		                $name = Str::slug($app_name);
		                $logo = $data['cover'];

						$title = "How to install ".$app_name;
						$desc = "";
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
		                sleep(2);

			            $driver->findElement(WebDriverBy::id('identifierId'))->sendKeys($mail);
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



			            // $driver->close();
						break;
		                sleep(5);
		                $i++;
		                if ($i == 11) {
		                    file_put_contents($id_page, $page + 1);
		                    $this->ScreenShot();
		                }
		            }
		        }
	}

	public function cUrl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);
		curl_close($ch);
		$data  = json_decode($response);
		$value = json_decode(json_encode($data), true);

		return $value;
	}
}
