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

    /**
     * Create a new list.
     *
     * @param  array $attributes
     * @return array
     */
    public function createList(array $attributes = [])
    {
        $this->requires(['title'], $attributes);

        return $this->call('POST', 'lists', ['json' => $attributes]);
    }

    /**
     * Update a list.
     *
     * @param  int $listId The id of the list.
     * @param  array $attributes
     * @return array
     */
    public function updateList($listId, array $attributes = [])
    {
        $attributes['revision'] = $this->getList($listId)['revision'];

        $this->requires(['revision'], $attributes);

        return $this->call('PATCH', "lists/{$listId}", ['json' => $attributes]);
    }

    /**
     * Make a list public.
     *
     * @param  int $listId The id of the list.
     * @param  array $attributes
     * @return array
     */
    public function publishList($listId, array $attributes = [])
    {
        $attributes['revision'] = $this->getList($listId)['revision'];

        $this->requires(['revision'], $attributes);

        return $this->call('PATCH', "lists/{$listId}", ['json' => $attributes]);
    }

    /**
     * Delete a list.
     *
     * @param  int $listId The id of the list.
     * @param  array $attributes
     * @return array
     */
    public function deleteList($listId, array $attributes = [])
    {
        $attributes['revision'] = $this->getList($listId)['revision'];

        $this->requires(['revision'], $attributes);

        $this->call('DELETE', "lists/{$listId}", ['query' => $attributes]);

        return $this->getStatusCode();
    }

}
