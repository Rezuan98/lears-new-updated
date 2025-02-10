@extends('frontend.master.master')

@section('keyTitle', 'Terms & Conditions')

@section('contents')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Terms & Conditions</h2>

                    <p class="text-muted text-center"><strong>Effective Date:</strong> {{ date('F d, Y') }}</p>

                    <hr>

                    <h4 class="text-primary">1. Introduction</h4>
                    <p>Welcome to <strong>Leaars!</strong> These Terms and Conditions ("T&C") govern your use of our website,
                        <a href="{{ url('/') }}" class="text-decoration-none">{{ url('/') }}</a>, and the purchase of products from our store.</p>

                    <h4 class="text-primary mt-4">2. Acceptance of Terms</h4>
                    <p>By accessing or using our website, you agree to be bound by these T&C. If you are under 18,
                        you must have parental or guardian consent.</p>

                    <h4 class="text-primary mt-4">3. Use of the Website</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">You may use this website only for lawful purposes.</li>
                        <li class="list-group-item">Prohibited activities include fraud, hacking, or disrupting our services.</li>
                        <li class="list-group-item">Users must be at least 18 years old or have parental permission to make purchases.</li>
                    </ul>

                    <h4 class="text-primary mt-4">4. Product Information</h4>
                    <p>We make every effort to display accurate product descriptions, pricing, and availability. However, we do not guarantee
                        that all product descriptions or other content on the site are 100% error-free. Product colors may vary due to screen differences.</p>

                    <h4 class="text-primary mt-4">5. Ordering and Payment</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Orders can be placed online through our secure checkout system.</li>
                        <li class="list-group-item">We accept the following payment methods: [List Accepted Payment Methods].</li>
                        <li class="list-group-item">Prices are subject to change without prior notice.</li>
                        <li class="list-group-item">Leaars reserves the right to cancel any order due to pricing errors, stock issues, or fraudulent activity.</li>
                    </ul>

                    <h4 class="text-primary mt-4">6. Shipping and Delivery</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Shipping options and costs are displayed at checkout.</li>
                        <li class="list-group-item">Estimated delivery times are provided but not guaranteed.</li>
                        <li class="list-group-item">International shipping policies may vary. Additional charges may apply.</li>
                        <li class="list-group-item">We are not responsible for delays caused by shipping carriers or customs.</li>
                    </ul>

                    <h4 class="text-primary mt-4">7. Returns and Exchanges</h4>
                    <p>Returns and exchanges are accepted within <strong>[X]</strong> days of purchase.</p>
                    <p>Returned items must be unused, in original packaging, and accompanied by proof of purchase.
                        Customers are responsible for return shipping costs unless the return is due to an error on our part.</p>

                    <h4 class="text-primary mt-4">8. Intellectual Property</h4>
                    <p>All website content, including text, images, logos, and graphics, is owned by Leaars.
                        Unauthorized reproduction, modification, or distribution of our content is strictly prohibited.</p>

                    <h4 class="text-primary mt-4">9. Limitation of Liability</h4>
                    <p>Leaars is not liable for any indirect, incidental, or consequential damages arising from the use of our website or products.</p>

                    <h4 class="text-primary mt-4">10. Privacy Policy</h4>
                    <p>For information on how we collect, use, and protect your data, please refer to our
                        <a href="" class="text-decoration-none">Privacy Policy</a>.
                    </p>

                    <h4 class="text-primary mt-4">11. Governing Law</h4>
                    <p>These T&C are governed by the laws of [Your Country/State]. Any disputes will be resolved in the courts of [Your Location].</p>

                    <h4 class="text-primary mt-4">12. Changes to Terms</h4>
                    <p>We reserve the right to modify these terms at any time. Changes will be posted on this page, and continued use of our website constitutes acceptance of the updated terms.</p>

                    <h4 class="text-primary mt-4">13. Contact Information</h4>
                    <p>If you have any questions regarding these T&C, contact us at:</p>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-1"><strong>📧 Email:</strong> <a href="mailto:support@leaars.com" class="text-decoration-none">support@leaars.com</a></p>
                        <p class="mb-0"><strong>📞 Phone:</strong> [Insert Contact Number]</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
