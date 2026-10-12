<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Orders & Placement', 'slug' => 'orders', 'icon' => 'fa-box', 'color' => 'blue',
                'questions' => [
                    ['How do I place an order on Aparatus?', "Browse our sports goods and curated toys catalog. Click 'Add to Cart' or 'Buy Now'. Once in your cart, proceed to our secure checkout, enter your delivery address, choose your preferred payment method, and confirm your order instantly."],
                    ['Can I cancel or modify an order after placing it?', "Yes! You can cancel or modify your order within 2 hours of placement directly from your Account Dashboard under 'My Orders', or by contacting our 24/7 customer care team on WhatsApp before the shipment is dispatched."],
                    ['Will I receive an invoice and order confirmation?', 'Immediately upon order confirmation, an itemized tax invoice and dispatch summary will be sent to your registered email address and WhatsApp/SMS. You can also download official PDF invoices anytime from your account.'],
                ],
            ],
            [
                'name' => 'Shipping & Delivery', 'slug' => 'shipping', 'icon' => 'fa-truck', 'color' => 'orange',
                'questions' => [
                    ['How long does shipping take across India?', 'Standard express delivery takes 3–5 business days across major metro cities and 4–7 business days for regional pin codes. All orders are packed in heavy-duty tamper-proof boxes.'],
                    ['How can I track my live parcel?', "You can track your order using our interactive 'Track Order' tool by entering your Order ID (e.g. AP-2026-89421) or phone number, or by viewing the real-time timeline in your Customer Dashboard."],
                    ['Is there a free delivery threshold?', 'Yes! All orders over ₹999 qualify for 100% Free Standard Express Delivery across India. For orders below ₹999, a nominal delivery fee of ₹49 is applied.'],
                ],
            ],
            [
                'name' => 'Payments & Security', 'slug' => 'payments', 'icon' => 'fa-credit-card', 'color' => 'purple',
                'questions' => [
                    ['What payment methods are supported on Aparatus?', 'We accept all major secure payment channels including UPI (Google Pay, PhonePe, Paytm), Credit & Debit Cards (Visa, MasterCard, RuPay, Amex), Net Banking across 50+ banks, and Cash on Delivery (COD) for eligible pincodes.'],
                    ['Are online payments 100% safe & protected?', 'All transactions are protected by bank-grade 256-bit SSL encryption through RBI-compliant, PCI-DSS Level 1 certified gateways. We never store your CVV or card PINs.'],
                ],
            ],
            [
                'name' => 'Returns & Replacements', 'slug' => 'returns', 'icon' => 'fa-rotate-left', 'color' => 'rose',
                'questions' => [
                    ['What is your 7-Day Replacement Policy?', 'We offer a hassle-free 7-day return and replacement guarantee for any damaged, defective, or incorrect items. Products must be in original condition with tags and packaging intact.'],
                    ['How do I request a doorstep return pickup?', "Go to Account > My Orders, select the order item, and click 'Request Replacement'. Our courier partner will schedule a convenient doorstep pickup within 24–48 hours."],
                    ['How quickly are refunds credited?', 'Once the item is inspected at our fulfillment facility, refunds are initiated immediately and credited back to your original payment method or UPI within 3–5 business days.'],
                ],
            ],
            [
                'name' => 'Safety & Quality Assurance', 'slug' => 'products', 'icon' => 'fa-shield-heart', 'color' => 'mint',
                'questions' => [
                    ['Are all toys non-toxic and tested for child safety?', 'Yes. Every single toy and sports product adheres to strict BIS (Bureau of Indian Standards), EN71, and ASTM standards. We use non-toxic, BPA-free materials, smooth rounded splinter-free woods, and food-grade child-safe paints.'],
                    ['What grade willow is used in your cricket bats?', 'Our junior and training cricket bats are handcrafted from selected Grade Kashmir Willow, pre-knocked with reinforced toe guards and chevron shock-absorbing grips.'],
                ],
            ],
            [
                'name' => 'Account & Support', 'slug' => 'account', 'icon' => 'fa-user-gear', 'color' => 'yellow',
                'questions' => [
                    ['How do I update my profile details or addresses?', "Sign in to your Aparatus account, go to 'Addresses' or 'Personal Profile', and update your preferred delivery addresses and phone numbers anytime."],
                    ['How do I connect with customer care directly?', 'Our customer support team is available Monday to Saturday, 9:00 AM – 7:00 PM IST via WhatsApp (+91 98765 43210) or email at support@aparatus.com.'],
                ],
            ],
        ];

        $seedQuestions = Faq::count() === 0;

        foreach ($data as $i => $c) {
            $cat = FaqCategory::firstOrCreate(
                ['slug' => $c['slug']],
                ['name' => $c['name'], 'icon' => $c['icon'], 'color' => $c['color'], 'sort_order' => $i + 1, 'status' => 1]
            );

            if ($seedQuestions) {
                foreach ($c['questions'] as $j => [$q, $a]) {
                    Faq::create([
                        'faq_category_id' => $cat->id,
                        'question' => $q,
                        'answer' => $a,
                        'sort_order' => $j + 1,
                        'status' => 1,
                    ]);
                }
            }
        }
    }
}