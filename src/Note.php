<?php namespace JohnRivs\Wunderlist;

trait Note {

    /**
     * Show all the notes in a list or task.
     * 
     * @param  string $entity A list or a task.
     * @param  array $attributes
     * @return array
     */
    public function getNotes($entity, array $attributes = [])
    {
        $this->requires(["{$entity}_id"], $attributes);

        return $this->call('GET', 'notes', ['query' => $attributes]);
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
