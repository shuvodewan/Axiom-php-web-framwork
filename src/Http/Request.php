<?php

namespace Axiom\Core\Http;

use Axiom\Traits\InstanceTrait;

class Request
{
    use FileTrait;
    use InstanceTrait;

    public $uri;
    public $method;
    public $body=[];
    public $query=[];
    public $agent=[];
    public $headers=[];
    public $userIp;

    public function capture()
    { 
        $this->captureBase()
        ->captureQueryStrings()
        ->capturePostBody()
        ->captureFiles()
        ->captureHeaders()
        ->captureUserAgent()
        ->captureUserIp();
        return $this;
    }

    private function captureBase(){
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $this->uri = $uri==''?'/':$uri;
        $this->method = Str::toLower($_SERVER['REQUEST_METHOD']);
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

    private function captureFiles(){
        $this->setFiles();
        return $this;
    }

    private function captureHeaders(){
        $this->headers = array_map(function($value) {
            return $value;
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
        return strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false;
    }
    
    public function isXmlResponse(){
        return strpos($_SERVER['HTTP_ACCEPT'], 'application/xml') !== false || strpos($_SERVER['CONTENT_TYPE'], 'text/xml') !== false;
    }
    
    public function isHtmlResponse(){
        return strpos($_SERVER['HTTP_ACCEPT'], 'text/html') !== false;
    }
    
    public function isFormResponse(){
        return strpos($_SERVER['HTTP_ACCEPT'], 'application/x-www-form-urlencoded') !== false;
    }
    
    public function isMultipartFormResponse(){
        return strpos($_SERVER['HTTP_ACCEPT'], 'multipart/form-data') !== false;
    }
    
    public function isPlainTextResponse(){
        return strpos($_SERVER['HTTP_ACCEPT'], 'text/plain') !== false;
    }
    
    public function isJavascriptResponse(){
        return strpos($_SERVER['HTTP_ACCEPT'], 'application/javascript') !== false || strpos($_SERVER['CONTENT_TYPE'], 'text/javascript') !== false;
    }
    
    public function isCssResponse(){
        return strpos($_SERVER['HTTP_ACCEPT'], 'text/css') !== false;
    }

    public function isJsonRequest() {
        return strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false;
    }
    
    public function isXmlRequest() {
        return strpos($_SERVER['CONTENT_TYPE'], 'application/xml') !== false || strpos($_SERVER['CONTENT_TYPE'], 'text/xml') !== false;
    }
    
    public function isHtmlRequest() {
        return strpos($_SERVER['CONTENT_TYPE'], 'text/html') !== false;
    }
    
    public function isFormRequest() {
        return strpos($_SERVER['CONTENT_TYPE'], 'application/x-www-form-urlencoded') !== false;
    }
    
    public function isMultipartFormRequest() {
        return strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') !== false;
    }
    
    public function isPlainTextRequest() {
        return strpos($_SERVER['CONTENT_TYPE'], 'text/plain') !== false;
    }
    
    public function isJavascriptRequest() {
        return strpos($_SERVER['CONTENT_TYPE'], 'application/javascript') !== false || strpos($_SERVER['CONTENT_TYPE'], 'text/javascript') !== false;
    }
    
    public function isCssRequest() {
        return strpos($_SERVER['CONTENT_TYPE'], 'text/css') !== false;
    }

    public function getHeader($key){
        return isset($this->headers[$key])?$this->headers[$key]:null;
    }
    public function getBody($key){
        return isset($this->body[$key])?$this->body[$key]:null;
    }
    public function getQuery($key){
        return isset($this->query[$key])?$this->query[$key]:null;
    }

    public function getUri(){
        return $this->uri;
    }
}