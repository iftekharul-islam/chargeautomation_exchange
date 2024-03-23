<?php


namespace Core\System\ResponseInstance;


trait SetClassAttribute
{

    /**
     * @param array $data
     */
    private function setAttributes($data = [])
    {
        if (!empty($data)) {

            $objVars = get_object_vars($this);

            foreach ($objVars as $attribute_name => $var) {
                if (array_key_exists($attribute_name, $data)) {

                    if (is_array($this->$attribute_name)) {
                        $this->$attribute_name = array_merge($this->$attribute_name, $this->getAttributeValue($attribute_name, $data));
                    } else {
                        $this->$attribute_name = $this->getAttributeValue($attribute_name, $data);
                    }
                }
            }
        }
    }

    private function isResponseInstanceAttribute($attribute_name)
    {
        return is_object($attribute_name) &&
            str_contains(get_class($attribute_name), 'Core\System\ResponseInstance');
    }


    private function getAttributeValue($attribute_name, $data)
    {
        if ($this->isResponseInstanceAttribute($this->$attribute_name)) {
            $class = get_class($this->$attribute_name);
            return new $class($data[$attribute_name]);
        }

        return $data[$attribute_name];
    }
}