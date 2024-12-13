<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SolicitudesExport;
use Barryvdh\DomPDF\Facade\Pdf;

class SolicitudController extends Controller
{
    public function cambiarEstado($id)
    {
        $solicitud = Solicitud::findOrFail($id);

        $estados = ['pendiente', 'en_revision', 'aprobada', 'rechazada'];
        $index = array_search($solicitud->estado_solicitud, $estados);

        $nuevoEstado = $index !== false && $index < count($estados) - 1 ? $estados[$index + 1] : 'pendiente';

        $solicitud->update(['estado_solicitud' => $nuevoEstado]);

        return redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }

    public function exportExcel()
    {
        return Excel::download(new SolicitudesExport, 'solicitudes.xlsx');
    }

    public function exportPDF()
    {
        $solicitudes = Solicitud::with(['estudiante', 'progenitores', 'documentosAdjuntos'])->get();

        $pdf = Pdf::loadView('solicitudes.pdf', compact('solicitudes'));
        return $pdf->download('solicitudes.pdf');
    }

}
