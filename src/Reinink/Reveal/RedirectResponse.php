<?php

namespace Reinink\Reveal;

class RedirectResponse extends Response
{
    /**
     * The redirect url.
     *
     * @var array
     */
    public $data;

    /**
     * Create a new Redirect instance.
     *
     * @param  string $content
     * @param  array  $headers
     * @return void
     */
    public function __construct($url, $code = 200, $headers = array())
    {
        $this->url = $url;
        $this->code = $code;
        $this->headers = $headers;
    }

    /**
     * Send the headers of the response to the browser.
     *
     * @return void
     */
    public function send()
    {
        $this->headers['Location'] = $this->url;

        parent::send();

        exit;
    }
}
