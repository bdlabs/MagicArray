<?php

namespace BlueDiamond\MagicArray;

use \Exception;

/**
 * Class MagicArray
 */
class MagicArray
{
    private $array = [];
    private $index = null;
    private $path = [];

    /**
     * MagicArray constructor.
     *
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        $this->array = $array;
        $this->r();
    }

    /**
     * @return $this
     */
    public function r(): self
    {
        $this->index = &$this->array;
        $this->path = [];

        return $this;
    }

    /**
     * @param $name
     * @param null $value
     *
     * @return $this
     */
    public function eval($name, $value = null): self
    {
        if ($value) {
            return $this->__set($name, $value);
        }

        return $this->__get($name);
    }

    /**
     * @param string $callName
     * @param mixed $values
     *
     * @return $this
     * @throws Exception
     */
    public function __call(string $callName, $values)
    {
        $this->setValue($callName, $values[0] ?? []);

        return $this;
    }

    /**
     * @param string $varName
     *
     * @return $this
     */
    public function __get(string $varName): self
    {
        $this->path[] = $varName;
        if (isset($this->index[$varName])) {
            $this->index = &$this->index[$varName];
        }

        return $this;
    }

    /**
     * @param string $varName
     * @param mixed $val
     *
     * @return $this
     * @throws Exception
     */
    public function __set(string $varName, $val): self
    {
        $this->setValue($varName, $val ?? []);
        $this->setIndex(implode('.', $this->path));

        return $this;
    }

    /**
     * @return array|mixed|null
     */
    public function value()
    {
        return $this->get(implode('.', $this->path));
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->array;
    }

    /**
     * @param string $path
     * @param mixed $value
     * @param bool $force
     *
     * @return $this
     */
    final public function set(string $path, $value, bool $force = false): self
    {
        $pathList = explode('.', $path);
        $dir = &$this->array;
        foreach ($pathList as $pathNow) {
            if ($force && !isset($dir[$pathNow])) {
                $dir[$pathNow] = [];
            }
            if (isset($dir[$pathNow])) {
                $dir = &$dir[$pathNow];
                continue;
            }
        }
        $dir = $value;

        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @throws Exception
     */
    protected function setValue(string $name, $value)
    {
        if (isset($this->index[$name])) {
            if (gettype($value) !== gettype($this->index[$name])) {
                $message = sprintf(
                    "Attempting to assign type '%s' to type '%s'",
                    gettype($value),
                    gettype($this->index[$name])
                );
                throw new Exception($message);
            }
            $this->index[$name] = $value;
        }
    }

    /**
     * @param string $path
     *
     * @return array|mixed|null
     */
    final public function get(string $path)
    {
        $pathList = explode('.', $path);
        $dir = &$this->array;
        foreach ($pathList as $pathNow) {
            if (isset($dir[$pathNow])) {
                $dir = &$dir[$pathNow];
                continue;
            }

            return null;
        }

        return $dir;
    }

    /**
     * @param string $path
     */
    final protected function setIndex(string $path)
    {
        $pathList = explode('.', $path);
        array_pop($pathList);
        $this->index = &$this->array;
        foreach ($pathList as $pathNow) {
            if (isset($this->index[$pathNow])) {
                $this->index = &$this->index[$pathNow];
                continue;
            }
        }
    }
}
