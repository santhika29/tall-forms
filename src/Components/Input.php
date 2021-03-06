<?php


namespace Tanthammar\TallForms\Components;

use Illuminate\View\View;
use Illuminate\View\Component;
use Tanthammar\TallForms\Input as Field;
use Tanthammar\TallForms\Traits\Helpers;

class Input extends Component
{
    use Helpers;

    public Field $field;
    public bool $required;
    public string $icon_span = 'flex items-center justify-center px-2 rounded-l border border-r-0 border-gray-300 bg-gray-100 text-gray-600 sm:text-sm';

    public function __construct(Field $field)
    {
        $this->field = $field;
        $this->required = $field->required;
    }

    public function options(): array
    {
        $custom = $this->field->getAttr('input');
        $default = [
            $this->field->wire => $this->field->key,
            'name' => $this->field->key,
            'type' => $this->field->input_type,
            'autocomplete' => $this->field->autocomplete,
            'placeholder' => $this->field->placeholder,
        ];
        if (in_array($this->field->type, ['number', 'range', 'date', 'datetime-local', 'month', 'time', 'week'])) {
            $limits = [
                'min' => $this->field->min,
                'max' => $this->field->max,
                'step' => $this->field->step,
            ];

            $default = array_merge($default, $limits);
        }
        return array_merge($default, $custom);
    }

    public function class(): string
    {
        $class = "form-input block w-full shadow-inner ";
        $class .= $this->field->input_type == 'color' ? "h-11 p-1 " : null;
        $class .= ($this->field->prefix || $this->field->hasIcon) ? " rounded-none rounded-r" : " rounded";
        return $class;
    }

    public function error(): string
    {
        return $this->class()." tf-field-error";
    }

    public function render(): View
    {
        return view('tall-forms::components.input');
    }
}
