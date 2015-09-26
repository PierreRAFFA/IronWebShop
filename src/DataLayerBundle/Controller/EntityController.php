<?php

namespace DataLayerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EntityController extends Controller
{
    ////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////// UTILS
    /**
     * Populates the entity from the parameters
     * This method ignores parameters which does not match the entity.
     *
     * @param $entity
     * @param $parameters array of parameters
     */
    protected function _updateEntity($entity, $parameters)
    {
        foreach($parameters as $parameterName=>$parameterValue)
        {
            $methodName = sprintf("set%s", ucfirst($parameterName) );
            $this->get("logger")->info($methodName);

            if ( method_exists($entity,$methodName))
            {
                $entity->$methodName($parameterValue);
            }
        }
    }
}