<?php
class SessionManager {
    private static $instance = null;
    
    private function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    public function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }
    
    public function has($key) {
        return isset($_SESSION[$key]);
    }
    
    public function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    public function destroy() {
        session_destroy();
        $_SESSION = array();
    }
    
    public function incrementVisitCount() {
        $count = $this->get('visit_count', 0);
        $this->set('visit_count', $count + 1);
        return $count + 1;
    }
    
    public function getVisitCount() {
        return $this->get('visit_count', 0);
    }
    
    public function isFirstVisit() {
        return $this->getVisitCount() === 1;
    }
}
?>