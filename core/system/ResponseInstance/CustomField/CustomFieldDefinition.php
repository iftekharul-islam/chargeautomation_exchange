<?php


namespace Core\System\ResponseInstance\CustomField;


use Core\System\ResponseInstance\SetClassAttribute;

class CustomFieldDefinition
{
    use SetClassAttribute {
        getAttributeValue as protected getAttributeValueFromTrait;
    }

    public function __construct($data)
    {
        $this->setAttributes($data);
    }

    public $id;
    public $name;

    /**
     * @var $type
     *
     */
    public $type; //booking, property, account, owner, contact

    public $description;
    public $code;
    public $full_code;

}