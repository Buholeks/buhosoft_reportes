<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class SelectTipoventa extends Component
{
    public $name;
    public $options;

    public function __construct($name = 'tipoventa_id')
    {
        $this->name = $name;
        $this->options = DB::table('tabla_tipoproducto')->pluck('nombre', 'id');
    }

    public function render()
    {
        return view('components.select-tipoventa');
    }
}
