<?php
namespace Instakler\Transformer;

/**
 * Class Headers
 * @package Instakler\Transformer
 */
class Headers
{
    private $headers;

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return mixed
     */
    public function getRateLimit()
    {
        if (isset($this->headers['x-ratelimit-limit']) && is_array($this->headers['x-ratelimit-limit'])) {
            return $this->headers['x-ratelimit-limit'][0];
        }
    }

    /**
     * @return mixed
     */
    public function getRateLimitRemaining()
    {
        if (isset($this->headers['x-ratelimit-remaining']) && is_array($this->headers['x-ratelimit-remaining'])) {
            return $this->headers['x-ratelimit-remaining'][0];
        }
    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        if (isset($this->headers['Connection']) && is_array($this->headers['Connection'])) {
            return $this->headers['Connection'][0];
        }
    }

    /**
     * @return mixed
     */
    public function getContentType()
    {
        if (isset($this->headers['Content-Type']) && is_array($this->headers['Content-Type'])) {
            return $this->headers['Content-Type'][0];
        }
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        if (isset($this->headers['Date']) && is_array($this->headers['Date'])) {
            return $this->headers['Date'][0];
        }
    }

    /**
     * @return mixed
     */
    public function getContentLanguage()
    {
        if (isset($this->headers['Content-Language']) && is_array($this->headers['Content-Language'])) {
            return $this->headers['Content-Language'][0];
        }
    }

    /**
     * @return mixed
     */
    public function getCookies()
    {
        if (is_array($this->headers['Set-Cookie'])) {
            return $this->headers['Set-Cookie'];
        }
    }

}
