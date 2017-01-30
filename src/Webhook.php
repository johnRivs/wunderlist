<?php namespace JohnRivs\Wunderlist;

trait Webhook {

    /**
     * Show all the webhooks for a list.
     *
     * @param  array $attributes
     * @return array
     */
    public function getWebhooks(array $attributes = [])
    {
        $this->requires(['list_id'], $attributes);

        return $this->call('GET', 'webhooks', ['query' => $attributes]);
    }

    /**
     * Create a webhook for a list.
     *
     * @param  array $attributes
     * @return array
     */
    public function createWebhook(array $attributes = [])
    {
        $this->requires(['list_id', 'url', 'processor_type', 'configuration'], $attributes);

        return $this->call('POST', 'webhooks', ['json' => $attributes]);
    }

    /**
     * Delete a webhook for a list.
     *
     * @param  int $webhookId The id of the webhook.
     * @return int
     */
    public function deleteWebhook($webhookId)
    {
        $this->call('DELETE', "webhooks/{$webhookId}");

        return $this->getStatusCode();
    }

    /**
     * Deletes all webhooks for a list.
     *
     * @param  $listId The id of the list.
     * @return int
     */
    public function deleteWebhooks($listId)
    {
        $webhooks = $this->getWebhooks($listId);

        foreach ($webhooks as $webhook) {
            $this->deleteWebhook($webhook['id']);
        }

        return $this->getStatusCode();
    }

}
