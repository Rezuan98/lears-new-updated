@extends('frontend.master.master')
@section('keyTitle','About Us')
@push('ecomcss')
    <style>
/* Animated background shapes */
.shape-blob1,
.shape-blob2 {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.shape-blob1 {
    width: 200px;
    height: 200px;
    top: -100px;
    right: -100px;
    animation: float 8s infinite ease-in-out;
}
.hero-section {

    background-color: #6b2b2b
}
.shape-blob2 {
    width: 300px;
    height: 300px;
    bottom: -150px;
    left: -150px;
    animation: float 12s infinite ease-in-out reverse;
}

@keyframes float {
    0%, 100% {
        transform: translate(0, 0);
    }
    50% {
        transform: translate(20px, 20px);
    }
}

/* Decorative elements */
.decorative-circle {
    position: absolute;
    width: 200px;
    height: 200px;
    background: rgba(var(--bs-primary-rgb), 0.1);
    border-radius: 50%;
    bottom: -50px;
    right: -50px;
    z-index: -1;
}

/* Card hover effects */
.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

/* Value icons */
.value-icon {
    width: 80px;
    height: 80px;
    background: rgba(var(--bs-primary-rgb), 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

/* Process steps */
.step-number span {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .shape-blob1,
    .shape-blob2 {
        display: none;
    }
    
    .hero-section {
        padding: 3rem 0;
    }
}

/* Image enhancements */
.image-wrapper {
    position: relative;
    z-index: 1;
}

.image-wrapper img {
    transition: transform 0.3s ease;
}

.image-wrapper:hover img {
    transform: scale(1.05);
}
</style>
@endpush











@section('contents')
<!-- Hero Section with Dynamic Shapes -->
<section class="hero-section position-relative overflow-hidden  text-white py-5">
    <!-- Animated background shapes -->
    <div class="shape-blob1"></div>
    <div class="shape-blob2"></div>
    
    <div class="container py-5 position-relative">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">Crafting Leather Excellence</h1>
                <p class="lead mb-0">Since 2010, we've been dedicated to creating premium leather goods that combine traditional craftsmanship with modern design sensibilities.</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="story-section py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 position-relative">
                <div class="image-wrapper rounded-3 overflow-hidden shadow-lg">
                    <img src="/public//frontend/images/factory.jpg" alt="Our Workshop" class="img-fluid">
                </div>
                <div class="decorative-circle"></div>
            </div>
            <div class="col-lg-6">
                <h2 class="display-6 mb-4">Our Story</h2>
                <p class="lead text-muted">Founded by master craftsmen with decades of experience, Leaars began as a small workshop dedicated to creating handcrafted leather wallets.</p>
                <p class="mb-4">Today, we've grown into a premium leather goods brand, but our commitment to quality and craftsmanship remains unchanged. Every piece that leaves our workshop is a testament to our dedication to excellence.</p>
                <div class="row g-4 mt-4">
                    <div class="col-6">
                        <div class="achievement-card p-4 bg-light rounded-3">
                            <h3 class="h2 mb-2">10+</h3>
                            <p class="mb-0">Years of Excellence</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="achievement-card p-4 bg-light rounded-3">
                            <h3 class="h2 mb-2">50k+</h3>
                            <p class="mb-0">Happy Customers</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Values Section -->
<section class="values-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-6">Our Values</h2>
            <p class="lead text-muted">What sets us apart in the world of leather craftsmanship</p>
        </div>
        
        <div class="row g-4">
            <!-- Quality -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="value-icon mb-3">
                            <i style="color: #6b2b2b;" class="fas fa-award fa-2x "></i>
                        </div>
                        <h3 class="h4 mb-3">Premium Quality</h3>
                        <p class="text-muted mb-0">We use only the finest full-grain leather and premium materials in our products, ensuring lasting quality and beauty.</p>
                    </div>
                </div>
            </div>
            
            <!-- Craftsmanship -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="value-icon mb-3">
                            <i style="color: #6b2b2b;" class="fas fa-hands fa-2x "></i>
                        </div>
                        <h3 class="h4 mb-3">Expert Craftsmanship</h3>
                        <p class="text-muted mb-0">Each piece is handcrafted by skilled artisans who bring years of experience and dedication to their work.</p>
                    </div>
                </div>
            </div>
            
            <!-- Sustainability -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="value-icon mb-3">
                            <i style="color: #6b2b2b;" class="fas fa-leaf fa-2x "></i>
                        </div>
                        <h3 class="h4 mb-3">Sustainability</h3>
                        <p class="text-muted mb-0">We're committed to ethical sourcing and sustainable production methods that respect our environment.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Craftsmanship Process -->
<section class="process-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-6">Our Craftsmanship Process</h2>
            <p class="lead text-muted">How we create our leather masterpieces</p>
        </div>
        
        <div class="row g-4">
            <!-- Step 1 -->
            <div class="col-md-3">
                <div class="process-step text-center">
                    <div class="step-number mb-3">
                        <span style="background-color: #f8a9a0cf;" class="h5 text-white rounded-circle d-inline-block p-3">01</span>
                    </div>
                    <h3 class="h5 mb-3">Material Selection</h3>
                    <p class="text-muted">Carefully selecting the finest full-grain leather from ethical sources</p>
                </div>
            </div>
            
            <!-- Step 2 -->
            <div class="col-md-3">
                <div class="process-step text-center">
                    <div class="step-number mb-3">
                        <span style="background-color: #f8a9a0cf;" class="h5  text-white rounded-circle d-inline-block p-3">02</span>
                    </div>
                    <h3 class="h5 mb-3">Pattern Cutting</h3>
                    <p class="text-muted">Precision cutting following traditional patterns and techniques</p>
                </div>
            </div>
            
            <!-- Step 3 -->
            <div class="col-md-3">
                <div class="process-step text-center">
                    <div class="step-number mb-3">
                        <span style="background-color: #f8a9a0cf;" class="h5  text-white rounded-circle d-inline-block p-3">03</span>
                    </div>
                    <h3 class="h5 mb-3">Hand Stitching</h3>
                    <p class="text-muted">Meticulous stitching by our skilled craftsmen</p>
                </div>
            </div>
            
            <!-- Step 4 -->
            <div class="col-md-3">
                <div class="process-step text-center">
                    <div class="step-number mb-3">
                        <span style="background-color: #f8a9a0cf" class="h5 text-white rounded-circle d-inline-block p-3">04</span>
                    </div>
                    <h3 class="h5 mb-3">Quality Check</h3>
                    <p class="text-muted">Rigorous inspection of every piece before shipping</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- <!-- Team Section -->
<section class="team-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-6">Meet Our Artisans</h2>
            <p class="lead text-muted">The skilled hands behind our craftsmanship</p>
        </div>
        
        <div class="row g-4">
            <!-- Team Member 1 -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <img src="/frontend/images/master1.jpg" class="card-img-top" alt="Team Member">
                    <div class="card-body text-center p-4">
                        <h3 class="h5 mb-2">John Doe</h3>
                        <p class="text-muted mb-3">Master Craftsman</p>
                        <p class="small text-muted">Over 20 years of experience in leather crafting</p>
                    </div>
                </div>
            </div>
            
            <!-- Team Member 2 -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <img src="/public//frontend/images/master2.jpg" class="card-img-top" alt="Team Member">
                    <div class="card-body text-center p-4">
                        <h3 class="h5 mb-2">Jane Smith</h3>
                        <p class="text-muted mb-3">Design Lead</p>
                        <p class="small text-muted">Bringing modern design to traditional craft</p>
                    </div>
                </div>
            </div>
            
            <!-- Team Member 3 -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <img src="/frontend/images/master4.png" class="card-img-top" alt="Team Member">
                    <div class="card-body text-center p-4">
                        <h3 class="h5 mb-2">Mike Johnson</h3>
                        <p class="text-muted mb-3">Quality Control</p>
                        <p class="small text-muted">Ensuring the highest standards in every piece</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}


@endsection