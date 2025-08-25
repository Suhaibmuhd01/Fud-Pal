<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUD Pal - Your Campus Companion</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                colors: {
                    primary: '#10B981',
                    secondary: '#D97706',
                    danger: '#EF4444',
                    dark: {
                        primary: '#065F46',
                        secondary: '#B45309',
                    }
                },
                animation: {
                    'bounce-slow': 'bounce 3s infinite',
                    'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                }
            }
        }
    }
    // Dark mode detection
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.documentElement.classList.add('dark');
    }
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
        if (event.matches) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    });
    </script>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
    }

    .menu-slide {
        transition: transform 0.3s ease-in-out;
    }

    .notification-dot {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 8px;
        height: 8px;
        background-color: #EF4444;
        border-radius: 50%;
    }

    .spinner {
        animation: spinner 0.6s linear infinite;
    }

    @keyframes spinner {
        to {
            transform: rotate(360deg);
        }
    }

    .hamburger {
        cursor: pointer;
        width: 24px;
        height: 24px;
        transition: all 0.25s;
        position: relative;
    }

    .hamburger-top,
    .hamburger-middle,
    .hamburger-bottom {
        position: absolute;
        top: 0;
        left: 0;
        width: 24px;
        height: 2px;
        background: white;
        transform: rotate(0);
        transition: all 0.5s;
    }

    .hamburger-middle {
        transform: translateY(7px);
    }

    .hamburger-bottom {
        transform: translateY(14px);
    }

    .open .hamburger-top {
        transform: rotate(45deg) translateY(6px) translateX(6px);
    }

    .open .hamburger-middle {
        display: none;
    }

    .open .hamburger-bottom {
        transform: rotate(-45deg) translateY(6px) translateX(-6px);
    }

    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .dark body {
        background-color: #1F2937;
        color: #F3F4F6;
    }

    .dark .bg-white {
        background-color: #374151;
    }

    .dark .text-gray-800 {
        color: #E5E7EB;
    }

    .dark .border-gray-200 {
        border-color: #4B5563;
    }

    /* Responsive fixes */
    @media (max-width: 768px) {
        .header-login-btns {
            flex-direction: column;
            gap: 0.5rem;
        }

        .header-login-btns a {
            width: 40%;
            text-align: center;
        }
    }

    @media (max-width: 640px) {
        .hero-img-container {
            max-width: 90vw;
        }

        .hero-img-bg {
            width: 100vw !important;
        }
    }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900">

    <!-- Header -->
    <header class="bg-green-600 text-white sticky top-0 z-30">
        <div class="container mx-auto px-3 p-2 flex justify-between items-center">
            <div class="flex items-center">

                <div class="flex items-center">
                    <div class="mr-2 relative">
                        <img src="./assets/images/FudPal.png"
                            class="h-20 w-20 rounded-full bg-white p-1 shadow object-contain" alt="FudPal Logo">
                        <!-- <i class="fas fa-users text-xl"></i> -->
                    </div>
                    <h1 class="text-2xl font-bold">FudPal</h1>
                </div>
            </div>
            <div class="flex items-center space-x-4 header-login-btns">
                <a href="login.php"
                    class="bg-white text-green-600 hover:bg-green-100 py-1 px-4 rounded-full font-medium transition whitespace-nowrap">Login</a>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section
            class="py-8 px-4 md:py-20 bg-green-600 text-white relative overflow-hidden min-h-[260px] sm:min-h-[320px] md:min-h-[400px]">
            <div class="container mx-auto flex flex-col md:flex-row items-center justify-between relative z-10">
                <div class="md:w-1/2 z-10" data-aos="fade-right" data-aos-duration="1000">
                    <h2 class="text-4xl md:text-5xl font-bold mb-4">Welcome To<br>
                        <span class="text-5xl md:text-6xl">FUDPAL!</span>
                    </h2>
                    <p class="text-xl mb-8">Your Go-To For Everything You Need In The FUD Campus!</p>
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-6">
                        <a href="signup.php"
                            class="bg-white text-green-600 hover:bg-green-100 py-3 px-8 rounded-full font-semibold text-lg inline-block transition">Get
                            Started</a>
                        <a href="login.php"
                            class="bg-transparent border-2 border-white hover:bg-green-700 py-3 px-8 rounded-full font-semibold text-lg inline-block transition text-white">Login</a>
                    </div>
                </div>
            </div>
            <!-- Decorative white circle background behind image -->
            <div class="absolute right-0 bottom-0 z-10 flex items-end" style="margin-right: 0; height: 100%;">
                <div class="bg-white !bg-white rounded-full flex items-end justify-end"
                    style="height: 100%; width: 100%;">
                    <img src="assets/images/gencraft_image.png" alt="Students on campus"
                        class="object-contain object-bottom h-[200px] sm:h-[240px] md:h-[320px] lg:h-[380px] xl:h-[420px] w-auto max-w-[65vw] md:max-w-[48vw]" />
                </div>
            </div>
        </section>

        <!-- Daily Dose Section -->
        <section class="py-12 px-4">
            <div class="container mx-auto">
                <h2 class="text-3xl font-bold text-center mb-8 text-green-600">
                    <i class="fas fa-newspaper mr-2"></i> DAILY DOSE!
                </h2>
                <div class="owl-carousel daily-dose-carousel">
                    <div class="flex justify-center">
                        <div
                            class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden card-hover w-full max-w-xs sm:max-w-sm md:max-w-md mx-auto flex flex-col">
                            <div class="bg-green-600 py-4 px-6 text-white text-center rounded-t-3xl">
                                <h3 class="font-bold text-lg">Let's Get It!</h3>
                            </div>
                            <div class="p-6 flex-1 flex items-center justify-center text-center">
                                <p class="text-gray-700 dark:text-gray-300">
                                    The FUD Library has extended its opening hours for the examination period. Now open
                                    from 8AM to 10PM daily to accommodate your study needs.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Another slider section (2) -->
                    <div class="p-2">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden card-hover">
                            <div class="bg-green-600 py-3 px-4 text-white text-center">
                                <h3 class="font-bold">Let's Get It!</h3>
                            </div>
                            <div class="p-6 text-center">
                                <p class="text-gray-700 dark:text-gray-300">
                                    The Department of Computer Science announces a new workshop on AI and Machine
                                    Learning. Register now through this site.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Another slide section (3) -->
                    <div class="p-2">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden card-hover">
                            <div class="bg-green-600 py-3 px-4 text-white text-center">
                                <h3 class="font-bold">Let's Get It!</h3>
                            </div>
                            <div class="p-6 text-center">
                                <p class="text-gray-700 dark:text-gray-300">
                                    Campus Wi-Fi maintenance scheduled for this weekend. Expect intermittent
                                    connectivity in residential areas from Friday evening to Saturday noon.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Daily Buzz Section -->
        <section class="py-12 px-4 bg-gray-100 dark:bg-gray-800">
            <div class="container mx-auto">
                <h2 class="text-3xl font-bold text-center mb-8 text-amber-600 dark:text-amber-500">
                    <i class="fas fa-bullhorn mr-2"></i> DAILY BUZZ!
                </h2>
                <div class="flex flex-col items-center gap-6">
                    <div
                        class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-4 flex items-start space-x-4 transform transition w-[400] hover:scale-[1.01] w-[90%] max-w-3xl">
                        <div class="h-10 w-10 bg-amber-600 rounded-full flex-shrink-0 flex items-center justify-center">
                            <i class="fas fa-info text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-700 dark:text-gray-300 w-full">
                                The Student Union has organized a cultural day event for next week. Come celebrate the
                                diversity of cultures within FUD community with food, music, and traditional attire.
                            </p>
                            <div class="flex justify-end items-center mt-2 text-gray-500 dark:text-gray-400">
                                <span class="text-sm">10 Mins Ago</span>
                                <i class="fas fa-arrow-right ml-2 text-amber-600"></i>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-4 flex items-start space-x-4 transform transition hover:scale-[1.01] w-[90%] max-w-3xl">
                        <div class="h-10 w-10 bg-amber-600 rounded-full flex-shrink-0 flex items-center justify-center">
                            <i class="fas fa-info text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-700 dark:text-gray-300">
                                Reminder: The deadline for course registration is this Friday. Make sure to complete
                                your registration to avoid late penalties.
                            </p>
                            <div class="flex justify-end items-center mt-2 text-gray-500 dark:text-gray-400">
                                <span class="text-sm">14 Mins Ago</span>
                                <i class="fas fa-arrow-right ml-2 text-amber-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Grid -->
        <section class="py-12 px-4" id="features">
            <div class="container mx-auto">
                <h2 class="text-3xl font-bold text-center mb-2 text-green-600">Our Features</h2>
                <p class="text-center text-gray-600 dark:text-gray-400 mb-12 max-w-2xl mx-auto">
                    Everything you need to navigate campus life at Federal University Dutse
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature cards unchanged -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 card-hover" data-aos="fade-up"
                        data-aos-delay="100">
                        <div
                            class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center text-green-600 dark:text-green-400 mb-4">
                            <i class="fas fa-map-marked-alt text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Interactive Campus Map</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Explore your campus with ease using our interactive map, featuring all important locations
                            and buildings.
                        </p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 card-hover" data-aos="fade-up"
                        data-aos-delay="200">
                        <div
                            class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center text-green-600 dark:text-green-400 mb-4">
                            <i class="fas fa-question-circle text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Past Question Bank</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Access a comprehensive repository of past exam questions to help you prepare for your exams.
                        </p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 card-hover" data-aos="fade-up"
                        data-aos-delay="300">
                        <div
                            class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center text-green-600 dark:text-green-400 mb-4">
                            <i class="fas fa-book text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Student Guidelines</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Navigate the registration process effortlessly with our step-by-step guides for various
                            procedures.
                        </p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 card-hover" data-aos="fade-up"
                        data-aos-delay="400">
                        <div
                            class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center text-green-600 dark:text-green-400 mb-4">
                            <i class="fas fa-bullhorn text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Announcements & Events</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Stay updated on important university announcements, events, and deadlines right on your
                            device.
                        </p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 card-hover" data-aos="fade-up"
                        data-aos-delay="500">
                        <div
                            class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center text-green-600 dark:text-green-400 mb-4">
                            <i class="fas fa-comments text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Community Forum</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Connect with peers, ask questions, and seek guidance from fellow students within the FUD
                            community.
                        </p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 card-hover" data-aos="fade-up"
                        data-aos-delay="600">
                        <div
                            class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center text-green-600 dark:text-green-400 mb-4">
                            <i class="fas fa-bell text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Real-time Notifications</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Get instant notifications for important announcements, events, and updates from your
                            departments.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-12 px-4 bg-green-600 text-white">
            <div class="container mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6" data-aos="fade-up">Ready to Enhance Your Campus
                    Experience?</h2>
                <p class="text-xl mb-8 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    Join thousands of FUD students who are already using FUD Pal to navigate campus life with ease.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-6 justify-center" data-aos="fade-up"
                    data-aos-delay="200">
                    <a href="signup.php"
                        class="bg-white text-green-600 hover:bg-green-100 py-3 px-8 rounded-full font-semibold text-lg inline-block transition">Sign
                        Up Now</a>
                    <a href="login.php"
                        class="bg-transparent hover:bg-green-700 border-2 border-white py-3 px-8 rounded-full font-semibold text-lg inline-block transition">Login</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 px-4">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class="fas fa-users mr-2"></i> FUD Pal
                    </h3>
                    <p class="text-gray-400 mb-4">
                        Your digital companion for navigating campus life at Federal University Dutse.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://facebook.com/" class="text-gray-400 hover:text-blue-600 transition"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/" class="text-gray-400 hover:text-blue-400 transition"><i
                                class="fab fa-twitter"></i></a>
                        <a href="https://instagram.com/" class="text-gray-400 hover:text-pink-500 transition"><i
                                class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="map.php" class="text-gray-400 hover:text-white transition">Campus Map</a></li>
                        <li><a href="past_questions.php" class="text-gray-400 hover:text-white transition">Past
                                Questions</a></li>
                        <li><a href="guidelines.php" class="text-gray-400 hover:text-white transition">Student
                                Guidelines</a></li>
                        <li><a href="faq.php" class="text-gray-400 hover:text-white transition">FAQs</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="https://fud.edu.ng/" class="text-gray-400 hover:text-white transition">FUD Official
                                Website</a></li>
                        <li><a href="https://www.myportal.fud.edu.ng/"
                                class="text-gray-400 hover:text-white transition">Student Portal</a></li>
                        <li><a href="https://fud.edu.ng/index.php/library/"
                                class="text-gray-400 hover:text-white transition">Library</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">E-Learning</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Contact Us</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start"><i class="fas fa-map-marker-alt mt-1 mr-2 text-green-500"></i><span
                                class="text-gray-400">Federal University Dutse, Jigawa State, Nigeria</span></li>
                        <li class="flex items-start"><i class="fas fa-envelope mt-1 mr-2 text-green-500"></i><span
                                class="text-gray-400">support@fudpal.com</span></li>
                        <li class="flex items-start"><i class="fas fa-phone mt-1 mr-2 text-green-500"></i><span
                                class="text-gray-400">+234 901 670 0342</span></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-gray-800 text-center">
                <p class="text-gray-400">&copy; <span id="year"></span> FUD Pal. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script>
    $(document).ready(function() {
        // get current year
        const currentYear = new Date().getFullYear();
        $('#year').text(currentYear);
        // Initialize AOS animation library
        AOS.init();
        // Initialize Owl Carousel
        $('.daily-dose-carousel').owlCarousel({
            loop: true,
            margin: 20,
            nav: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                640: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1024: {
                    items: 3
                }
            },
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>'
            ]
        });
    });
    </script>
</body>

</html>