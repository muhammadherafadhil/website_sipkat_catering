<?php

namespace App\View\Components;

use Illuminate\View\Component;

/**
 * OOP: CLASS COMPONENT
 * - PROPERTY: label, value, icon, color, hint
 * - CONSTRUCTOR: menerima parameter
 * - GETTER: getBadgeClass() → mengubah color jadi class Tailwind
 * - OBJECT METHOD: render()
 */
class StatCard extends Component
{
    // PROPERTY public (dipakai di view)
    public string $label;
    public string $value;
    public string $icon;
    public string $color;
    public ?string $hint;

    // CONSTRUCTOR
    public function __construct(
        string $label,
        string $value,
        string $icon = '📊',
        string $color = 'gray',
        ?string $hint = null
    ) {
        $this->label = $label;
        $this->value = $value;
        $this->icon  = $icon;
        $this->color = $color;
        $this->hint  = $hint;
    }

    // GETTER: ubah color → Tailwind class
    public function getBorderClass(): string
    {
        return match($this->color) {
            'green'  => 'border-l-green-500',
            'red'    => 'border-l-red-500',
            'blue'   => 'border-l-blue-500',
            'orange' => 'border-l-orange-500',
            'yellow' => 'border-l-yellow-500',
            default  => 'border-l-gray-500',
        };
    }

    public function getTextClass(): string
    {
        return match($this->color) {
            'green'  => 'text-green-600',
            'red'    => 'text-red-600',
            'blue'   => 'text-blue-600',
            'orange' => 'text-orange-600',
            'yellow' => 'text-yellow-600',
            default  => 'text-gray-600',
        };
    }

    public function render()
    {
        return view('components.stat-card');
    }
}