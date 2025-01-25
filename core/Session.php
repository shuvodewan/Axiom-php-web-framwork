<?php
namespace Core;

use Facade\Crypt;
class Session {

    static  $instance;
    private $lifetime;
    private $expireOnClose;
    private $encrypt;
    private $cookieName;
    private $path;
    private $domain;
    private $secure;
    private $httpOnly;
    private $sameSite;


    public function __construct() {

        $this->lifetime = config('session.lifetime', 43200);
        $this->expireOnClose = config('session.expire_on_close', true);
        $this->encrypt = config('session.encrypt', false);
        $this->cookieName = config('session.cookie', 'app_session');
        $this->path = config('session.path', '/');
        $this->domain = config('session.domain', null);
        $this->secure = config('session.secure', null);
        $this->httpOnly = config('session.http_only', true);
        $this->sameSite = config('session.same_site', null);
    }


    static function setInstance($instance){
        self::$instance = $instance;
    }

    static function getInstance(){
        return self::$instance;
    }

    private function encryptAllData(){
        foreach ($_SESSION as $key => $value) {
            $_SESSION[$key] = Crypt::encrypt($value);
        }
    }

    public function startSession() {

        session_set_cookie_params($this->lifetime, $this->path, $this->domain, $this->secure, $this->httpOnly);

        session_start();

        if ($this->encrypt) {
            $this->encryptAllData();
        }

        if ($this->expireOnClose) {
            session_set_cookie_params(0);
        }

        if ($this->sameSite) {
            ini_set('session.cookie_samesite', $this->sameSite);
        }

        session_name($this->cookieName);
    }

    public function set($key, $value) {

        if ($this->encrypt) {
            $value = Crypt::encrypt($value);
        }

        $_SESSION[$key] = $value;
    }

    public function get($key) {
        $value = $_SESSION[$key];
        
        if($this->encrypt){
            return Crypt::decrypt($value);
        }

        return $value;
    }

    public function destroy() {
        session_unset();  
        session_destroy(); 
    }


    public function regenerateId() {
        session_regenerate_id(true);
    }
}