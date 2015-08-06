<?php namespace JohnRivs\Wunderlist;

trait Subtask {

    /**
     * Show all the subtasks in a list or task.
     *
     * @param  string $entity A list or a task.
     * @param  array $attributes
     * @return array
     */
    public function getSubtasks($entity, array $attributes = [])
    {
        $this->requires(["{$entity}_id"], $attributes);

        return $this->call('GET', 'subtasks', ['query' => $attributes]);
    }

    /**
     * Show a subtask by id.
     *
     * @param  int $subtaskId The id of the subtask.
     * @return array
     */
    public function getSubtask($subtaskId)
    {
        return $this->call('GET', "subtasks/{$subtaskId}");
    }

    /**
     * Create a new subtask of a task.
     *
     * @param  array $attributes
     * @return array
     */
    public function createSubtask(array $attributes = [])
    {
        $this->requires(['task_id', 'title'], $attributes);

        return $this->call('POST', 'subtasks', ['json' => $attributes]);
    }

    /**
     * Update a subtask.
     *
     * @param  int $subtaskId The id of the subtask.
     * @param  array $attributes
     * @return array
     */
    public function updateSubtask($subtaskId, array $attributes = [])
    {
        $attributes['revision'] = $this->getSubtask($subtaskId)['revision'];

        $this->requires(['revision'], $attributes);

        return $this->call('PATCH', "subtasks/{$subtaskId}", ['json' => $attributes]);
    }

    /**
     * Delete a subtask.
     *
     * @param  int $subtaskId The id of the subtask.
     * @return array
     */
    public function deleteSubtask($subtaskId)
    {
        $attributes['revision'] = $this->getSubtask($subtaskId)['revision'];

        $this->requires(['revision'], $attributes);

        $this->call('DELETE', "subtasks/{$subtaskId}", ['query' => $attributes]);

        return $this->getStatusCode();
    }

}
