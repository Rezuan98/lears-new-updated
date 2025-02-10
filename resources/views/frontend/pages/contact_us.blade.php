
@extends('frontend.master.master')
@section('keyTitle','Contact Us')
@push('ecomjs')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');
        const buttonText = submitBtn.querySelector('.button-text');
        const spinner = submitBtn.querySelector('.spinner-border');
        const toast = new bootstrap.Toast(document.getElementById('messageToast'));
    
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
    
            // Show loading state
            submitBtn.disabled = true;
            buttonText.textContent = 'Sending...';
            spinner.classList.remove('d-none');
    
            try {
                const formData = new FormData(form);
                const response = await fetch('/messages', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                });
    
                const data = await response.json();
                
                const toastElement = document.querySelector('.toast-body');
                if (data.success) {
                    // Success handling
                    toastElement.textContent = data.message;
                    document.getElementById('messageToast').classList.add('bg-success', 'text-white');
                    form.reset();
                } else {
                    // Error handling
                    toastElement.textContent = data.message;
                    document.getElementById('messageToast').classList.add('bg-danger', 'text-white');
                }
                toast.show();
    
            } catch (error) {
                console.error('Error:', error);
                document.querySelector('.toast-body').textContent = 'An error occurred. Please try again.';
                document.getElementById('messageToast').classList.add('bg-danger', 'text-white');
                toast.show();
            } finally {
                // Reset button state
                submitBtn.disabled = false;
                buttonText.textContent = 'Send Message';
                spinner.classList.add('d-none');
            }
        });
    
        // Form validation
        Array.from(form.elements).forEach(element => {
            element.addEventListener('input', function() {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });
        });
    });
    </script> 
@endpush
@section('contents')
<!-- Hero Section with Shapes -->
<section style="background-color: rgba(118, 47, 41, 0.961)" class="contact-hero position-relative overflow-hidden  text-white py-5">
    <div class="shape-blob1"></div>
    <div class="shape-blob2"></div>
    <div class="container py-5">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8 position-relative">
                <h1 class="display-4 fw-bold mb-4">Get In Touch</h1>
                <p class="lead mb-0">Have questions? We're here to help and answer any question you might have.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info Cards -->
<section class="contact-info position-relative">
    <div class="container">
        <div class="row g-4 mt-n5">
            <!-- Address Card -->
            <div class="col-md-4">
                <div class="contact-card h-100 bg-white rounded-3 shadow-sm p-4 text-center">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h5>Our Location</h5>
                    <p class="mb-0">{{ $settings->address }}</p>
                </div>
            </div>
            
            <!-- Phone Card -->
            <div class="col-md-4">
                <div class="contact-card h-100 bg-white rounded-3 shadow-sm p-4 text-center">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h5>Phone Number</h5>
                    <p class="mb-0">{{ $settings->phone }}</p>
                </div>
            </div>
            
            <!-- Email Card -->
            <div class="col-md-4">
                <div class="contact-card h-100 bg-white rounded-3 shadow-sm p-4 text-center">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h5>Email Address</h5>
                    <p class="mb-0">{{ $settings->email }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="contact-form-section py-5">
    <div class="container py-4">
        <div class="row g-5">
            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="contact-form-wrapper bg-white rounded-3 shadow-sm p-4 p-lg-5">
                    <h3 class="mb-4">Send us a Message</h3>
                    <form id="contactForm" class="needs-validation" novalidate>
                        @csrf
                        <div class="row g-3">
                            <!-- Name -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                                    <label for="name">Your Name</label>
                                    <div class="invalid-feedback">Please enter your name</div>
                                </div>
                            </div>
                    
                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                                    <label for="email">Your Email</label>
                                    <div class="invalid-feedback">Please enter a valid email</div>
                                </div>
                            </div>
                    
                            <!-- Phone -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Your Phone" required>
                                    <label for="phone">Your Phone</label>
                                    <div class="invalid-feedback">Please enter your phone number</div>
                                </div>
                            </div>
                    
                            <!-- Subject -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
                                    <label for="subject">Subject</label>
                                    <div class="invalid-feedback">Please enter a subject</div>
                                </div>
                            </div>
                    
                            <!-- Message -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="message" name="message" style="height: 150px" placeholder="Message" required></textarea>
                                    <label for="message">Message</label>
                                    <div class="invalid-feedback">Please enter your message</div>
                                </div>
                            </div>
                    
                            <!-- Submit Button -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill" id="submitBtn">
                                    <span class="button-text">Send Message</span>
                                    <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Toast Notification -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="messageToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Notification</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>
</div>
                </div>
            </div>
            
            <!-- Map -->
            <div class="col-lg-5">
                <div class="map-wrapper bg-white rounded-3 shadow-sm p-3 h-100">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d233668.38703692693!2d90.27923991057244!3d23.780573258035957!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8b087026b81%3A0x8fa563bbdd5904c2!2sDhaka!5e0!3m2!1sen!2sbd!4v1642432267610!5m2!1sen!2sbd"
                        class="w-100 h-100 rounded"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('ecommcss')
    

<style>
/* Custom shape blobs */
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
    animation: blob-float 8s infinite ease-in-out;
}

.shape-blob2 {
    width: 300px;
    height: 300px;
    bottom: -150px;
    left: -150px;
    animation: blob-float 12s infinite ease-in-out reverse;
}

/* Icon wrapper styles */
.icon-wrapper {
    width: 60px;
    height: 60px;
    background: rgba(13, 110, 253, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: #0d6efd;
    font-size: 24px;
}

/* Animations */
@keyframes blob-float {
    0%, 100% {
        transform: translate(0, 0);
    }
    50% {
        transform: translate(20px, 20px);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .contact-hero {
        padding: 3rem 0;
    }
    
    .shape-blob1,
    .shape-blob2 {
        display: none;
    }
    
    .contact-form-wrapper,
    .map-wrapper {
        padding: 1.5rem !important;
    }
}

/* Hover effects */
.contact-card {
    transition: transform 0.3s ease;
}

.contact-card:hover {
    transform: translateY(-5px);
}

.btn-primary {
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
}

/* Form styling */
.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-floating > label {
    color: #6c757d;
}

/* Map wrapper responsive height */
@media (min-width: 992px) {
    .map-wrapper {
        height: 100%;
        min-height: 500px;
    }
}

@media (max-width: 991px) {
    .map-wrapper {
        height: 400px;
    }
}
</style>

@endpush