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
 
}
