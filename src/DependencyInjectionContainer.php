<?php namespace MW;

/**
 * Class DependencyInjectionContainer
 * @package MW
 */
class DependencyInjectionContainer
{
    /**
     * @var array
     */
    private $services = [];

    /**
     * @param $name
     * @param callable $callable
     * @return bool
     */
    public function addService($name, callable $callable)
    {
        $this->services[$name] = [
            'creationLogic' => $callable,
            'loaded' => false
        ];
        return true;
    }

    /**
     * @param $name
     * @return null|Object
     */
    public function getService($name)
    {
        if ($this->hasService($name))
        {
            if ($this->services[$name]['loaded'] === false) {
                return $this->getNewService($name);
            }
            return $this->services[$name]['loaded'];
        }
        
        return null;
    }

    public function hasService($name) {
        return array_key_exists($name, $this->services);   
    }
    /**
     * @param $name
     * @return null|Object
     */
    public function getNewService($name)
    {
        if ($this->hasService($name))
        {
            $this->services[$name]['loaded'] = $this->services[$name]['creationLogic']();
            return $this->services[$name]['loaded'];
        }

        return null;
    }
}
