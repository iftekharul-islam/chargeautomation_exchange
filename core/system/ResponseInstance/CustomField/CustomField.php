<?php


namespace Core\System\ResponseInstance\CustomField;


use Core\System\ResponseInstance\SetClassAttribute;

class CustomField
{
    use SetClassAttribute {
        getAttributeValue as protected getAttributeValueFromTrait;
    }

    public function __construct($data)
    {
        $this->setAttributes($data);
    }
    public $id;
    public $value;
    public $entity_id;
    public $entity_type; // Booking|Property
    public $field_definition_id;

}