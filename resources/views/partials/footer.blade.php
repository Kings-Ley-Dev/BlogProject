<footer class="bg-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-blog me-2 text-warning"></i>Laravel Blog
                </h5>
                <p class="text-white-50">
                    Discover amazing articles, tutorials, and insights about technology, 
                    programming, and modern web development. Join our community of passionate 
                    developers and learners.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white fs-5"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-github"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="fw-bold mb-3 text-warning">Quick Links</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('home') }}" class="text-white text-decoration-none">
                            <i class="fas fa-home me-2"></i>Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('blog.index') }}" class="text-white text-decoration-none">
                            <i class="fas fa-newspaper me-2"></i>Blog
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none">
                            <i class="fas fa-info-circle me-2"></i>About
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none">
                            <i class="fas fa-envelope me-2"></i>Contact
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none">
                            <i class="fas fa-shield-alt me-2"></i>Privacy Policy
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="fw-bold mb-3 text-warning">Categories</h6>
                <div class="row">
                    @php
                        $footerCategories = \App\Models\Category::withCount(['posts' => function($query) {
                            $query->where('published', true);
                        }])->orderBy('posts_count', 'desc')->take(6)->get();
                    @endphp
                    
                    @foreach($footerCategories as $category)
                    <div class="col-6 mb-2">
                        <a href="{{ route('blog.category', $category->slug) }}" 
                           class="text-white text-decoration-none small">
                            <i class="fas fa-folder me-1"></i>
                            {{ $category->name }}
                            <span class="badge bg-warning text-dark ms-1">{{ $category->posts_count }}</span>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="fw-bold mb-3 text-warning">Newsletter</h6>
                <p class="text-white-50 small mb-3">
                    Subscribe to our newsletter to get the latest updates and articles.
                </p>
                <form action="#" method="POST" class="mb-3">
                    <div class="input-group">
                        <input type="email" class="form-control form-control-sm" 
                               placeholder="Your email" required>
                        <button class="btn btn-warning btn-sm" type="submit">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
                <div class="d-flex align-items-center text-white small">
                    <i class="fas fa-users me-2"></i>
                    <span>Join {{ \App\Models\User::count() }}+ subscribers</span>
                </div>
            </div>
        </div>

        <hr class="my-4 bg-secondary">

        <!-- Bottom Footer -->
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-white-50 mb-0">
                    &copy; {{ date('Y') }} Kingsley's Blog. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="d-flex justify-content-md-end justify-content-center gap-3">
                    <a href="#" class="text-white text-decoration-none small">
                        <i class="fas fa-shield-alt me-1"></i>Privacy
                    </a>
                    <a href="#" class="text-white text-decoration-none small">
                        <i class="fas fa-file-contract me-1"></i>Terms
                    </a>
                    <a href="#" class="text-white text-decoration-none small">
                        <i class="fas fa-question-circle me-1"></i>Help
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <button id="scrollToTop" class="btn btn-warning rounded-circle shadow" 
            style="position: fixed; bottom: 20px; right: 20px; display: none;">
        <i class="fas fa-arrow-up"></i>
    </button>
</footer>

@push('scripts')
<script>
    // Scroll to Top functionality
    const scrollButton = document.getElementById('scrollToTop');
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollButton.style.display = 'block';
        } else {
            scrollButton.style.display = 'none';
        }
    });

    scrollButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>
@endpush

@push('styles')
<style>
    footer a {
        transition: all 0.3s ease;
    }
    
    footer a:hover {
        color: #ffc107 !important; /* Yellow on hover */
        transform: translateX(2px);
    }
    
    #scrollToTop {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        transition: all 0.3s ease;
    }
    
    #scrollToTop:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
    }
    
    .badge {
        font-size: 0.6em;
        padding: 0.25em 0.5em;
    }
    
    .input-group {
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }
    
    .input-group .form-control {
        border: none;
        padding: 0.5rem 1rem;
    }
    
    .input-group .btn {
        border: none;
        padding: 0.5rem 1rem;
    }
</style>
@endpush

