<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\ViewErrorBag;
use Spatie\Html\Elements\Button;
use Spatie\Html\Elements\Div;
use Spatie\Html\Elements\File;
use Spatie\Html\Elements\Input;
use Spatie\Html\Elements\Label;
use Spatie\Html\Elements\Select;
use Spatie\Html\Elements\Textarea;
use Spatie\Html\Html;
use Str;

class HtmlExtendedService extends Html
{

    public function label($contents = null, $for = null): Label
    {
        return parent::label($contents, $for)
            ->class(['form-label']);
    }

    public function select($name = null, $options = [], $value = null): Select
    {
        return parent::select($name, $options, $value)
            ->class('form-select')
            ->classIf($this->hasError($name), 'is-invalid');
    }

    public function text($name = null, $value = null): Input
    {
        return parent::text($name, $value)
            ->class('form-control')
            ->classIf($this->hasError($name), 'is-invalid')
            ->attribute('spellcheck', 'false');
    }

    public function search($name = null, $value = null): Input
    {
        return parent::search($name, $value)
            ->class('form-control')
            ->classIf($this->hasError($name), 'is-invalid')
            ->attribute('spellcheck', 'false');
    }

    public function file($name = null): File
    {
        return parent::file($name)
            ->class('form-control')
            ->classIf($this->hasError($name), 'is-invalid');
    }

    public function textarea($name = null, $value = null): Textarea
    {
        return parent::textarea($name, $value)
            ->class('form-control')
            ->classIf($this->hasError($name), 'is-invalid')
            ->attribute('spellcheck', 'false');
    }

    public function date($name = null, $value = null, $format = true): Input
    {
        return parent::date($name, $value, $format)
            ->class(['form-control'])
            ->classIf($this->hasError($name), 'is-invalid')
            ->attribute('spellcheck', 'false');
    }

    public function email($name = null, $value = null): Input
    {
        $testid = sprintf('%s-input', Str::slug($name));

        return parent::email($name, $value)
            ->class('form-control')
            ->classIf($this->hasError($name), 'is-invalid')
            ->attribute('spellcheck', 'false')
            ->maxlength(200)
            ->data('testid', $testid);
    }

    public function password($name = null): Input
    {
        return parent::password($name)
            ->class('form-control')
            ->classIf($this->hasError($name), 'is-invalid')
            ->attribute('spellcheck', 'false');
    }

    public function checkbox($name = null, $checked = null, $value = '1'): Input
    {
        return parent::checkbox($name, $checked, $value)
            ->class('form-check-input');
    }

    public function tel($name = null, $value = null): Input
    {
        return $this->text($name, $value)->type('tel')->maxlength(13);
    }

    public function submit($text = null): Button
    {
        return parent::submit($text ? $text : __('Submit'))
            ->class(['btn', 'btn-primary'])
            ->data('testid', 'button-submit');
    }

    public function error(?string $name): Div
    {
        return parent::div($this->firstError($name))
            ->class(['invalid-feedback', 'd-block' => $this->hasError($name)]);
    }

    protected function errors(): mixed
    {
        return app('view')->getShared()['errors'] ?? new ViewErrorBag;
    }

    protected function firstError(?string $name): ?string
    {
        if (!$name) {
            return false;
        }

        return $this->errors()->first($name);
    }

    protected function hasError(?string $name): bool
    {
        if (!$name) {
            return false;
        }

        return $this->errors()->has($name);
    }
}
