<?php

namespace Reinink\Reveal;

class FileResponse extends Response
{
    /**
     * The file path.
     *
     * @var string
     */
    public $path;

    /**
     * The file mime type.
     *
     * @var string
     */
    public $mime;

    /**
     * The file name.
     *
     * @var string
     */
    public $name;

    /**
     * The file download status.
     *
     * @var bool
     */
    public $download;

    /**
     * Create a new File instance.
     *
     * @param  string $content
     * @param  array  $headers
     * @return void
     */
    public function __construct($path, $mime = null, $name = '', $download = false, $code = 200, $headers = array())
    {
        $this->path = $path;
        $this->mime = $mime;
        $this->name = $name;
        $this->download = $download;
        $this->code = $code;
        $this->headers = $headers;
    }

    public function send()
    {
        $this->headers['Content-Type'] = $this->mime;
        $this->headers['Content-Disposition'] = $this->download ? 'attachment; filename=' . $this->name : 'inline; filename=' . $this->name;

        parent::send();

        readfile($this->path);

        exit;
    }
}
