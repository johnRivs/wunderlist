<?php namespace JohnRivs\Wunderlist;

trait Note {

    /**
     * Show all the notes in a list or task.
     * 
     * @param  string $entity A list or a task.
     * @param  int $entityId The id of the list or task.
     * @return array
     */
    public function getNotes($entity, $entityId)
    {
        if ($entity === 'task') {
            $parameters = [
                'query' => [
                    'task_id' => $entityId
                ]
            ];
        } elseif ($entity === 'list') {
            $parameters = [
                'query' => [
                    'list_id' => $entityId
                ]
            ];
        }

        return $this->call('GET', 'notes', $parameters);
    }

    /**
     * Show a note.
     * 
     * @param  int $noteId The id of the note.
     * @return array
     */
    public function getNote($noteId)
    {
        return $this->call('GET', "notes/{$noteId}");
    }
 
}
