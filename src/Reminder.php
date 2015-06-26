<?php namespace JohnRivs\Wunderlist;

trait Reminder {

    /**
     * Show all the reminders in a list or task.
     * 
     * @param  string $entity A list or a task.
     * @param  int $entityId The id of the list or task.
     * @return array
     */
    public function getReminders($entity, $entityId)
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

        return $this->call('GET', 'reminders', $parameters);
    }
 
}
