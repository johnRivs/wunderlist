<?php namespace JohnRivs\Wunderlist;

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

        // Convert the 'fallback' attribute to a string
        if (isset($attributes['fallback'])) {
            $attributes['fallback'] = var_export($attributes['fallback'], true);
        }

        $this->requires(['user_id'], $attributes);

        return $this->http->get("{$this->baseUrl}avatar", [
            'headers' => $this->getHeaders(),
            'query' => $attributes,
            'verify' => false
        ])->getEffectiveUrl();
    }
 
}
