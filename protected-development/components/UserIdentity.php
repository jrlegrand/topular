<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

	/**
	 * Authenticates a user.
	 */
	public function authenticate()
	{
		// Understand that email === username
		$user = User::model()->findByAttributes(array('email'=>$this->username));
		
		if($user === null) {
			// No user found!
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		} elseif($user->pass !== hash_hmac('sha256', $this->password, Yii::app()->params['encryptionKey'])) {
			// Invalid password!
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		} else {// Okay!
			$this->errorCode=self::ERROR_NONE;
			$this->setState('type', $user->type);
			$this->setState('city', 'chicago');
			$this->_id = $user->id;
		}
		return !$this->errorCode;
	}
	
	public function getId()
	{
		return $this->_id;
	}
}