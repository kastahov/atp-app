<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Barryvdh\DomPDF\Facade\Pdf;

class DownloadDeliveryInPdf extends Controller
{
    public function __invoke(Delivery $delivery)
    {
        $delivery->load(['driver', 'dispatcher', 'driver.vehicle']);

        return Pdf::setOption(['defaultFont' => 'sans-serif'])
            ->loadView('pdf.delivery', ['delivery' => $delivery->toArray()])->stream();
    }
}
