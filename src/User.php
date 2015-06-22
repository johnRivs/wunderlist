<?php namespace JohnRivs\Wunderlist;

trait User {

    /**
     * Show the currently logged in user.
     * 
     * @return array
     */
    public function getCurrentUser()
    {
        return $this->call('GET', 'user');
    }

    /**
     * Show the users this user can access.
     * 
     * @return array
     */
    public function getUsers()
    {
        return $this->call('GET', 'users');
    }
 
}
