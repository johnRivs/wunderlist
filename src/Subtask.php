<?php namespace JohnRivs\Wunderlist;

trait Subtask {

    /**
     * Show all the subtasks in a list or task.
     * 
     * @param  string $entity A list or a task.
     * @param  int $entityId The id of the list or task.
     * @return array
     */
    public function getSubtasks($entity, $entityId)
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

        return $this->call('GET', 'subtasks', $parameters);
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
