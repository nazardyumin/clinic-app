<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Appointment;

class PdfController extends Controller
{
    public function show_pdf(Request $request){
        $app = Appointment::find($request->id);
        $pdf = Pdf::loadView('pdf.result', ['app' => $app]);
        return $pdf->stream();
    }
}
