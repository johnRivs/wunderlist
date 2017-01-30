<?php namespace JohnRivs\Wunderlist;

use GuzzleHttp\TransferStats;

trait Avatar {

    /**
     * Show the avatar URL of a given user.
     *
     * @param  array $attributes
     * @return string
     */
    public function getAvatar(array $attributes = [])
    {
        if ( ! isset($attributes['user_id'])) {
            $attributes['user_id'] = $this->getCurrentUser()['id'];
        }

        $this->requires(['user_id'], $attributes);

        $this->http->get("{$this->baseUrl}avatar", [
            'headers'  => $this->getHeaders(),
            'query'    => $attributes,
            'verify'   => false,
            'on_stats' => function(TransferStats $stats) use (&$url) {
                $url = $stats->getEffectiveUri();
            }
        ]);

        return (string) $url;
    }

}
