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
     * @param null $http_response_code
     */
    public function header($string, $replace = true, $http_response_code = null)
    {
        header($string, $replace, $http_response_code);
    }

    /**
     * @param $content
     */
    public function content($content)
    {
        echo $content;
    }
}
