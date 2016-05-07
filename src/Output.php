<?php namespace MW;

/**
 * Class Output
 * @package MW
 */
class Output
{
    /**
     * @param $string
     * @param bool $replace
     * @param null $httpResponseCode
     */
    public function header($string, $replace = true, $httpResponseCode = null)
    {
        header($string, $replace, $httpResponseCode);
    }

    /**
     * @param $content
     */
    public function content($content)
    {
        echo $content;
    }
}
