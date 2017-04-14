<?php

namespace App\Http;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\ClientException;

class Gravatar
{
    /**
     * Gravatar's base URL.
     *
     * @var string
     */
    const GRAVATAR_URL = 'http://gravatar.com/avatar';

    /**
     * HTTP handler.
     *
     * @var Guzzle
     */
    private $guzzle;

    /**
     * The email to query in Gravatar.
     *
     * @var string
     */
    private $email;

    /**
     * Create a new Gravatar instance.
     *
     * @param  Guzzle  $guzzle
     * @return Gravatar
     */
    public function __construct(Guzzle $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * The email we'll take the gravatar image from.
     *
     * @parma  string  $email
     * @return Gravatar
     */
    public function email($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Download the image.
     *
     * @return string
     */
    public function download()
    {
        try {
            $url = '/uploads/avatars/' . $hash = md5($this->email) . '.jpg';

            $this->save($hash, $url);
        } catch (ClientException $e) {
            return null;
        }

        return $url;
    }

    /**
     * Build the gravatar download URL.
     *
     * @param  string  $hash
     * @return string
     */
    private function url($hash)
    {
        return static::GRAVATAR_URL . '/' . $hash . '?' . http_build_query([
            'd' => '404'
        ]);
    }

    /**
     * Save the image to the given folder.
     *
     * @param  string  $hash
     * @param  string  $destination
     * @return void
     */
    private function save($hash, $destination)
    {
        $url = $this->url($hash);

        $this->guzzle->get($url, ['sink' => public_path($destination)]);
    }
}