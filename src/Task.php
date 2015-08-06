<?php namespace JohnRivs\Wunderlist;

trait Task {

    /**
     * Show all the tasks from a list.
     *
     * @param  array $attributes
     * @return array
     */
    public function getTasks(array $attributes = [])
    {
        $this->requires(['list_id'], $attributes);

        // Convert the 'completed' attribute to a string
        if (isset($attributes['completed'])) {
            $attributes['completed'] = var_export($attributes['completed'], true);
        }

        return $this->call('GET', 'tasks', ['query' => $attributes]);
    }

    /**
     * Show a task from a list.
     *
     * @param  int $taskId The id of the task.
     * @return array
     */
    public function getTask($taskId)
    {
        return $this->call('GET', "tasks/{$taskId}");
    }

    /**
     * Create a new task for a list.
     *
     * @param  array $attributes
     * @return array
     */
    public function createTask(array $attributes = [])
    {
        $this->requires(['list_id', 'title'], $attributes);

        return $this->call('POST', 'tasks', ['json' => $attributes]);
    }

    /**
     * Update a task.
     *
     * @param  int $taskId The id of the task.
     * @param  array $attributes
     * @return array
     */
    public function updateTask($taskId, array $attributes = [])
    {
        $attributes['revision'] = $this->getTask($taskId)['revision'];

        $this->requires(['revision'], $attributes);

        return $this->call('PATCH', "tasks/{$taskId}", ['json' => $attributes]);
    }

    /**
     * Delete a task.
     *
     * @param  int $taskId The id of the task.
     * @return array
     */
    public function deleteTask($taskId)
    {
        $attributes['revision'] = $this->getTask($taskId)['revision'];

        $this->requires(['revision'], $attributes);

        $this->call('DELETE', "tasks/{$taskId}", ['query' => $attributes]);

        return $this->getStatusCode();
    }

}
