<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
// use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;

class StaffProfileController extends Controller
{
    public function index()
    {
        $timeZone = Auth::getUser()->timezone;
        $today = Carbon::now($timeZone);
        $yesterday = Carbon::yesterday($timeZone)->addDays(1)->format('Y-m-d-H-i');
        $appointments = Auth::getUser()->appointments->where('date', '>', $yesterday)->sortBy('date');
        $filtered = $appointments->filter(function (Appointment $app) {
            $tomorrow = Carbon::tomorrow()->format('Y-m-d');
            return $app->date < $tomorrow;
        });
        return view('staff.profile', ['appointments' => $filtered->all(), 'today' => $today]);
    }

    public function open(string $id)
    {
        $selectedApp = Appointment::find($id);
        return redirect(route('staff.profile'))->with(['selectedApp' => $selectedApp]);
    }

    public function update(Request $request, string $id)
    {

        $app = Appointment::find($id);
        $app->complaints = $request->complaints;
        $app->diagnosis = $request->diagnosis;
        $app->recommendations = $request->recommendations;
        $app->closed = true;
        // $path = '\\app\\pdf\\'.'result_'.$app->id.'.pdf';
        // Pdf::loadView('pdf.result', ['app' => $app])->save(storage_path().$path);
        // $app->result_pdf =  $path;
        $app->save();

        return redirect(route('staff.profile'));
    }

    // public function createPdf()
    // {
    //     $app = Appointment::find(25);
    //     $pdf = Pdf::loadView('pdf.result', ['app' => $app]);
    //     return $pdf->stream();
    //     //TODO разобраться с pdf!!!




    //     //$pdf = Pdf::loadView('pdf.template', ['app' => $app]);
    //     //return $pdf->download('test.pdf');
    //     //$pdf->save()
    //     // $html = "<html><head><style>body { font-family: DejaVu Sans }</style>".
    //     // "<body>А вот и кириллица</body>".
    //     // "</head></html>";
    //     // $pdf = App::make('dompdf.wrapper');
    //     // $pdf->loadHTML($html);


    //     //return $pdf->stream();

    //     //return view('pdf.template', ['app' => $app]);

    //     $path = storage_path().'\\app\\pdf\\'.'result_'.$app->id.'.pdf';
    //     $pdf = Pdf::loadView('pdf.result', ['app' => $app])->save($path);
    //     return $pdf->stream();

    //     // $pdf = App::make('dompdf.wrapper');
    //     // $pdf->loadView('pdf.result', ['app' => $app]);
    //     // return $pdf->stream();
    // }
}
