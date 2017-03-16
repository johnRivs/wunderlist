<?php namespace JohnRivs\Wunderlist;

use GuzzleHttp\json_decode;

trait Authorization {

    /**
     * The URL where the user will be redirected to
     * in order to authorize your app.
     *
     * @param  string $state A random string that you'll need to store and check later.
     * @param  string $callbackUrl The URL where the user will be sent after authorizing your app.
     * @return string
     */
    public function authUrl($state, $callbackUrl)
    {
        return 'https://www.wunderlist.com/oauth/authorize?client_id=' .
               $this->clientId .
               '&redirect_uri=' .
               $callbackUrl .
               '&state=' .
               $state;
    }

    /**
     * Get the user's access token.
     *
     * @param  string $code A string provided by Wunderlist in the earlier step.
     * @return string
     */
    public function getAuthToken($code)
    {
        return json_decode($this->http->post('https://www.wunderlist.com/oauth/access_token', [
            'form_params' => [
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
                'code'          => $code
            ],
            'verify' => false
        ])->getBody())->access_token;
    }

}
