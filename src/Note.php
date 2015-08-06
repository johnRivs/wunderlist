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

    /**
     * Create a new note for a task.
     *
     * @param  array $attributes
     * @return array
     */
    public function createNote(array $attributes = [])
    {
        $this->requires(['task_id', 'content'], $attributes);

        return $this->call('POST', 'notes', ['json' => $attributes]);
    }

    /**
     * Update a note.
     *
     * @param  int $noteId The id of the note.
     * @param  array $attributes
     * @return array
     */
    public function updateNote($noteId, array $attributes = [])
    {
        $attributes['revision'] = $this->getNote($noteId)['revision'];

        $this->requires(['revision', 'content'], $attributes);

        return $this->call('PATCH', "notes/{$noteId}", ['json' => $attributes]);
    }

    /**
     * Delete a note.
     *
     * @param  int $noteId The id of the note.
     * @return array
     */
    public function deleteNote($noteId)
    {
        $attributes['revision'] = $this->getNote($noteId)['revision'];

        $this->requires(['revision'], $attributes);

        $this->call('DELETE', "notes/{$noteId}", ['query' => $attributes]);

        return $this->getStatusCode();
    }

    /**
     * Deletes all notes in a list or task.
     *
     * @param  string $entity A list or a task.
     * @param  array $attributes
     * @return int
     */
    public function deleteNotes($entity, array $attributes = [])
    {
        $this->requires(["{$entity}_id"], $attributes);

        $notes = $this->getNotes($entity, $attributes);

        foreach ($notes as $note) {
            $this->deleteNote($note['id']);
        }

        return $this->getStatusCode();
    }

}
