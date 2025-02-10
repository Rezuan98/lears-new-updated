@extends('frontend.master.master')

@section('keyTitle', 'Shipping Policy')

@section('contents')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Shipping Policy</h2>

                    <p class="text-muted text-center"><strong>Last Updated:</strong> {{ date('F d, Y') }}</p>

                    <hr>

                    <h4 class="text-primary">1. Domestic Shipping</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Service Area:</strong> We offer home delivery services throughout Bangladesh.</li>
                        <li class="list-group-item"><strong>Processing Time:</strong> Orders are processed within 1-2 business days after payment confirmation.</li>
                        <li class="list-group-item"><strong>Delivery Time:</strong> Standard delivery takes 3-5 business days, depending on the destination within Bangladesh.</li>
                        <li class="list-group-item"><strong>Shipping Charges:</strong> Shipping fees are calculated at checkout based on the delivery location and order weight.</li>
                    </ul>

                    <h4 class="text-primary mt-4">2. International Shipping</h4>
                    <p>Currently, we <strong>do not offer</strong> international shipping.</p>

                    <h4 class="text-primary mt-4">3. Order Tracking</h4>
                    <p>Once your order is shipped, you will receive a confirmation email with tracking information. You can also track your order status by logging into your account on our website.</p>

                    <h4 class="text-primary mt-4">4. Shipping Promotions</h4>
                    <p>During promotional periods, such as our <strong>New Year Mega Sale</strong>, enjoy exclusive discounts across all categories, plus <strong>free shipping</strong> on orders over <strong>a specific amountgit</strong>.</p>

                    <h4 class="text-primary mt-4">5. Delivery Issues</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Incorrect Address:</strong> Please ensure that your shipping address is correct. We are not responsible for orders delivered to incorrect or incomplete addresses provided by the customer.</li>
                        <li class="list-group-item"><strong>Lost or Damaged Packages:</strong> If your package is lost or arrives damaged, please contact us immediately at <a href="mailto:leaarsbd@gmail.com" class="text-decoration-none">leaarsbd@gmail.com</a> or call <a href="tel:+8801811384324" class="text-decoration-none">+8801811384324</a>.</li>
                    </ul>

                    <h4 class="text-primary mt-4">6. Contact Information</h4>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-1"><strong>📧 Email:</strong> <a href="mailto:leaarsbd@gmail.com" class="text-decoration-none">leaarsbd@gmail.com</a></p>
                        <p class="mb-1"><strong>📞 Phone:</strong> <a href="tel:+8801811384324" class="text-decoration-none">+8801811384324</a></p>
                        <p class="mb-0"><strong>📍 Address:</strong> Uttara, Dhaka 1230, Bangladesh</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
