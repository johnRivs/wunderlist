<?php namespace JohnRivs\Wunderlist;

trait Task {

    /**
     * Show all the tasks from a list.
     * 
     * @param  int $listId The id of the list.
     * @param  string $completed Return only completed tasks.
     * @return array
     */
    public function getTasks($listId, $completed = 'false')
    {
        return $this->call('GET', 'tasks', [
            'query' => [
                'list_id'   => $listId,
                'completed' => $completed
            ]
        ]);
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
