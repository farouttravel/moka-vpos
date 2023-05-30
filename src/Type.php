<?php

namespace Vpos;

define('PARAMETERS_LOOK_UP', include 'blueprints.php');

class Type
{
    private $name;
    private $action;
    private $parameters;

    public function __construct()
    {
        $this->name = array_key_exists('t', $_GET) ? $_GET['t'] : '3DPayHosting';
        $this->parameters = [];
        if (!isset(PARAMETERS_LOOK_UP[$this->name]))
            throw new \Exception('Blueprint records not found!', 500);

        $this->action = env($this->getShapedParameterName('formAction'));
        foreach (PARAMETERS_LOOK_UP[$this->name]['parameters'] as $parameterGroupName => $parameterGroup) {
            foreach ($parameterGroup as $parameter) {
                $envName = $this->getShapedParameterName($parameterGroupName . $parameter['name']);

                if (array_key_exists('parameters', $parameter)) {
                    foreach ($parameter['parameters'] as $subParameter) {
                        $envName = $this->getShapedParameterName(
                            $parameterGroupName . $parameter['name'] . $subParameter
                        );
                        $this->parameters[$parameter['name'] . $subParameter] = !empty(env($envName)) ? env($envName) : '';
                    }

                    continue;
                }

                $this->parameters[$parameter['name']] = ! is_null($envName) ? env($envName) : '';
            }
        }
    }

    function getName() {
        return $this->name;
    }

    function getAction() {
        return $this->action;
    }

    function getParameters() {
        return $this->parameters;
    }

    private function getShapedParameterName($name)
    {
        $parameter = preg_replace('/((?:^|[A-Z])[a-z]+|3D|ID|1|2)/','_$1', $this->name . ucfirst($name));

        return ltrim(strtoupper($parameter), '_');
    }
}