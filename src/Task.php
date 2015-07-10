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
 
}
