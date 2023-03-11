<?php
namespace app\core\form;

use app\core\Model;

class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';
    public const TYPE_EMAIL = 'email';


    public string $type;
    public Model $model;
    public string $attribute;

    public function __construct(Model $model, $attribute)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }

    public function passwordField(){
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }


    public function renderInput(): string
    {
        $stringInput = '<input type="%s" class="form-control%s" value="%s" name="%s">';

        return sprintf($stringInput,
            $this->type,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->model->{$this->attribute} ?? '',
            $this->attribute,
        );
    }
}