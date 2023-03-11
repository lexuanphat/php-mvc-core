<?php

namespace app\core\form;

use app\core\Model;

abstract class BaseField
{

    public Model $model;
    public string $attribute;
    public function __construct(Model $model, $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }
    abstract public function renderInput(): string;

    public function __toString()
    {
        return sprintf('<div class="mb-3">
            <label for="" class="form-label">%s</label>
            %s
            <div class="invalid-feedback">
            %s
            </div>
        </div>',

            $this->model->labels()[$this->attribute], // Label
            $this->renderInput(),
            $this->model->getFristError($this->attribute),
        );
    }
}