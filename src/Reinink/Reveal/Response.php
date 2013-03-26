<?php

namespace Reinink\Reveal;

class Response
{
    /**
     * The content to be sent.
     *
     * @var string
     */
    public $content;

    /**
     * The HTTP code.
     *
     * @var string
     */
    public $code;

    /**
     * An array of HTTP headers.
     *
     * @var int
     */
    public $headers;

    /**
     * Create a new Response instance.
     *
     * @param  string $content
     * @param  array  $headers
     * @return void
     */
    public function __construct($content = null, $code = 200, $headers = array())
    {
        $this->content = $content;
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
        if (function_exists('http_response_code')) {
            http_response_code($this->code);
        } else {
            header(' ', true, $this->code);
        }

        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }

        if (!is_null($this->content)) {
            echo $this->content;
        }
    }

    /**
     * Create a ViewResponse using an array of values.
     *
     * @param  string       $path
     * @param  array        $values
     * @return ViewResponse
     */
    public static function view($path, $values = array())
    {
        $view = new ViewResponse($path);

        foreach ($values as $name => $value) {
            $view->$name = $value;
        }

        return $view;
    }

    /**
     * Create a JSONResponse from an array.
     *
     * @param  array        $data
     * @return JSONResponse
     */
    public static function json($data)
    {
        return new JSONResponse($data);
    }

    /**
     * Create a FileResponse for a PDF file.
     *
     * @param  string       $path
     * @param  string       $filename
     * @param  bool         $download
     * @return FileResponse
     */
    public static function pdf($path, $filename = null, $download = false)
    {
        if (!is_file($path)) {
            throw new ResponseException('PDF Not Found.', 404);
        }

        return new FileResponse($path, 'application/pdf', $filename, $download);
    }

    /**
     * Create a FileResponse for a JPG file.
     *
     * @param  string       $path
     * @param  string       $filename
     * @param  bool         $download
     * @return FileResponse
     */
    public static function jpg($path, $filename = null, $download = false)
    {
        if (!is_file($path)) {
            throw new ResponseException('Image Not Found.', 404);
        }

        return new FileResponse($path, 'image/jpeg', $filename, $download);
    }

    /**
     * Create a FileResponse for a PNG file.
     *
     * @param  string       $path
     * @param  string       $filename
     * @param  bool         $download
     * @return FileResponse
     */
    public static function png($path, $filename = null, $download = false)
    {
        if (!is_file($path)) {
            throw new ResponseException('Image Not Found.', 404);
        }

        return new FileResponse($path, 'image/png', $filename, $download);
    }

    /**
     * Create a RedirectResponse for a redirect.
     *
     * @param  string           $url
     * @return RedirectResponse
     */
    public static function redirect($url, $code = 301)
    {
        return new RedirectResponse($url, $code);
    }

    /**
     * Throw a ResponseException for a bad request.
     *
     * @param string $content
     */
    public static function badRequest($message = 'Bad Request.')
    {
        throw new ResponseException($message, 400);
    }

    /**
     * Throw a ResponseException for a unauthorized request.
     *
     * @param string $message
     */
    public static function unauthorized($message = 'Unauthorized.')
    {
        throw new ResponseException($message, 401);
    }

    /**
     * Throw a ResponseException for a unauthorized request.
     *
     * @param string $message
     */
    public static function forbidden($message = 'Forbidden.')
    {
        throw new ResponseException($message, 403);
    }

    /**
     * Throw a ResponseException for a page not found.
     *
     * @param string $message
     */
    public static function notFound($message = 'Page Not Found.')
    {
        throw new ResponseException($message, 404);
    }

    /**
     * Throw a ResponseException for a server error.
     *
     * @param string $message
     */
    public static function serverError($message = 'Internal Server Error.')
    {
        throw new ResponseException($message, 500);
    }

    /**
     * Get valid Response object from various responses.
     *
     * @param  mixed $response
     * @return void
     */
    public static function get($response)
    {
        if (is_object($response) and $response instanceof Response) {
            return $response;
        } elseif (is_string($response)) {
            return new Response($response);
        } elseif (is_bool($response) and $response === true) {
            return new Response();
        } else {
            self::notFound();
        }
    }
}
