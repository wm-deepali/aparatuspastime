<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvoiceSetting;
use App\Models\RefundTransaction;
use App\Services\CreditNoteService;
use Barryvdh\DomPDF\Facade\Pdf;

class CreditNoteController extends Controller
{
    // Browser preview
    public function show(RefundTransaction $refund, CreditNoteService $service)
    {
        return view('admin.orders.credit-note', $this->data($refund, $service, false));
    }

    // PDF download
    public function download(RefundTransaction $refund, CreditNoteService $service)
    {
        $data = $this->data($refund, $service, true);

        $pdf = Pdf::loadView('admin.orders.credit-note', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isRemoteEnabled' => false,
                'isHtml5ParserEnabled' => true,
                'dpi' => 150,
            ]);

        return $pdf->download('CreditNote-' . $data['cn']['credit_note_no'] . '.pdf');
    }

    private function data(RefundTransaction $refund, CreditNoteService $service, bool $isPdf): array
    {
        abort_if($refund->status !== 'completed', 404, 'Credit note is available only after refund is completed.');

        $refund->load(CreditNoteService::relations());

        $cn = $service->build($refund);
        $order = $cn['order'];

        $setting = InvoiceSetting::with(['state', 'city'])->first();

        $logo_64 = null;
        if ($setting?->company_logo) {
            $logoPath = storage_path('app/public/' . $setting->company_logo);
            if (file_exists($logoPath)) {
                $logo_64 = 'data:' . mime_content_type($logoPath) . ';base64,'
                    . base64_encode(file_get_contents($logoPath));
            }
        }

        return [
            'refund' => $refund,
            'cn' => $cn,
            'order' => $order,
            'invoice' => $order->invoice,
            'setting' => $setting,
            'logo_64' => $logo_64,
            'isPdf' => $isPdf,
        ];
    }
}