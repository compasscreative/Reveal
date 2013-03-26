<?php

namespace Reinink\Reveal;

class JSONResponse extends Response
{
    /**
     * The JSON data array.
     *
     * @var array
     */
    public $data;

    /**
     * Create a new JSON instance.
     *
     * @param  string $content
     * @param  array  $headers
     * @return void
     */
    public function __construct($data, $code = 200, $headers = array())
    {
        $this->data = $data;
        $this->code = $code;
        $this->headers = $headers;
    }

    /**
     * Send the headers and content of the response to the browser.
     *
     * @return void
     */
    public function send()
    {
        $this->headers['Content-Type'] = 'text/plain';

        $this->content = json_encode($this->data);

        parent::send();
    }
}
