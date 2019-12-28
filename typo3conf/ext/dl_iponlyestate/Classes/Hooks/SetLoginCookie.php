<?php
    namespace DanLundgren\DlIponlyestate\Hooks;
    class SetLoginCookie {
    	public function setLoginCookie($funcRef='', $params='', $that='') {
    		$u = $GLOBALS['TSFE']->fe_user->user['username']; 
    		setcookie("user", $u, time()+28800, '/');
    	}
        public function delLoginCookie() {
            setcookie("user", "", time() - 3600); 
        }
    }