<?php

namespace lexuanphat\phpmvc\form;

class TextareaField extends BaseField
{
    public function renderInput(): string
    {
        $strTextarea = '<textarea name="%s" class="form-control%s">%s</textarea>';
        return sprintf($strTextarea,
            $this->attribute,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->model->{$this->attribute} ?? '',
        );
    }
}