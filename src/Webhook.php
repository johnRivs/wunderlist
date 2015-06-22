<?php namespace JohnRivs\Wunderlist;

trait Webhook {

    /**
     * Show all the webhooks for a list.
     * 
     * @param  int $listId The id of the list.
     * @return array
     */
    public function getWebhooks($listId)
    {
        return $this->call('GET', 'webhooks', [
            'query' => [
                'list_id' => $listId
            ]
        ]);
    }

    /**
     * Create a webhook for a list.
     * 
     * @param  int $listId The id of the list.
     * @param  string $endpoint The URL called by Wunderlist.
     * @param  string $processorType
     * @param  string $configuration
     * @return array
     */
    public function createWebhook($listId, $endpoint, $processorType = 'generic', $configuration = '')
    {
        return $this->call('POST', 'webhooks', [
            'body' => [
                'list_id'        => $listId,
                'url'            => $endpoint,
                'processor_type' => $processorType,
                'configuration'  => $configuration
            ]
        ]);
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
