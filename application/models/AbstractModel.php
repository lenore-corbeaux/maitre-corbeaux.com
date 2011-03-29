<?php
/**
 * Base class for models
 * Provides some basic methods for accessing data :
 * - Magic methods __get and __set
 * - populate and toArray methods for working with arrays
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Model
 */
abstract class MaitreCorbeaux_Model_AbstractModel
{
    /**
     * Populates data, if any
     *
     * @param array $data
     */
    public function __construct(array $data = null)
    {
        if (null !== $data) {
            $this->populate($data);
        }
    }

    /**
     * Returns model data into an array
     * Use class reflection to returns every properties of the model
     *
     * @return array
     */
    public function toArray()
    {
        $data = array();
        $reflection = new Zend_Reflection_Class($this);
        $methods = $reflection->getMethods();

        foreach ($methods as $method) {
            $methodName = $method->name;
            
            if (substr($methodName, 0, 3) == 'get') {
                $key = lcfirst(substr($methodName, 3));
                $data[$key] = $this->$methodName();
            }
        }

        return $data;
    }

    /**
     * Fill model with the data
     *
     * @param array $data
     * @return MaitreCorbeaux_Model_AbstractModel
     */
    public function populate($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    /**
     *
     * @throws MaitreCorbeaux_Model_Exception
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        $methodName = 'get' . ucfirst($name);

        if (!method_exists($this, $methodName)) {
            throw new MaitreCorbeaux_Model_Exception(
                'Unexistent property to get : ' . $name
            );
        }

        return $this->$methodName();
    }

    /**
     *
     * @throws MaitreCorbeaux_Model_Exception
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        $methodName = 'set' . ucfirst($name);

        if (!method_exists($this, $methodName)) {
            throw new MaitreCorbeaux_Model_Exception(
                'Unexistent property to set : ' . $name
            );
        }

        return $this->$methodName($value);
    }
}