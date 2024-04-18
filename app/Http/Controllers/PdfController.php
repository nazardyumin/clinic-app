<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Appointment;

class PdfController extends Controller
{
    public function show_pdf(Request $request){
        // dd('попали сюда');
        $app = Appointment::find($request->id);
        $pdf = Pdf::loadView('pdf.result', ['app' => $app]);
        return $pdf->stream();
    }

    // public function show_pdf_to_doctor(Request $request){
    //     $this->show_pdf($request->id);
    // }

    // public function show_pdf(int $id){
    //     $app = Appointment::find($id);
    //     $pdf = Pdf::loadView('pdf.result', ['app' => $app]);
    //     return $pdf->stream();
    // }
}
