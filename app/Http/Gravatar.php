<?php

namespace App\Http;

use GuzzleHttp\Client as Guzzle;

class Gravatar
{
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
        $hash = md5($this->email);
        $url = 'http://gravatar.com/avatar/' . $hash;
        $image = "/uploads/avatars/{$hash}.jpg";

        $this->guzzle->get($url, [
            'sink' => public_path($image)
        ]);

        return $image;
    }
}