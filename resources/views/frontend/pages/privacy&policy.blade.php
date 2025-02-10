@extends('frontend.master.master')

@section('keyTitle', 'Privacy Policy')

@section('contents')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Privacy Policy</h2>

                    <p class="text-muted text-center"><strong>Last Updated:</strong> January 1, 2025</p>

                    <hr>

                    <h4 class="text-primary">1. Introduction</h4>
                    <p>Welcome to <strong>Leaars.com</strong> ("we," "us," or "our"). This Privacy Policy explains how we collect, use, and protect your personal information when you visit our website, <a href="https://leaars.com/" class="text-decoration-none">{{ url('/') }}</a>. By using the Site, you agree to this policy.</p>

                    <h4 class="text-primary mt-4">2. Information We Collect</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Personal Information:</strong> Your name, email, phone number, billing/shipping address, or payment details when you register, purchase, or contact us.</li>
                        <li class="list-group-item"><strong>Non-Personal Information:</strong> Browser type, device info, IP address, and site usage (e.g., pages visited, time spent).</li>
                        <li class="list-group-item"><strong>Cookies:</strong> We use cookies to enhance user experience. You can manage cookie preferences in your browser settings.</li>
                    </ul>

                    <h4 class="text-primary mt-4">3. How We Use Your Information</h4>
                    <p>We may use your data to:</p>
                    <ul>
                        <li>Provide and improve our products/services.</li>
                        <li>Process orders and send confirmations.</li>
                        <li>Respond to customer support inquiries.</li>
                        <li>Send promotional emails (opt-out available).</li>
                        <li>Analyze website traffic (Google Analytics, etc.).</li>
                    </ul>

                    <h4 class="text-primary mt-4">4. Sharing of Information</h4>
                    <p>We do not sell your data. However, we may share it with:</p>
                    <ul>
                        <li><strong>Service Providers:</strong> Payment processors (e.g., Visa, Cash on Delivery), shipping partners, or email marketing platforms (e.g., Mailchimp).</li>
                        <li><strong>Legal Compliance:</strong> To comply with laws, court orders, or protect our rights.</li>
                    </ul>

                    <h4 class="text-primary mt-4">5. Data Security</h4>
                    <p>We use SSL encryption and secure servers to protect your data. However, no online transmission is 100% secure.</p>

                    <h4 class="text-primary mt-4">6. Your Rights</h4>
                    <p>Depending on your location (e.g., GDPR for EU users, CCPA for California residents), you may:</p>
                    <ul>
                        <li>Request access, correction, or deletion of your data.</li>
                        <li>Opt out of marketing communications.</li>
                        <li>Withdraw consent for data processing.</li>
                    </ul>
                    <p>Contact us at <a href="mailto:leaarsbd@gmail.com" class="text-decoration-none">leaarsbd@gmail.com</a> to exercise your rights.</p>

                    <h4 class="text-primary mt-4">7. Children’s Privacy</h4>
                    <p>Our Site is not intended for users under 13 (or 16 under GDPR). We do not knowingly collect data from children.</p>

                    <h4 class="text-primary mt-4">8. Third-Party Links</h4>
                    <p>Our Site may contain links to third-party websites. We are not responsible for their privacy practices.</p>

                    <h4 class="text-primary mt-4">9. Policy Updates</h4>
                    <p>We may update this policy periodically. Any changes will be posted here with a revised "Last Updated" date.</p>

                    <h4 class="text-primary mt-4">10. Contact Us</h4>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-1"><strong>📧 Email:</strong> <a href="mailto:leaarsbd@gmail.com" class="text-decoration-none">leaarsbd@gmail.com</a></p>
                        <p class="mb-0"><strong>📍 Address:</strong> Uttara, Dhaka 1230, Bangladesh</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
