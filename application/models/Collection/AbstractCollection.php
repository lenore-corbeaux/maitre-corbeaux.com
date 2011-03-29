<?php
/**
 * Abstract class for model collections
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Model
 * @see Countable
 * @see SeekableIterator
 * @see ArrayAccess
 */
abstract class MaitreCorbeaux_Model_Collection_AbstractCollection
implements Countable, SeekableIterator, ArrayAccess
{
    /**
     * Array for storing models in the collection
     *
     * @var array
     */
    protected $_models = array();

    /**
     * Model class name for ensuring data in the collection is valid
     *
     * @var string
     */
    protected $_modelClassName = null;

    /**
     * Add a model to the collection
     *
     * @throws MaitreCorbeaux_Model_Collection_Exception
     * @param mixed $model
     * @param mixed $key
     * @return MaitreCorbeaux_Model_Collection_AbstractCollection
     */
    public function add($model, $key = null)
    {
        if (!$this->elementIsValid($model)) {
            throw new MaitreCorbeaux_Model_Collection_Exception(
                'Incorrect data added to the collection, expecting '
                . $this->_modelClassName . ', ' . get_class($model) . ' given'
            );
        }

        if (null === $key) {
            $this->_models[] = $model;
        } else {
            $this->_models[$key] = $model;
        }

        return $this;
    }

    /**
     * Remove a model from the collection
     *
     * @throws MaitreCorbeaux_Model_Collection_Exception
     * @param MaitreCorbeaux_Model_AbstractModel $model
     * @return MaitreCorbeaux_Model_Collection_AbstractCollection
     */
    public function remove(MaitreCorbeaux_Model_AbstractModel $model)
    {
        $somethingRemoved = false;

        foreach ($this as $key => $value) {
            if ($value === $model) {
                unset($this[$key]);
                $somethingRemoved = true;
            }
        }

        if (!$somethingRemoved) {
            throw new MaitreCorbeaux_Model_Collection_Exception(
                'Tried to remove an unexistent model'
            );
        }

        return $this;
    }

    /**
     * Reset the collection
     *
     * @return MaitreCorbeaux_Model_Collection_AbstractCollection
     */
    public function clear()
    {
        $this->_models = array();
        return $this;
    }

    /**
     * Merge two collections together
     * Do NOT preserves indexes
     *
     * @param MaitreCorbeaux_Model_Collection_AbstractCollection $collection
     * @return MaitreCorbeaux_Model_Collection_AbstractCollection
     */
    public function merge(
        MaitreCorbeaux_Model_Collection_AbstractCollection $collection
    )
    {
        foreach ($collection as $element) {
            $this->add($element);
        }

        return $this;
    }

    /**
     * Check if the given element is valid
     *
     * @param MaitreCorbeaux_Model_AbstractModel $element
     * @return bool
     */
    public function elementIsValid($element)
    {
        return $element instanceof $this->_modelClassName;
    }

    /**
     *
     * @return int
     * @see Countable::count()
     */
    public function count()
    {
        return count($this->_models);
    }

    /**
     * 
     * @param int $position
     * @return void
     * @see SeekableIterator::seek()
     */
    public function seek($position)
    {
        $this->rewind();
        $currentPosition = 0;

        while ($currentPosition < $position && $this->valid()) {
            $this->next();
            ++$currentPosition;
        }

        if (!$this->valid()) {
            throw new MaitreCorbeaux_Model_Collection_Exception(
                'Invalid position'
            );
        }
    }

    /**
     *
     * @return mixed
     * @see SeekableIterator::current()
     */
    public function current()
    {
        return current($this->_models);
    }

    /**
     *
     * @return mixed
     * @see SeekableIterator::key()
     */
    public function key()
    {
        return key($this->_models);
    }

    /**
     *
     * @return mixed
     * @see SeekableIterator::next()
     */
    public function next()
    {
        return next($this->_models);
    }

    /**
     *
     * @return void
     * @see SeekableIterator::rewind()
     */
    public function rewind()
    {
        reset($this->_models);
    }

    /**
     *
     * @return bool
     * @see SeekableIterator::valid()
     */
    public function valid()
    {
        return false !== $this->current();
    }

    /**
     *
     * @param mixed $offset
     * @return bool
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists($offset)
    {
        return isset($this->_models[$offset]);
    }

    /**
     *
     * @param mixed $offset
     * @return mixed
     * @see ArrayAccess::offsetGet()
     */
    public function offsetGet($offset)
    {
        return $this->_models[$offset];
    }

    /**
     *
     * @param mixed $offset
     * @param mixed $value
     * @return void
     * @see ArrayAccess::offsetSet()
     */
    public function offsetSet($offset, $value)
    {
        $this->add($value, $offset);
    }

    /**
     *
     * @param mixed $offset
     * @return void
     * @see ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset)
    {
        unset($this->_models[$offset]);
    }
}