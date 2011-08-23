<?php

class Dynamics_Callable
{
    protected $object;
    protected $method;
    protected $parameters;

    public function __construct($object, $method, array $parameters=array())
    {
        $this->object = $object;
        $this->method = $method;
        $this->parameters = $parameters;
    }

    public function call()
    {
        return call_user_func_array(array($this->object, $this->method), $this->parameters);
    }
}

# vim: et ts=4 sw=4
