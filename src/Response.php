<?php namespace MW;

/**
 * Class Response
 * @package MW
 */
class Response
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $status = 200;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var array
     */
    private $statuses = [
        200 => 'OK',
        404 => 'Not Found'
    ];

    public function __construct(Output $output)
    {
        $this->output = $output;
    }
    
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
    
    public function setStatus($status)
    {
        if (array_key_exists($status, $this->statuses)) {
            $this->status = $status;
        }
        return $this;
    }
    
    public function setHeaders(array $headers = [])
    {
        $this->headers = $headers;
        return $this;
    }
    
    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();
    }
    
    private function sendHeaders()
    {
        foreach ($this->headers as $key => $value) {
            $this->output->header($key.': '.$value, false, $this->status);
        }
        $this->output->header(sprintf('HTTP/1.0 %s %s', $this->status, $this->statuses[$this->status]), true, $this->status);

    }
    
    private function sendContent()
    {
        $this->output->content($this->content);
    }
}
