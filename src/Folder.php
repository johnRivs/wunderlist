<?php namespace JohnRivs\Wunderlist;

trait Folder {

    /**
     * Show all the folders a user has access to.
     *
     * @return array
     */
    public function getFolders()
    {
        return $this->call('GET', "folders");
    }

    /**
     * Show a folder.
     *
     * @param  int $folderId The id of the list.
     * @return array
     */
    public function getFolder($folderId)
    {
        return $this->call('GET', "folders/{$folderId}");
    }

    /**
     * Create a folder.
     *
     * @param  array $attributes
     * @return array
     */
    public function createFolder(array $attributes = [])
    {
        $this->requires(['title', 'list_ids'], $attributes);

        return $this->call('POST', 'folders', ['json' => $attributes]);
    }

    /**
     * Update a folder.
     *
     * @param  int $folderId The id of the folder.
     * @param  array $attributes
     * @return array
     */
    public function updateFolder($folderId, array $attributes = [])
    {
        $attributes['revision'] = $this->getFolder($folderId)['revision'];

        $this->requires(['revision'], $attributes);

        return $this->call('PATCH', "folders/{$folderId}", ['json' => $attributes]);
    }

    /**
     * Delete a folder.
     *
     * @param  int $folderId The id of the folder.
     * @return array
     */
    public function deleteFolder($folderId)
    {
        $attributes['revision'] = $this->getFolder($folderId)['revision'];

        $this->requires(['revision'], $attributes);

        $this->call('DELETE', "folders/{$folderId}", ['query' => $attributes]);

        return $this->getStatusCode();
    }

    /**
     * Show the revision for each folder.
     *
     * @return array
     */
    public function getFolderRevisions()
    {
        return $this->call('GET', "folder_revisions");
    }

}
