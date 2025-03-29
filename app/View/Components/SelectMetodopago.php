<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class SelectMetodopago extends Component
{
    public $name;
    public $options;

    public function __construct($name = 'metodopago_id')
    {
        $this->name = $name;
        $this->options = DB::table('tabla_metodopagos')->pluck('nombre', 'id');
    }

    public function render()
    {
        return view('components.select-metodopago');
    }
}
