<?php

namespace App\Http\Controllers;

use App\Models\FolioEmpresa;
use App\Models\FolioSucursal;
use App\Models\Sucursal;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;

class ControladorFolios extends Controller
{
    /**
     * Genera folios únicos por empresa y por sucursal.
     *
     * @param int $empresaId
     * @param int $sucursalId
     * @return array
     * @throws \Exception
     */
    public static function generar($empresaId, $sucursalId)
    {
        DB::beginTransaction();

        try {
            // Validar que la sucursal pertenezca a la empresa
            $sucursal = Sucursal::findOrFail($sucursalId);

            if ($sucursal->id_empresa !== $empresaId) {
                throw new \Exception('La sucursal no pertenece a la empresa.');
            }

            // 🔸 Folio de empresa
            $folioEmpresa = FolioEmpresa::where('empresa_id', $empresaId)
                ->lockForUpdate()
                ->firstOrCreate(['empresa_id' => $empresaId]);

            $folioEmpresa->ultimo_folio += 1;
            $folioEmpresa->save();

            // 🔸 Folio de sucursal
            $folioSucursal = FolioSucursal::where('sucursal_id', $sucursalId)
                ->lockForUpdate()
                ->firstOrCreate([
                    'empresa_id' => $empresaId,
                    'sucursal_id' => $sucursalId,
                ]);

            $folioSucursal->ultimo_folio += 1;
            $folioSucursal->save();

            DB::commit();


            $empresa = Empresa::find($empresaId);
            $sucursal = Sucursal::find($sucursalId);

            return [
                'folio_empresa' => $empresa->prefijo_folio_empresa . str_pad($empresaId, 3, '0', STR_PAD_LEFT) . '-' . str_pad($folioEmpresa->ultimo_folio, 5, '0', STR_PAD_LEFT),

                'folio_sucursal' => $sucursal->prefijo_folio_sucursal . str_pad($sucursalId, 3, '0', STR_PAD_LEFT) . '-' . str_pad($folioSucursal->ultimo_folio, 5, '0', STR_PAD_LEFT),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
