<?php namespace MW;

class View
{
    private $template;
    private $data;
    private $response;
    private $templatePath;

    public function __construct(Response $response, $templatePath)
    {
        $this->response = $response;
        $this->templatePath = $templatePath;
    }

    public function template($template)
    {
        $this->template = $template;
        return $this;
    }

    public function with(array $data) {
        $this->data = $data;
        return $this;
    }

    public function render()
    {
        $this->response->setContent($this->getOutput());
        return $this->response;
    }

    private function getOutput()
    {
        ob_start();
        $this->includeTemplate($this->templatePath . DIRECTORY_SEPARATOR . $this->template, $this->data);
        return ob_get_clean();
    }

    private function includeTemplate($template, $data)
    {
        extract($data);
        include $template;
    }
}
