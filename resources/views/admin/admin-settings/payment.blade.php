<form method="POST" action="{{ route('admin.payment-settings.store') }}">
    @csrf

    <div class="settings-content" style="max-width:720px">

        <!-- Razorpay header card -->
        <div class="razorpay-header">
            <div class="razorpay-logo">
                <i class="fa-solid fa-bolt"></i>
            </div>
            <div>
                <div class="razorpay-name">Razorpay</div>
                <div class="razorpay-desc">India's leading payment gateway — UPI, Cards, Net Banking, Wallets &amp; EMI
                </div>
            </div>
            <div style="margin-left:auto">
                <span class="mode-pill mode-test" id="modePill">Test Mode</span>
            </div>
        </div>


        <!-- Mode toggle -->
        <div class="info-banner amber" id="modeBanner">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <div id="modeBannerText">You are currently in <strong>Test Mode</strong>. Payments will not be captured.
                Switch to Live Mode only when you are ready to accept real payments.</div>
        </div>

        <div class="settings-section">
            <div class="settings-section-title"><i class="fa-solid fa-toggle-on"></i> Mode</div>
            <div class="toggle-row" style="padding:14px 0">
                <div>
                    <div class="toggle-info-label">Live Mode</div>
                    <div class="toggle-info-sub">Toggle ON to accept real payments from customers.</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="liveToggle" name="live_mode" value="1"
                        {{ old('live_mode', $payment->live_mode ?? 0) ? 'checked' : '' }} onchange="toggleMode(this)">
                    <span class="toggle-track"></span>
                </label>
            </div>
        </div>

        <hr class="section-divider">

        <!-- NEW: Webhook URL -->
        <div class="settings-section">
            <div class="settings-section-title"><i class="fa-solid fa-link"></i> Webhook URL</div>
            <p class="settings-section-desc">
                Razorpay Dashboard → Settings → Webhooks mein ye URL paste karein. Events:
                <code>payment.captured</code>, <code>order.paid</code>, <code>payment.failed</code>.
                Test aur Live dono dashboards mein same URL use hoga, bas secret alag hoga.
            </p>

            <div class="api-key-card">
                <div class="api-key-card-title">Webhook Endpoint</div>
                <div class="input-wrap">
                    <span class="input-prefix"><i class="fa fa-link"></i></span>
                    <input type="text" id="webhookUrl" class="field-input monospace" readonly
                        value="{{ route('razorpay.webhook') }}">
                    <button type="button" onclick="copyWebhookUrl(this)"
                        style="border:1px solid var(--border);border-left:none;border-radius:0 var(--radius-sm) var(--radius-sm) 0;background:var(--bg);padding:0 12px;cursor:pointer;color:var(--text-hint);flex-shrink:0"><i
                            class="fa fa-copy"></i></button>
                </div>
            </div>
        </div>

        <hr class="section-divider">

        <!-- Test Keys -->
        <div class="settings-section" id="rp-test">
            <div class="settings-section-title"><i class="fa-solid fa-flask"></i> Test API Keys</div>
            <p class="settings-section-desc">Use these keys in development. No real money is processed.</p>

            <div class="api-key-card">
                <div class="api-key-card-title">Test Key ID</div>
                <div class="input-wrap">
                    <span class="input-prefix"><i class="fa fa-key"></i></span>
                    <input type="text" name="test_key_id" class="field-input monospace"
                        value="{{ old('test_key_id', $payment->test_key_id ?? '') }}"
                        placeholder="rzp_test_XXXXXXXXXXXX">
                </div>
            </div>
            <div class="api-key-card">
                <div class="api-key-card-title">Test Key Secret</div>
                <div class="input-wrap">
                    <span class="input-prefix"><i class="fa fa-lock"></i></span>
                    <input type="password" name="test_key_secret" class="field-input monospace" id="testSecret"
                        value="{{ old('test_key_secret', $payment->test_key_secret ?? '') }}"
                        placeholder="••••••••••••••••••••">
                    <button type="button" onclick="togglePass('testSecret', this)"
                        style="border:1px solid var(--border);border-left:none;border-radius:0 var(--radius-sm) var(--radius-sm) 0;background:var(--bg);padding:0 12px;cursor:pointer;color:var(--text-hint);flex-shrink:0"><i
                            class="fa fa-eye"></i></button>
                </div>
            </div>

            <!-- NEW -->
            <div class="api-key-card">
                <div class="api-key-card-title">Test Webhook Secret</div>
                <div class="input-wrap">
                    <span class="input-prefix"><i class="fa fa-shield-halved"></i></span>
                    <input type="password" name="test_webhook_secret" class="field-input monospace"
                        id="testWebhookSecret"
                        value="{{ old('test_webhook_secret', $payment->test_webhook_secret ?? '') }}"
                        placeholder="Razorpay webhook mein jo secret dala wahi">
                    <button type="button" onclick="togglePass('testWebhookSecret', this)"
                        style="border:1px solid var(--border);border-left:none;border-radius:0 var(--radius-sm) var(--radius-sm) 0;background:var(--bg);padding:0 12px;cursor:pointer;color:var(--text-hint);flex-shrink:0"><i
                            class="fa fa-eye"></i></button>
                </div>
            </div>
        </div>

        <hr class="section-divider">

        <!-- Live Keys -->
        <div class="settings-section" id="rp-live">
            <div class="settings-section-title"><i class="fa-solid fa-circle-check"></i> Live API Keys</div>
            <p class="settings-section-desc">Enter your production keys from the Razorpay Dashboard. Keep these secret.
            </p>

            <div class="api-key-card">
                <div class="api-key-card-title">Live Key ID</div>
                <div class="input-wrap">
                    <span class="input-prefix"><i class="fa fa-key"></i></span>
                    <input type="text" name="live_key_id" class="field-input monospace"
                        value="{{ old('live_key_id', $payment->live_key_id ?? '') }}"
                        placeholder="rzp_live_XXXXXXXXXXXX">
                </div>
            </div>
            <div class="api-key-card">
                <div class="api-key-card-title">Live Key Secret</div>
                <div class="input-wrap">
                    <span class="input-prefix"><i class="fa fa-lock"></i></span>
                    <input type="password" name="live_key_secret" class="field-input monospace" id="liveSecret"
                        value="{{ old('live_key_secret', $payment->live_key_secret ?? '') }}"
                        placeholder="••••••••••••••••••••">
                    <button type="button" onclick="togglePass('liveSecret', this)"
                        style="border:1px solid var(--border);border-left:none;border-radius:0 var(--radius-sm) var(--radius-sm) 0;background:var(--bg);padding:0 12px;cursor:pointer;color:var(--text-hint);flex-shrink:0"><i
                            class="fa fa-eye"></i></button>
                </div>
            </div>

            <!-- NEW -->
            <div class="api-key-card">
                <div class="api-key-card-title">Live Webhook Secret</div>
                <div class="input-wrap">
                    <span class="input-prefix"><i class="fa fa-shield-halved"></i></span>
                    <input type="password" name="live_webhook_secret" class="field-input monospace"
                        id="liveWebhookSecret"
                        value="{{ old('live_webhook_secret', $payment->live_webhook_secret ?? '') }}"
                        placeholder="Razorpay webhook mein jo secret dala wahi">
                    <button type="button" onclick="togglePass('liveWebhookSecret', this)"
                        style="border:1px solid var(--border);border-left:none;border-radius:0 var(--radius-sm) var(--radius-sm) 0;background:var(--bg);padding:0 12px;cursor:pointer;color:var(--text-hint);flex-shrink:0"><i
                            class="fa fa-eye"></i></button>
                </div>
            </div>
        </div>

    </div>

    <div class="action-bar">
        <button class="btn-secondary-dash">Discard Changes</button>
        <button class="btn-primary-dash" type="submit">
            <i class="fa fa-save"></i> Save Payment Settings
        </button>
    </div>

</form>

<style>
    /* Mouse le jaate hi (ya click karte hi) placeholder text gayab */
    .api-key-card input:hover::placeholder,
    .api-key-card input:focus::placeholder {
        color: transparent;
    }

    .api-key-card input::placeholder {
        transition: color .15s ease;
    }
</style>

<!-- NEW -->
<script>
    function copyWebhookUrl(btn) {
        const input = document.getElementById('webhookUrl');
        navigator.clipboard.writeText(input.value).then(() => {
            const icon = btn.querySelector('i');
            icon.className = 'fa fa-check';
            setTimeout(() => icon.className = 'fa fa-copy', 1500);
        });
    }
</script>