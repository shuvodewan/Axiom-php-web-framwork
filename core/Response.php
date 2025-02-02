<?php

namespace Core;

use Facade\Request;

class Response
{
    static    $instance;
    protected $content;
    protected $status = 200;
    protected $headers = [];
    protected $cookies = [];

    public function __construct()
    {
        self::setInstance($this);
    }


    static function setInstance($instance){
        self::$instance = $instance;
    }

    static function getInstance(){
        return self::$instance;
    }

    private function setDefaultHeaders()
    {
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");
    }

    private function setHeaders(){
        $this->setDefaultHeaders();
        foreach ($this->headers as $key => $value) {
            header("{$key}: {$value}");
        }
    }

    private function setCookies(){
        foreach ($this->cookies as $cookie) {
            setcookie(
                $cookie['name'],
                $cookie['value'],
                config('session.expire_on_close')?$cookie['expires']??config('session.lifetime'):0
            );
        }
    }

    public function setContent($content){
        $this->content = $content;
    }


    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function send()
    {
        http_response_code($this->status);

        $this->setHeaders();

        $this->setCookies();

        echo $this->content;
        
        exit;  
    }


    public function header($key, $value)
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function cookie($name, $value, $expires = 0)
    {
        $this->cookies[] = ['name' => $name, 'value' => $value, 'expires' => $expires];
        return $this;
    }

    public function getJsonResponseData($data=null,$status,$message){
        return [
            'status'=>$status,
            'message'=>$message,
            'data'=>$data,
        ];
    }

    public function getJsonErrorResponseData($trace=null,$status,$message){
        return [
            'status'=>$status,
            'message'=>$message,
            'trace'=>$trace
        ];
    }

    public function json($data, $status = 200)
    {
        $this->setStatus($status);
        if(count(Validator::$errorsBag)){
            $data['errors']=Validator::$errorsBag;
        }
        $this->header('Content-Type', 'application/json');
        $this->content = json_encode($data);
        return $this;
    }

    public function text($content, $status = 200)
    {
        $this->setStatus($status);
        $this->header('Content-Type', 'text/plain');
        $this->content = $content;
        return $this;
    }

    public function view($view, $data = [])
    {
        $this->setStatus(200);
        $this->header('Content-Type', 'text/html');
        $this->content = $this->renderView($view, $data);
        return $this;
    }

    protected function renderView($view, $data=null)
    {
        extract($data); 
        include template_path("/".str_replace('.', '/', $view).'.phtml'); 
        return $output; 
    }

    public function download($filePath, $filename = null)
    {
        if (!file_exists($filePath)) {
            $this->setStatus(404);
            $this->content = 'File not found.';
            return $this;
        }

        $this->setStatus(200);
        $this->header('Content-Type', 'application/octet-stream');
        $this->header('Content-Disposition', 'attachment; filename="' . ($filename ?? basename($filePath)) . '"');
        $this->content = file_get_contents($filePath);
        return $this;
    }

    public function redirect($url, $status = 302)
    {
        $this->setStatus($status);
        $this->header('Location', $url);
        return $this;
    }
}