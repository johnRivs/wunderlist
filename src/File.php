<?php namespace JohnRivs\Wunderlist;

trait File {

    /**
     * Show all the files from a list or from a task.
     *
     * @param  array $attributes
     * @return array
     */
    public function getFiles(array $attributes = [])
    {
        if (
        	!$this->requires(['task_id'], $attributes) &&
        	!$this->requires(['list_id'], $attributes)
        ) {
	        throw new Exception("The 'task_id' or 'list_id' attributes is required.");
        }

        return $this->call('GET', 'files', ['query' => $attributes]);
    }

    /**
     * Get a specific file.
     *
     * @param  int $fileId The id of the file.
     * @return array
     */
    public function getFile($fileId)
    {
        return $this->call('GET', "files/{$fileId}");
    }

    /**
     * Create a new file for a list.
     *
     * @param  array $attributes
     * @return array
     */
    public function createFile(array $attributes = [])
    {
        $this->requires(['upload_id', 'task_id'], $attributes);

        return $this->call('POST', 'files', ['json' => $attributes]);
    }

    /**
     * Delete a file.
     *
     * @param  int $fileId The id of the file.
     * @return array
     */
    public function deleteFile($fileId)
    {
        $attributes['revision'] = $this->getFile($taskId)['revision'];

        $this->requires(['revision'], $attributes);

        $this->call('DELETE', "files/{$taskId}", ['query' => $attributes]);

        return $this->getStatusCode();
    }

}
