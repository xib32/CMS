<?php

class User
{
	private $_db;
	private $_data;
	private $_sessionName = 'user';
	private $_cookieName = 'hash';
	private $_cookieExpire = 60*60*24*7;
	private $_isLoggedIn = false;
	
	public function __construct()
	{
		$this->_db = DB::getInstance();
		if(Cookie::exists($this->_cookieName)) {
            $cookieValue = (Cookie::get($this->_cookieName));
            $user_id = $this->findUser($cookieValue);
            if($user_id) {
                if($this->find($user_id)) {
                    $this->_isLoggedIn = true;
                } else {
                    $this->logout();
                }
            } else {
				Cookie::delete($this->_cookieName);
			}
        } 
		if(Session::exists($this->_sessionName)) {
            $user_id = Session::get($this->_sessionName);
            if($this->find($user_id)) {
                $this->_isLoggedIn = true;
            } else {
                $this->logout();
            }
        }
    }
	
    private function findUser($cookieValue = null)
    {
        if($cookieValue) {
            $data = $this->_db->get('*', 'sessions', array('hash', '=', $cookieValue));
            if($data->count()) {
                $this->_data = $data->first();
                return $this->data()->user_id;
            }
        }
        return false;
    }
	
	public function create($fields = array())
	{
		if($fields) {
			if( ! $this->_db->insert('users', $fields)) {
				throw new Exception ('There was a problem creating an account.');
			}
			return true;
		}
		
		die('Mising data for insert');
	}
	
	public function login($username = null, $password = null, $remember = false)
	{
		if(!$username && !$password && $this->exists()) {

			Session::put($this->_sessionName, $this->data()->id);
			
		} else {
			if($this->find($username)) {
				if(password_verify($password, $this->data()->password)/*Hash::make($password, $this->data()->salt) === $this->data()->password*/) {
					Session::put($this->_sessionName, $this->data()->id);
					if($remember) {
						$hash = Hash::uniqeid();
						Cookie::put($this->_cookieName, $hash, $this->_cookieExpire);
						$this->_db->insert('sessions', array(
							'hash'		=> $hash,
							'user_id'	=> $this->data()->id
						));
					}
					return true;
				}
			} else {
				Session::flash('danger', 'Username don\'t exists. ');
				Redirect::to('login');
			}
				
		}
		
		return false;
	}
	
	public function find($user = null)
	{
		if($user) {
			$field = (is_numeric($user)) ? 'id' : 'username';
			$data = $this->_db->get('*', 'users', array($field, '=', $user));
			
			if($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		
		return false;
	}
	
	public function logout()
	{
		$this->_db->delete('sessions', array('user_id', '=', $this->data()->id));
		
		Cookie::delete($this->_cookieName);
		
		session_destroy();
		
		return true;
	}
	
	public function exists()
	{
		return (!empty($this->_data)) ? true : false;
	}
	
	public function data()
	{
		return $this->_data;
	}
	
	public function check()
	{
		return $this->_isLoggedIn;
	}
}
