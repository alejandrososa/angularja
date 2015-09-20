<?php
namespace Api;

class Sesion {
	
	public function sesion_init(){
		session_start();
		$_SESSION['uid']=uniqid('ang_');
		return  $_SESSION['uid'];
	}
	
	public function sesion_check(){
		session_start();
		if( isset($_SESSION['uid']) ) {
			return 'autentificado';
		}
	}
	
	public function sesion_exit(){
		session_id('uid');
		session_start();
		session_destroy();
		session_commit();
	}
}