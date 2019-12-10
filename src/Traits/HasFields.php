<?php


namespace Tools4Schools\Graph\Traits;


use Tools4Schools\Graph\Contracts\Schema\Types\Type;


trait HasFields
{
    protected $fieldMap = null;

    protected function buildFieldMap()
    {
        if (is_null($this->fieldMap)) {
            foreach ($this->fields() as $field) {
                $this->fieldMap[$field->name()] = $field;
            }
        }
    }


    public function hasField(string $fieldName):bool
    {
        $this->buildFieldMap();

        return isset($this->fieldMap[$fieldName]);
    }


    /**
     * @param string $fieldName
     * @param bool $throwError
     * @return Type
     * @throws \Exception
     */
    public function getField(string $fieldName,bool $throwError = false):?Type
    {
        $this->buildFieldMap();

        if ($this->hasField($fieldName)) {
            return $this->fieldMap[$fieldName];
        }

        if ($throwError) {
            throw new \Exception('Field ' . $fieldName . ' Does not exist on this type');
        }

        return null;
    }


}