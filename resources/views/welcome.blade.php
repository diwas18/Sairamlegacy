@extends('layouts.master')

@section('content')
<style>
    /* Custom scrollbar for categories if needed */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none; /* IE and Edge */
        scrollbar-width: none; /* Firefox */
    }

    /* Custom slick dots styling (will not be used if featured-carousel is removed, but kept for completeness if it's re-added later) */
    .slick-dots li button:before {
        font-size: 10px;
        color: #800020; /* Your primary color */
        opacity: 0.5;
    }
    .slick-dots li.slick-active button:before {
        color: #D4AF37; /* Your secondary color */
        opacity: 1;
    }
    .slick-prev:before, .slick-next:before {
        color: #800020 !important; /* Your primary color for arrows */
        font-size: 30px !important;
    }
</style>

<div class="px-6 md:px-16 py-8 bg-gray-50 min-h-screen">
    <div class="relative h-[70vh] md:h-[85vh] w-full rounded-lg overflow-hidden shadow-lg mb-12 flex items-center justify-between bg-gray-200">

        <div class="z-10 w-full md:w-1/2 px-6 md:px-16 space-y-6">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight tracking-wide">
                GIORDANO<br>GLASSES
            </h1>
            <p class="text-base md:text-lg text-gray-700 max-w-md">
                An original eyewear collection from the world-renowned American designer, featuring sun and optical styles for men and women.
            </p>
            <a href="#products"
               class="inline-block bg-[#800020] hover:bg-[#6b001a] text-white font-semibold text-sm md:text-base px-6 py-3 rounded-full shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5">
                Shop Now
            </a>
            {{-- NEW: Added a direct CTA to visit the store/book an appointment --}}
            <a href="#our-store"
               class="inline-block border border-[#800020] text-[#800020] font-semibold text-sm md:text-base px-6 py-3 rounded-full shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5 ml-4">
                Visit Our Store
            </a>
        </div>

        <div class="hidden md:block w-1/2 h-full -ml-10 ">
            <img src="{{ asset('images/banner.png') }}" alt="Giordano Model"
                 class="w-full h-full object-cover object-center rounded-l-lg">
        </div>

    </div>

    <div class="my-16">
    <div class="border-l-4 border-[#800020] pl-3 mb-8">
        <h2 class="text-3xl font-semibold text-[#4B2E0A] tracking-wide mb-1">Our Eye Care Services</h2>
        <p class="text-[#800020] text-sm font-medium">Beyond just glasses, we care for your vision</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-1 transition duration-300 cursor-pointer flex flex-col items-center">
            {{-- OPTION 1: Larger fixed size (e.g., w-32 h-32 = 128px x 128px) --}}
            <img src="{{ asset('images/eye exam.jpg') }}" alt="Comprehensive Eye Exam" class="w-32 h-32 mb-4 object-contain" loading="lazy">
            {{-- OPTION 2: If images are icons and should scale with padding, use something like w-24 h-24 with more padding around the image container, or let it scale freely. 'object-contain' is good to prevent cropping. --}}
            {{-- <img src="{{ asset('images/eye exam.jpg') }}" alt="Comprehensive Eye Exam" class="w-28 h-28 mb-4 object-contain" loading="lazy"> --}}

            <h3 class="text-xl font-bold text-[#800020] mb-2">Comprehensive Eye Exams</h3>
            <p class="text-gray-700 text-sm">Professional check-ups by certified optometrists for clear vision and eye health.</p>
            <a href="#book-appointment" class="mt-4 text-[#D4AF37] hover:underline font-semibold">Book Now</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-1 transition duration-300 cursor-pointer flex flex-col items-center">
            {{-- Using w-32 h-32 here for consistency with the first option --}}
            <img src="{{ asset('images/fitt.jpg') }}" alt="Personalized Glasses Fitting" class="w-32 h-32 mb-4 object-contain" loading="lazy">
            <h3 class="text-xl font-bold text-[#800020] mb-2">Personalized Fittings & Adjustments</h3>
            <p class="text-gray-700 text-sm">Get the perfect fit for ultimate comfort and vision clarity, available in-store.</p>
            <a href="#our-store" class="mt-4 text-[#D4AF37] hover:underline font-semibold">Learn More</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-1 transition duration-300 cursor-pointer flex flex-col items-center">
            {{-- Using w-32 h-32 here for consistency with the first option --}}
            <img src="{{ asset('images/virtualtryon.jpg') }}" alt="Virtual Try-On" class="w-32 h-32 mb-4 object-contain" loading="lazy">
            <h3 class="text-xl font-bold text-[#800020] mb-2">Virtual Try-On (Online)</h3>
            <p class="text-gray-700 text-sm">Experiment with different styles from home before visiting our store or buying online.</p>
            <a href="#products" class="mt-4 text-[#D4AF37] hover:underline font-semibold">Try It Now</a>
        </div>
    </div>
</div>

    <div id="book-appointment" class="my-16 bg-[#FDF9ED] p-8 rounded-xl shadow-lg text-center border border-[#D4AF37]">
        <h2 class="text-3xl font-bold text-[#4B2E0A] mb-4">Ready for an Eye Check-up?</h2>
        <p class="text-lg text-gray-700 mb-6 max-w-3xl mx-auto">
            Book an appointment online for a comprehensive eye exam or a personalized glasses fitting at our Malangawa store.
        </p>
        <a href="YOUR_APPOINTMENT_BOOKING_PAGE_URL"
           class="inline-block bg-[#800020] hover:bg-[#6b001a] text-white font-semibold text-lg px-8 py-4 rounded-full shadow-xl hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
            Book Your Appointment Now
        </a>
        <p class="mt-4 text-sm text-gray-600">Appointments available Monday - Saturday, 9 AM - 6 PM.</p>
    </div>

    <div id="products" class="border-l-4 border-[#800020] pl-3 mb-6 mt-16">
        <h1 class="text-3xl font-semibold text-[#4B2E0A] tracking-wide mb-1">Latest Products</h1>
        <p class="text-[#800020] text-sm font-medium">Discover our newest elegant collection</p>
    </div>



    <div id="product-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @include('partials.product_cards') {{-- partial with product cards only --}}
    </div>

    <div class="text-center mt-10">
        <button id="loadMoreBtn" class="bg-[#D4AF37] hover:bg-[#c39f2c] text-[#4B2E0A] px-8 py-3 rounded-lg shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5">
            Load More
        </button>
    </div>

    <div class="mt-10 text-center">
        {{ $products->appends(request()->query())->links('pagination::tailwind') }}
    </div>

    <div id="our-store" class="my-16 bg-white p-8 rounded-xl shadow-2xl border border-gray-100">
        <div class="border-l-4 border-[#800020] pl-3 mb-8">
            <h2 class="text-3xl font-semibold text-[#4B2E0A] tracking-wide mb-1">Visit Our Store in Geetanagar</h2>
            <p class="text-[#800020] text-sm font-medium">Experience personalized service and find your perfect pair</p>
        </div>
       <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Left Column: Store Info -->
    <div>
        <p class="text-lg text-gray-700 mb-4">
            We invite you to our physical store in <strong>Geetanagar, Bharatpur, Chitwan, Nepal</strong>, for a personalized experience.
            Get expert advice, precise fittings, and explore our full collection firsthand.
        </p>

        <div class="space-y-3 text-gray-800 mb-6">
            <p class="flex items-center text-lg"><i class="fas fa-map-marker-alt text-[#800020] mr-3"></i>
                <strong>Address:</strong> Sairam Chasma Pasal, Bharatpur-11, Chitwan, Nepal</p>
            <p class="flex items-center text-lg"><i class="fas fa-phone-alt text-[#800020] mr-3"></i>
                <strong>Phone:</strong> <a href="tel:+9779800000000" class="text-[#800020] hover:underline">+977 9800000000</a></p>
            <p class="flex items-center text-lg"><i class="fas fa-clock text-[#800020] mr-3"></i>
                <strong>Store Hours:</strong> Sunday - Friday, 9:00 AM - 6:00 PM (Nepal Time)</p>
            <p class="flex items-center text-lg"><i class="fas fa-envelope text-[#800020] mr-3"></i>
                <strong>Email:</strong> <a href="sairamlegacylegacy7@gmail.com" class="text-[#800020] hover:underline">info@giordanoglasses.com</a></p>
        </div>

        <!-- In-Store Availability Check -->
        <div class="bg-[#FDF9ED] p-4 rounded-lg border border-[#D4AF37] text-gray-800 mb-6">
            <h4 class="font-semibold text-lg mb-2">Check In-Store Availability</h4>
            <p class="text-sm mb-3">Found a pair you love online? Verify if it's available at our Geetanagar store for immediate pickup or try-on!</p>
            <a href="#" class="inline-block bg-[#D4AF37] hover:bg-[#c39f2c] text-[#4B2E0A] px-6 py-2 rounded-full text-sm font-semibold transition duration-300">
                Check Product Stock
            </a>
        </div>

        <!-- Get Directions Button -->
        <a href="https://www.google.com/maps/search/?api=1&query=Geetanagar+Chasma+Pasal,+Bharatpur,+Nepal" target="_blank"
           class="inline-block bg-[#800020] hover:bg-[#6b001a] text-white font-semibold text-base px-6 py-3 rounded-full shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-0.5 mt-4">
            Get Directions
        </a>
    </div>

    <!-- Right Column: Map & Images -->
    <div>
        <!-- Embedded Google Map -->
        <div class="aspect-w-16 aspect-h-9 w-full rounded-lg overflow-hidden shadow-xl mb-4">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3535.2525411255083!2d84.38704787550634!3d27.616694176234663!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3994f18364658f13%3A0x67271c075b6e3d5a!2sGeetanagar%20Chasma%20Pasal!5e0!3m2!1sen!2snp!4v1751724078918!5m2!1sen!2snp"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <!-- Virtual Tour / Store Photos -->
        <div class="grid grid-cols-2 gap-4">
            <img src="{{ asset('images/interior.jpg') }}" alt="Store Interior 1" class="w-full h-auto rounded-lg shadow-md hover:shadow-lg transition duration-300" loading="lazy">
            <img src="{{ asset('images/exterior.avif') }}" alt="Store Exterior" class="w-full h-auto rounded-lg shadow-md hover:shadow-lg transition duration-300" loading="lazy">
        </div>

        <p class="text-sm text-gray-600 mt-4 text-center">
            Take a virtual tour: <a href="YOUR_VIRTUAL_TOUR_LINK" class="text-[#D4AF37] hover:underline" target="_blank">Explore Our Store 360°</a>
        </p>
    </div>
</div>

    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 mt-16 text-center text-[#4B2E0A]">
        <div class="flex flex-col items-center space-y-3 p-4 bg-white rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-1 transition duration-300 cursor-pointer">
            <img src="{{ asset('images/transport.png') }}" alt="Free Shipping" class="w-16 h-16 mx-auto mb-2" loading="lazy">
            <p class="text-base font-semibold text-[#800020]">Free Shipping</p>
            <p class="text-sm text-gray-600">On all orders above Rs. 2000</p>
        </div>
        <div class="flex flex-col items-center space-y-3 p-4 bg-white rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-1 transition duration-300 cursor-pointer">
            <img src="{{ asset('images/easy-return.png') }}" alt="Easy 7-day Returns" class="w-16 h-16 mx-auto mb-2" loading="lazy">
            <p class="text-base font-semibold text-[#800020]">Easy 7-day Returns</p>
            <p class="text-sm text-gray-600">Hassle-free returns & exchanges</p>
        </div>
        <div class="flex flex-col items-center space-y-3 p-4 bg-white rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-1 transition duration-300 cursor-pointer">
            <img src="{{ asset('images/secure-payment.png') }}" alt="Secure Checkout" class="w-16 h-16 mx-auto mb-2" loading="lazy">
            <p class="text-base font-semibold text-[#800020]">Secure Checkout</p>
            <p class="text-sm text-gray-600">100% secure payment options</p>
        </div>
        <div class="flex flex-col items-center space-y-3 p-4 bg-white rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-1 transition duration-300 cursor-pointer">
            <img src="{{ asset('images/customer-care.png') }}" alt="24/7 Support" class="w-16 h-16 mx-auto mb-2" loading="lazy">
            <p class="text-base font-semibold text-[#800020]">24/7 Support</p>
            <p class="text-sm text-gray-600">Dedicated customer assistance</p>
        </div>
    </div>

    <div class="mt-16 bg-white p-8 rounded-xl shadow-2xl text-center max-w-2xl mx-auto border border-gray-100">
        <p class="text-xl italic text-gray-800 max-w-xl mx-auto leading-relaxed font-medium">"Absolutely love the quality! Stylish and affordable. Highly recommend!"</p>
        <p class="mt-6 text-base text-[#800020] font-bold tracking-wide">— Apsara Lamsal, Customer</p>
    </div>

</div>

@push('scripts')
{{-- Include Font Awesome for icons --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script>
    // Load More Products Logic
    let nextPage = 2;
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const lastPage = {{ $products->lastPage() }};

    if (loadMoreBtn) { // Ensure button exists before adding listener
        loadMoreBtn.addEventListener('click', function() {
            let category = '{{ request("category") }}';
            let priceMin = '{{ request("price_min") }}';
            let priceMax = '{{ request("price_max") }}';
            let sort = '{{ request("sort") }}';

            let queryParams = `page=${nextPage}`;
            if (category) queryParams += `&category=${category}`;
            if (priceMin) queryParams += `&price_min=${priceMin}`;
            if (priceMax) queryParams += `&price_max=${priceMax}`;
            if (sort) queryParams += `&sort=${sort}`;

            fetch(window.location.pathname + `?${queryParams}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                if (html.trim() === '') {
                    loadMoreBtn.textContent = 'No more products';
                    loadMoreBtn.disabled = true;
                    loadMoreBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    document.getElementById('product-list').insertAdjacentHTML('beforeend', html);
                    nextPage++;
                    if(nextPage > lastPage) {
                        loadMoreBtn.textContent = 'No more products';
                        loadMoreBtn.disabled = true;
                        loadMoreBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                }
            })
            .catch(() => {
                loadMoreBtn.textContent = 'Error loading products';
                loadMoreBtn.disabled = true;
                loadMoreBtn.classList.add('opacity-50', 'cursor-not-allowed');
            });
        });

        // Initially hide load more button if only one page
        if (lastPage <= 1) {
            loadMoreBtn.style.display = 'none';
        }
    }
</script>
@endpush
@endsection
