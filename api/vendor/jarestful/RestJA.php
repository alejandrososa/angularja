<?php
namespace Api;

class RestJA {

    public $_allow = array();
    public $_content_type = "application/json; charset=utf-8";
    public $_request = array();
    public $_token = "";

    private $_method = "";
    private $_code = 200;
    private $_mensaje = "";
    private $_autorization = "Authorization";

    public function __construct(){
        $this->inputs();
    }

    public function get_referer(){
        return $_SERVER['HTTP_REFERER'];
    }

    public function response($data, $status){
        $this->_code = ($status)?$status:200;
        $this->_mensaje = ($status) && $status == 204 ? $data : '';
        $this->set_headers();
        print_r($data);
        exit;
    }
    public function setToken($token){
        $this->_token = $token;
    }

    // For a list of http codes checkout http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
    private function get_status_message(){
        $status = array(
                    200 => 'OK',
                    201 => 'Created',
                    204 => $this->_mensaje,
                    404 => 'Not Found',
                    406 => 'Not Acceptable',
                    401 => 'Unauthorized');
        return ($status[$this->_code])?$status[$this->_code]:$status[500];
    }

    public function get_request_method(){
        return $_SERVER['REQUEST_METHOD'];
    }

    private function inputs(){
        switch($this->get_request_method()){
            case "POST":
                $this->_request = $this->cleanInputs($_POST);
                break;
            case "GET":
            case "DELETE":
                $this->_request = $this->cleanInputs($_GET);
                break;
            case "PUT":
                parse_str(file_get_contents("php://input"),$this->_request);
                $this->_request = $this->cleanInputs($this->_request);
                break;
            default:
                $this->response('',406);
                break;
        }
    }

    private function cleanInputs($data){
        $clean_input = array();
        if(is_array($data)){
            foreach($data as $k => $v){
                $clean_input[$k] = $this->cleanInputs($v);
            }
        }else{
            if(get_magic_quotes_gpc()){
                $data = trim(stripslashes($data));
            }
            $data = strip_tags($data);
            $clean_input = trim($data);
        }
        return $clean_input;
    }

    private function set_headers(){
        header("HTTP/1.1 ".$this->_code." ".$this->get_status_message(), true, $this->_code);
        header("Content-Type:".$this->_content_type);

        if(!empty($this->_token)){
            header($this->_autorization.': oauth'.$this->_token);
        }else{
            header_remove($this->_autorization);
        }
    }
}