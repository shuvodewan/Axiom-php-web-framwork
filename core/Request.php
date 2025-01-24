<?php

namespace Core;

use Facade\Str;

class Request
{
    static $instance;
    public $uri;
    public $method;
    public $body=[];
    public $query=[];
    public $files=[];
    public $agent=[];
    public $headers=[];
    public $userIp;


    static function setInstance(){
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function capture()
    { 
        $this->captureBase()
        ->captureQueryStrings()
        ->capturePostBody()
        ->captureHeaders()
        ->captureUserAgent()
        ->captureUserIp();
        return $this;
    }

    private function captureBase(){
        $this->uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $this->method = $_SERVER['REQUEST_METHOD'];
        return $this;
    }

    private function captureQueryStrings(){
        $this->query = $_GET;
        return $this;
    }

    private function capturePostBody(){
        $this->body = $_POST;
        return $this;
    }

    private function captureHeaders(){
        $this->headers = array_map(function($value) {
            return strtolower($value);
        }, array_change_key_case(getallheaders(), CASE_LOWER));

        return $this;
    }

    private function captureUserAgent(){
        $this->agent = $_SERVER['HTTP_USER_AGENT'];
        return $this;
    }

    private function captureUserIp(){
        $this->userIp = $_SERVER['REMOTE_ADDR'];
    }

    public function isJsonResponse(){
        return strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false;
    }
    
    public function isXmlResponse(){
        return strpos($_SERVER['CONTENT_TYPE'], 'application/xml') !== false || strpos($_SERVER['CONTENT_TYPE'], 'text/xml') !== false;
    }
    
    public function isHtmlResponse(){
        return strpos($_SERVER['CONTENT_TYPE'], 'text/html') !== false;
    }
    
    public function isFormResponse(){
        return strpos($_SERVER['CONTENT_TYPE'], 'application/x-www-form-urlencoded') !== false;
    }
    
    public function isMultipartFormResponse(){
        return strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') !== false;
    }
    
    public function isPlainTextResponse(){
        return strpos($_SERVER['CONTENT_TYPE'], 'text/plain') !== false;
    }
    
    public function isJavascriptResponse(){
        return strpos($_SERVER['CONTENT_TYPE'], 'application/javascript') !== false || strpos($_SERVER['CONTENT_TYPE'], 'text/javascript') !== false;
    }
    
    public function isCssResponse(){
        return strpos($_SERVER['CONTENT_TYPE'], 'text/css') !== false;
    }

    public function getHeader($key){
        return $this->headers[Str::camelToKebab($key)];
    }
}