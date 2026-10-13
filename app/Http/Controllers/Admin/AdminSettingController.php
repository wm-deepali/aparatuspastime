<?php

namespace App\Http\Controllers\Admin;

use App\Models\State;
use App\Models\City;
use App\Models\Setting;
use App\Models\Courier;
use App\Models\Invoice;
use App\Models\SmtpSetting;
use App\Models\ShippingSlab;
use Illuminate\Http\Request;
use App\Models\GoogleSetting;
use App\Models\PaymentSetting;
use App\Models\InvoiceSetting;
use App\Models\ShippingSetting;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    public function index(Request $request)
    {
        $invoice_setting = InvoiceSetting::first();
        $smtp = SmtpSetting::first();
        $payment = PaymentSetting::first();
        $general = Setting::first();
        $states = State::all();
        $couriers = Courier::latest()->get();
        $activeTab = $request->tab ?? 'general';

        $google_setting = GoogleSetting::current();

        $shipping = ShippingSetting::first();
        $slabs = ShippingSlab::orderBy('min_order_value')->get();

        // Saved state ki cities server-side render hongi
        $invoice_cities = ($invoice_setting && $invoice_setting->company_state)
            ? City::where('state_id', $invoice_setting->company_state)
                ->orderBy('name')
                ->get(['id', 'name'])
            : collect();

        return view(
            'admin.admin-settings.index',
            compact(
                'invoice_setting',
                'invoice_cities',
                'smtp',
                'payment',
                'general',
                'states',
                'couriers',
                'google_setting',
                'shipping',
                'slabs',
                'activeTab'
            )
        );
    }

    public function invoiceSettingStore(Request $request)
    {
        $validated = $request->validate([
            // Company
            'company_name' => 'nullable|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'company_address' => 'nullable|string',
            'company_state' => 'nullable|exists:states,id',
            'company_city' => 'nullable|exists:cities,id',
            'company_pincode' => 'nullable|string|max:10',
            'company_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255',
            'company_gstin' => 'nullable|string|max:15',
            'company_pan' => 'nullable|string|max:10',
            // Tax
            'cgst' => 'nullable|numeric|min:0|max:100',
            'sgst' => 'nullable|numeric|min:0|max:100',
            'igst' => 'nullable|numeric|min:0|max:100',
            'tax_type' => 'nullable|in:inclusive,exclusive',
            'business_type' => 'nullable|in:registered,unregistered',
            // Invoice
            'invoice_prefix' => 'nullable|string|max:20',
            'invoice_serial' => 'nullable|integer|min:1',
            'invoice_year_format' => 'nullable|in:none,slash,year',
            'invoice_separator' => 'nullable|string|max:5',
            'invoice_date_format' => 'nullable|in:d/m/Y,d M Y,m-d-Y',
            // Footer
            'terms_conditions' => 'nullable|string',
        ]);

        unset($validated['company_logo']); // file alag handle hoti hai

        // Non-nullable DB columns ke liye defaults
        $validated['cgst'] = $validated['cgst'] ?? 9;
        $validated['sgst'] = $validated['sgst'] ?? 9;
        $validated['igst'] = $validated['igst'] ?? 18;
        $validated['tax_type'] = $validated['tax_type'] ?? 'inclusive';
        $validated['business_type'] = $validated['business_type'] ?? 'registered';
        $validated['invoice_prefix'] = $validated['invoice_prefix'] ?? 'INV';
        $validated['invoice_serial'] = $validated['invoice_serial'] ?? 1;
        $validated['invoice_year_format'] = $validated['invoice_year_format'] ?? 'slash';
        $validated['invoice_separator'] = $validated['invoice_separator'] ?? '/';
        $validated['invoice_date_format'] = $validated['invoice_date_format'] ?? 'd M Y';

        // Checkboxes
        $validated['show_gst_breakup'] = $request->has('show_gst_breakup');
        $validated['auto_generate_invoice'] = $request->has('auto_generate_invoice');
        $validated['email_invoice_customer'] = $request->has('email_invoice_customer');

        // Unregistered business
        if ($validated['business_type'] === 'unregistered') {
            $validated['company_gstin'] = null;
            $validated['company_pan'] = null;
            $validated['cgst'] = 0;
            $validated['sgst'] = 0;
            $validated['igst'] = 0;
            $validated['show_gst_breakup'] = false;
        }

        $setting = InvoiceSetting::first() ?? new InvoiceSetting();

        // Logo upload (purana delete karke naya save)
        if ($request->hasFile('company_logo')) {
            if ($setting->company_logo && Storage::disk('public')->exists($setting->company_logo)) {
                Storage::disk('public')->delete($setting->company_logo);
            }
            $validated['company_logo'] = $request->file('company_logo')->store('company', 'public');
        }

        // forceFill = $fillable ka issue bypass
        $setting->forceFill($validated)->save();

        return redirect()
            ->route('admin.admin-setting.index', ['tab' => 'gst'])
            ->with('success', 'Invoice & GST settings updated successfully.');
    }

    public static function generateInvoiceNumber(): string
    {
        return DB::transaction(function () {
            $setting = InvoiceSetting::lockForUpdate()->first();

            // No row yet: create one with the same defaults as invoiceSettingStore()
            if (!$setting) {
                $setting = new InvoiceSetting();
                $setting->forceFill([
                    'cgst' => 9,
                    'sgst' => 9,
                    'igst' => 18,
                    'tax_type' => 'inclusive',
                    'business_type' => 'registered',
                    'invoice_prefix' => 'INV',
                    'invoice_serial' => 1,
                    'invoice_year_format' => 'slash',
                    'invoice_separator' => '/',
                    'invoice_date_format' => 'd M Y',
                ])->save();
            }

            $year = now()->year;
            $nextYear = substr($year + 1, -2);

            $yearPart = match ($setting->invoice_year_format) {
                'slash' => $year . '-' . $nextYear,
                'year' => (string) $year,
                default => '',
            };

            // Skip forward if a number is somehow already taken
            do {
                $parts = array_filter([
                    $setting->invoice_prefix,
                    $yearPart,
                    str_pad($setting->invoice_serial, 5, '0', STR_PAD_LEFT),
                ], fn($p) => $p !== '' && $p !== null);

                $invoiceNumber = implode($setting->invoice_separator ?: '/', $parts);

                $setting->increment('invoice_serial');
                $setting->refresh();
            } while (Invoice::where('invoice_number', $invoiceNumber)->exists());

            return $invoiceNumber;
        });
    }

    public function getCities(Request $request)
    {
        return City::where('state_id', $request->state_id)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function smtpSettingStore(Request $request)
    {
        $validated = $request->validate([
            'smtp_host' => 'required|string|max:255',
            'smtp_port' => 'required|integer',
            'smtp_username' => 'required|string|max:255',
            'smtp_password' => 'required|string',
            'smtp_encryption' => 'required|in:tls,ssl,none',
            'from_name' => 'nullable|string|max:255',
            'from_email' => 'nullable|email|max:255',
            'reply_to_name' => 'nullable|string|max:255',
            'reply_to_email' => 'nullable|email|max:255',
        ]);

        $validated['order_confirmation']
            = $request->has('order_confirmation');
        $validated['order_shipped']
            = $request->has('order_shipped');
        $validated['order_delivered']
            = $request->has('order_delivered');
        $validated['password_reset']
            = $request->has('password_reset');
        $validated['new_order_alert']
            = $request->has('new_order_alert');
        $validated['low_stock_alert']
            = $request->has('low_stock_alert');

        SmtpSetting::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return back()->with(
            'success',
            'SMTP settings saved successfully.'
        );
    }

    public function paymentSettingStore(Request $request)
    {
        $validated = $request->validate([
            'test_key_id' => 'nullable|string|max:255',
            'test_key_secret' => 'nullable|string',
            'live_key_id' => 'nullable|string|max:255',
            'live_key_secret' => 'nullable|string',
        ]);

        $validated['live_mode'] = $request->has('live_mode');

        PaymentSetting::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return back()->with(
            'success',
            'Payment settings saved successfully.'
        );
    }

    public function generalSettingStore(Request $request)
    {
        $general = Setting::first();

        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'popular_searches' => 'nullable|string|max:1000',
            'admin_email' => 'nullable|email|max:255',
            'support_email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'business_address' => 'nullable|string',
            'footer_description' => 'nullable|string',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'pinterest' => 'nullable|url|max:255',
            'currency' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:10',
            'timezone' => 'nullable|string|max:100',
            'header_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'footer_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpg,jpeg,png,ico,webp|max:1024',
            'admin_login_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'admin_dashboard_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',

            // contact page
            'working_hours' => 'nullable|string|max:255',
            'email_response_note' => 'nullable|string|max:255',
            'address_short' => 'nullable|string|max:255',
            'enquiry_subjects' => 'nullable|string|max:2000',
        ]);

        $validated['maintenance_mode'] = $request->has('maintenance_mode');
        $validated['product_reviews'] = $request->has('product_reviews');
        $validated['wishlist'] = $request->has('wishlist');
        $validated['stock_alerts'] = $request->has('stock_alerts');
        $validated['cod_enabled'] = $request->has('cod_enabled');

        // Logo / favicon uploads (replace old file when a new one is uploaded)
        foreach (['header_logo', 'footer_logo', 'favicon', 'admin_login_logo', 'admin_dashboard_logo'] as $field) {
            if ($request->hasFile($field)) {
                if ($general && $general->$field && Storage::disk('public')->exists($general->$field)) {
                    Storage::disk('public')->delete($general->$field);
                }
                $validated[$field] = $request->file($field)->store('settings', 'public');
            }
        }

        Setting::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return back()->with(
            'success',
            'General settings updated successfully.'
        );
    }

    public function courierStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'website_url' => 'nullable|url|max:255',
        ]);

        $validated['is_active'] =
            $request->has('is_active');

        Courier::updateOrCreate(
            ['id' => $request->id],
            $validated
        );

        return redirect()
            ->route(
                'admin.admin-setting.index',
                ['tab' => 'couriers']
            )
            ->with(
                'success',
                'Courier saved successfully.'
            );
    }

    public function courierDelete(Courier $courier)
    {
        $courier->delete();

        return redirect()
            ->route(
                'admin.admin-setting.index',
                ['tab' => 'couriers']
            )
            ->with(
                'success',
                'Courier deleted successfully.'
            );
    }

    public function googleSettingStore(Request $request)
    {
        $request->validate([
            'gtm_container_id' => 'nullable|string|max:50',
            'ga4_measurement_id' => 'nullable|string|max:50',
            'gads_conversion_id' => 'nullable|string|max:50',
            'meta_pixel_id' => 'nullable|string|max:50',
            'gsc_verify_method' => 'nullable|in:meta,file,dns',
            'gads_currency' => 'nullable|string|max:5',
        ]);

        $checkboxFields = [
            'gtm_enabled',
            'gtm_all_pages',
            'gtm_datalayer_events',
            'ga4_enabled',
            'ga4_ev_view_item',
            'ga4_ev_add_to_cart',
            'ga4_ev_remove_from_cart',
            'ga4_ev_begin_checkout',
            'ga4_ev_add_payment',
            'ga4_ev_purchase',
            'ga4_ev_refund',
            'ga4_ev_search',
            'ga4_ev_login',
            'ga4_ev_sign_up',
            'gads_enabled',
            'gads_enhanced_conversions',
            'gads_send_order_value',
            'gsc_auto_sitemap',
            'meta_enabled',
            'meta_ev_page_view',
            'meta_ev_view_content',
            'meta_ev_add_to_cart',
            'meta_ev_add_to_wishlist',
            'meta_ev_initiate_checkout',
            'meta_ev_add_payment',
            'meta_ev_purchase',
            'meta_ev_lead',
            'meta_ev_complete_reg',
            'meta_ev_search',
            'meta_advanced_matching',
        ];

        $data = $request->except(['_token']);

        foreach ($checkboxFields as $field) {
            $data[$field] = $request->boolean($field);
        }

        GoogleSetting::updateOrCreate(['id' => 1], $data);

        return redirect()
            ->route('admin.admin-setting.index', ['tab' => 'tracking'])
            ->with('success', 'Tracking settings saved successfully.');
    }

    public function shippingSettingStore(Request $request)
    {
        $validated = $request->validate([
            'shipping_type' => 'required|in:order_value,weight,pcs',
            'free_delivery_threshold' => 'nullable|numeric|min:0',

            // Weight (grams)
            'min_weight' => 'nullable|integer|min:0',
            'weight_step' => 'nullable|in:100,200,250,500,1000',
            'weight_local_charge' => 'nullable|numeric|min:0',
            'weight_local_extra' => 'nullable|numeric|min:0',
            'weight_state_charge' => 'nullable|numeric|min:0',
            'weight_state_extra' => 'nullable|numeric|min:0',
            'weight_inter_charge' => 'nullable|numeric|min:0',
            'weight_inter_extra' => 'nullable|numeric|min:0',

            // Pcs
            'min_pcs' => 'nullable|integer|min:1',
            'pcs_local_charge' => 'nullable|numeric|min:0',
            'pcs_local_extra' => 'nullable|numeric|min:0',
            'pcs_state_charge' => 'nullable|numeric|min:0',
            'pcs_state_extra' => 'nullable|numeric|min:0',
            'pcs_inter_charge' => 'nullable|numeric|min:0',
            'pcs_inter_extra' => 'nullable|numeric|min:0',

            // Order value slabs
            'slabs' => 'nullable|array',
            'slabs.*.min' => 'nullable|numeric|min:0',
            'slabs.*.max' => 'nullable|numeric|min:0',
            'slabs.*.local' => 'nullable|numeric|min:0',
            'slabs.*.state' => 'nullable|numeric|min:0',
            'slabs.*.inter' => 'nullable|numeric|min:0',
        ]);

        $slabs = $validated['slabs'] ?? [];
        unset($validated['slabs']);

        // Non-nullable DB columns: empty input = 0 / default
        foreach (['weight', 'pcs'] as $m) {
            foreach (['local', 'state', 'inter'] as $z) {
                $validated["{$m}_{$z}_charge"] = $validated["{$m}_{$z}_charge"] ?? 0;
                $validated["{$m}_{$z}_extra"] = $validated["{$m}_{$z}_extra"] ?? 0;
            }
        }
        $validated['weight_step'] = $validated['weight_step'] ?? 500;

        // Slab sanity check: max must be greater than min
        foreach ($slabs as $s) {
            if (isset($s['min'], $s['max']) && $s['max'] !== '' && (float) $s['max'] < (float) $s['min']) {
                return back()
                    ->withInput()
                    ->withErrors(['slabs' => 'Maximum order value cannot be less than minimum order value.']);
            }
        }

        DB::transaction(function () use ($validated, $slabs) {
            ShippingSetting::updateOrCreate(['id' => 1], $validated);

            ShippingSlab::query()->delete();   // was: ShippingSlab::truncate();

            foreach ($slabs as $s) {
                if (!isset($s['min']) || $s['min'] === '') {
                    continue;
                }

                ShippingSlab::create([
                    'min_order_value' => $s['min'],
                    'max_order_value' => ($s['max'] ?? '') !== '' ? $s['max'] : null,
                    'local_charge' => $s['local'] ?? 0,
                    'state_charge' => $s['state'] ?? 0,
                    'inter_charge' => $s['inter'] ?? 0,
                ]);
            }
        });

        return redirect()
            ->route('admin.admin-setting.index', ['tab' => 'shipping'])
            ->with('success', 'Shipping settings saved successfully.');
    }

}