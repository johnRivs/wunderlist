<?php namespace JohnRivs\Wunderlist;

trait Reminder {

    /**
     * Show all the reminders in a list or task.
     * 
     * @param  string $entity A list or a task.
     * @param  array $attributes
     * @return array
     */
    public function getReminders($entity, array $attributes = [])
    {
        $this->requires(["{$entity}_id"], $attributes);

        return $this->call('GET', 'reminders', ['query' => $attributes]);
    }
 
}
