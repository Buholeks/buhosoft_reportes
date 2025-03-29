<?php
namespace App\Exports;

use App\Models\Equipo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EquiposExport implements FromCollection, WithHeadings
{
    protected $equiposIds;

    public function __construct($equiposIds)
    {
        $this->equiposIds = $equiposIds;
    }

    public function collection()
    {
        return Equipo::whereIn('id', $this->equiposIds)->get()->map(function ($equipo) {
            return [
                'Ticket Empresa' => $equipo->tkempresa,
                'Ticket Local' => $equipo->tklocal,
                'IMEI' => $equipo->imei,
                'Marca/Modelo' => $equipo->marca,
                'Tipo de Producto' => $equipo->tipoproducto ? $equipo->tipoproducto->nombre : 'N/A',
                'Método de Pago' => $equipo->metodopago ? $equipo->metodopago->nombre : 'N/A',
                'Precio' => '$' . number_format($equipo->precio, 2),
                'Sucursal' => $equipo->id_sucursal ? $equipo->sucursal->nombre : 'N/A',
                'Fecha Creación' => $equipo->created_at->format('Y-m-d H:i:s'), // Formato de fecha amigable
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Ticket Empresa', 'Ticket Local', 'IMEI', 'Marca/Modelo',
            'Tipo de Producto', 'Método de Pago', 'Precio', 'Sucursal', 'Fecha Creación'
        ];
    }
}
