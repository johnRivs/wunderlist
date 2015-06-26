<?php namespace JohnRivs\Wunderlist;

trait Lists {

    /**
     * Show all the lists a user has access to.
     * 
     * @return array
     */
    public function getLists()
    {
        return $this->call('GET', "lists");
    }

    /**
     * Show a list.
     * 
     * @param  int $listId The id of the list.
     * @return array
     */
    public function getList($listId)
    {
        return $this->call('GET', "lists/{$listId}");
    }
 
}
