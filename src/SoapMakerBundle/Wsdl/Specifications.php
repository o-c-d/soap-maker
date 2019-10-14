<?php

namespace Ocd\SoapMakerBundle\Wsdl;

class Specifications
{
    private $client;
    private $wsdl;
    private $functions;
    private $types;
    private $parameters;
    private $specs;

    public function __construct($wsdl)
    {
        $this->loadWsdl($wsdl);
    }

    public function loadWsdl($wsdl)
    {
        $this->wsdl = $wsdl;
        $this->client = new \SoapClient($wsdl);
        $this->functions = $this->getClientFunctions();
        $this->types = $this->getClientTypes();
        $this->specs = $this->computeSpec();
    }

    private function getClientFunctions()
    {
        return $this->client->__getFunctions();
    }

    private function getClientTypes()
    {
        $clientTypes = $this->client->__getTypes();
        return $clientTypes;
    }

    private function computeSpec()
    {
        $specs=[];
        foreach ($functions as $index => $string) {
            $string = str_replace("(", " ", $string);
            $string = str_replace(")", " ", $string);
            $tab = explode(" ", trim($string));
            if (count($tab)>2) {
                $response = $tab[0];
                $method = $tab[1];
                $parameters = [];
                for ($i=2;$i<count($tab);$i++) {
                    if (substr($tab[$i], 0, 1)!=="$") {
                        $parameters[] = $tab[$i];
                    }
                }
                $specs[$method] =[];
                $specs[$method]['input'] = $parameters ;
                $specs[$method]['output'] = $response ;
            }
        }
        return $specs;
    }


    /**
     * Get the value of functions
     */ 
    public function getFunctions()
    {
        return $this->functions;
    }

    /**
     * Set the value of functions
     *
     * @return  self
     */ 
    public function setFunctions($functions)
    {
        $this->functions = $functions;

        return $this;
    }

    /**
     * Get the value of types
     */ 
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Set the value of types
     *
     * @return  self
     */ 
    public function setTypes($types)
    {
        $this->types = $types;

        return $this;
    }

    /**
     * Get the value of parameters
     */ 
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set the value of parameters
     *
     * @return  self
     */ 
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get the value of specs
     */ 
    public function getSpecs()
    {
        return $this->specs;
    }

    /**
     * Set the value of specs
     *
     * @return  self
     */ 
    public function setSpecs($specs)
    {
        $this->specs = $specs;

        return $this;
    }
}