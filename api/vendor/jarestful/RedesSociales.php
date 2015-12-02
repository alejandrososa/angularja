<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 15/11/2015
 * Time: 14:00
 */

namespace Api;


class RedesSociales{

    private $SHARED_URL;
    private $FLAG_HTTP;
    private $FLAG_HTTPS;

    public function __construct(){
        $this->SHARED_URL = $_GET['url'];
        $this->FLAG_HTTP = $_GET['http'] == 'true' ? TRUE : FALSE;
        $this->FLAG_HTTPS = $_GET['https'] == 'true' ? TRUE : FALSE;
    }

    public function validarUrl(){
        if (filter_var($this->SHARED_URL, FILTER_VALIDATE_URL) === FALSE) {
            return('There is nothing for you here... Seems like you supplied an invalid URL...');
        }else{
            return 'OK';
        }
    }

    function get_fb_shares_count($url) {
        $file_contents = @file_get_contents(FACEBOOK_API_URL . $url);
        $response      = json_decode($file_contents, true);

        if (isset($response[$url]['shares'])) {
            return intval($response[$url]['shares']);
        }

        return 0;
    }

}