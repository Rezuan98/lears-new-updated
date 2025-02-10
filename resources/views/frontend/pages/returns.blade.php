@extends('frontend.master.master')

@section('keyTitle', 'Returns & Exchanges Policy')

@section('contents')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Returns & Exchanges Policy</h2>

                    <p class="text-muted text-center"><strong>Last Updated:</strong> {{ date('F d, Y') }}</p>

                    <hr>

                    <h4 class="text-primary">1. Return Eligibility</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Time Frame:</strong> Customers may return items within <strong>30 days</strong> from the date of purchase.</li>
                        <li class="list-group-item"><strong>Condition:</strong> Items must be <strong>unused, unworn, unwashed</strong>, and in their original packaging with all tags and labels attached.</li>
                        <li class="list-group-item"><strong>Non-Returnable Items:</strong> Certain products, such as intimate apparel, custom-made items, or clearance merchandise, are final sale and cannot be returned or exchanged.</li>
                    </ul>

                    <h4 class="text-primary mt-4">2. Return Process</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Initiation:</strong> To initiate a return, contact our Customer Service at <a href="mailto:leaarsbd@gmail.com" class="text-decoration-none">leaarsbd@gmail.com</a> or call <a href="tel:+8801716286021" class="text-decoration-none">+8801716286021</a>. Provide your order number and reason for return.</li>
                        <li class="list-group-item"><strong>Shipping:</strong> Customers are responsible for return shipping costs. We recommend using a trackable shipping service to ensure the safe return of your item.</li>
                        <li class="list-group-item"><strong>Inspection:</strong> Upon receipt, returned items will be inspected. If the item is ineligible for return (e.g., used or damaged), it will be sent back to the customer.</li>
                    </ul>

                    <h4 class="text-primary mt-4">3. Refunds</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Processing Time:</strong> Refunds will be processed within <strong>7 business days</strong> after we receive and inspect the returned item.</li>
                        <li class="list-group-item"><strong>Method:</strong> Refunds will be issued to the original payment method used during purchase.</li>
                        <li class="list-group-item"><strong>Shipping Costs:</strong> Original shipping fees are <strong>non-refundable</strong>.</li>
                    </ul>

                    <h4 class="text-primary mt-4">4. Exchanges</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Eligibility:</strong> Exchanges are allowed for items of the same value, subject to availability.</li>
                        <li class="list-group-item"><strong>Process:</strong> To request an exchange, contact Customer Service at <a href="mailto:leaarsbd@gmail.com" class="text-decoration-none">leaarsbd@gmail.com</a> or <a href="tel:+8801811384324" class="text-decoration-none">+8801811384324</a>. If the desired item is unavailable, a refund will be processed instead.</li>
                    </ul>

                    <h4 class="text-primary mt-4">5. Damaged or Defective Items</h4>
                    <p>If you receive a damaged or defective item, please notify us within <strong>7 days</strong> of receipt. We will arrange for a replacement or refund, including return shipping costs.</p>

                    <h4 class="text-primary mt-4">6. International Returns</h4>
                    <p>Currently, we <strong>do not accept</strong> returns or exchanges for international orders.</p>

                    <h4 class="text-primary mt-4">7. Policy Updates</h4>
                    <p>Leaars reserves the right to modify this Returns and Exchanges Policy at any time. Changes will be posted on our website, and it is the customer's responsibility to review the policy periodically.</p>

                    <h4 class="text-primary mt-4">8. Contact Information</h4>
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
