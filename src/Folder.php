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
     * Show the revision for each folder.
     * 
     * @return array
     */
    public function getFolderRevisions()
    {
        return $this->call('GET', "folder_revisions");
    }
 
}
