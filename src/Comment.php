<?php namespace JohnRivs\Wunderlist;

trait Comment {

    /**
     * Show all the comments in a list or task.
     * 
     * @param  string $entity A list or a task.
     * @param  array $attributes
     * @return array
     */
    public function getComments($entity, array $attributes = [])
    {
        $this->requires(["{$entity}_id"], $attributes);

        return $this->call('GET', 'task_comments', ['query' => $attributes]);
    }

    /**
     * Show a comment.
     * 
     * @param  int $commentId The id of the comment.
     * @return array
     */
    public function getComment($commentId)
    {
        return $this->call('GET', "task_comments/{$commentId}");
    }

    /**
     * Create a new comment for a task.
     * 
     * @param  array $attributes
     * @return array
     */
    public function createComment(array $attributes = [])
    {
        $this->requires(['task_id', 'text'], $attributes);

        return $this->call('POST', 'task_comments', ['json' => $attributes]);
    }
 
}
