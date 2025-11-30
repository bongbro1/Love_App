<?php
include __DIR__ . '/../layout/header.php'; ?>
<!-- Hero Section - Ultra Premium -->
<section class="relative py-6 sm:py-8 md:py-8 flex items-center overflow-hidden bg-gradient-to-br from-rose-400 via-pink-500 to-purple-600">

    <!-- Animated Background Particles -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-1/4 left-10 w-3 h-3 bg-white/30 rounded-full animate-bounce [animation-delay:0s] duration-8000"></div>
        <div class="absolute top-1/2 right-10 w-2.5 h-2.5 bg-white/20 rounded-full animate-bounce [animation-delay:2s] duration-6000"></div>
        <div class="absolute bottom-1/4 left-12 w-4 h-4 bg-white/40 rounded-full animate-bounce [animation-delay:4s] duration-7000"></div>
        <div class="absolute bottom-1/2 right-8 w-3 h-3 bg-white/25 rounded-full animate-bounce [animation-delay:6s] duration-5000"></div>

        <div class="absolute top-20 left-1/4 w-1.5 h-1.5 bg-yellow-300/50 rounded-full animate-ping [animation-delay:1s]"></div>
        <div class="absolute bottom-20 right-1/3 w-2 h-2 bg-yellow-200/60 rounded-full animate-ping [animation-delay:3s]"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 md:gap-16 items-center">

            <!-- Left Content -->
            <div class="space-y-6 text-center lg:text-left order-2 lg:order-1">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 text-xs sm:text-sm">
                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                    <span class="text-white font-semibold">💖 15,000+ CẶP ĐÔI ĐÃ TIN DÙNG</span>
                </div>

                <!-- Main Title -->
                <div class="space-y-3">
                    <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight tracking-tight">
                        <span>Kết Nối </span>
                        <span class="bg-gradient-to-r from-yellow-300 to-pink-300 bg-clip-text text-transparent">Tình Yêu</span>
                        <span class="block">Vươn Xa</span>
                    </h1>
                    <p class="text-lg sm:text-xl md:text-2xl text-white/90 font-light max-w-lg mx-auto lg:mx-0">
                        Công nghệ <span class="font-bold text-yellow-300">NFC</span> lưu giữ mọi khoảnh khắc
                    </p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
                    <div class="text-center">
                        <div class="text-2xl sm:text-2xl font-bold text-yellow-300">15K+</div>
                        <div class="text-white/80 text-xs sm:text-sm">Cặp đôi</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-2xl font-bold text-pink-200">80K+</div>
                        <div class="text-white/80 text-xs sm:text-sm">Kỷ niệm</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-2xl font-bold text-white">99.8%</div>
                        <div class="text-white/80 text-xs sm:text-sm">Hài lòng</div>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center lg:justify-start">
                    <a href="/love-app/public/#purchase" class="group inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-white text-rose-600 font-bold rounded-full text-base sm:text-lg shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 transition-all duration-300 hover:scale-105">
                        <span>Đặt Mua Ngay - 799K</span>
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 sm:gap-6 md:pt-4">
                    <div class="flex items-center text-white/70 text-sm">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Đã xác minh
                    </div>
                    <div class="flex items-center text-white/70 text-sm">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        An toàn 100%
                    </div>
                </div>
            </div>

            <!-- Right Image -->
            <div class="relative flex justify-center order-1 lg:order-2 lg:mb-0">
                <div class="relative w-64 h-64 sm:w-80 sm:h-80 md:w-96 md:h-96 animate-float">
                    <svg viewBox="0 0 200 200" class="w-full h-full drop-shadow-2xl">
                        <defs>
                            <linearGradient id="heartGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#ffffff;stop-opacity:1" />
                                <stop offset="50%" style="stop-color:#ffd6e7;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#c084fc;stop-opacity:1" />
                            </linearGradient>
                            <filter id="glow">
                                <feGaussianBlur stdDeviation="3" result="coloredBlur" />
                                <feMerge>
                                    <feMergeNode in="coloredBlur" />
                                    <feMergeNode in="SourceGraphic" />
                                </feMerge>
                            </filter>
                        </defs>
                        <path d="M100,20 A50,50 0 0,1 150,70 A50,50 0 0,1 100,120 A50,50 0 0,1 50,70 A50,50 0 0,1 100,20 Z"
                            fill="url(#heartGrad)" filter="url(#glow)">
                            <animateTransform attributeName="transform" type="rotate" from="0 100 100" to="360 100 100" dur="20s" repeatCount="indefinite" />
                        </path>
                        <circle cx="100" cy="100" r="25" fill="none" stroke="url(#heartGrad)" stroke-width="3" class="animate-pulse">
                            <animate attributeName="r" from="25" to="30" dur="2s" repeatCount="indefinite" values="25;30;25" />
                        </circle>
                        <circle cx="80" cy="60" r="3" fill="#ffd700" class="animate-ping"></circle>
                        <circle cx="120" cy="80" r="2" fill="#ffd700" class="animate-ping" style="animation-delay:0.5s"></circle>
                        <circle cx="90" cy="110" r="3" fill="#ffd700" class="animate-ping" style="animation-delay:1s"></circle>
                    </svg>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Features Section - Premium Cards -->
<section id="features" class="py-8 md:py-12 bg-gradient-to-b from-white via-rose-50 to-pink-50">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-6">
            <!-- Badge with Glow & Pulse -->
            <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-rose-500 via-pink-500 to-purple-500 text-white font-semibold rounded-full mb-6 shadow-lg shadow-rose-500/25">
                <span class="relative">
                    <span class="text-xl mr-2">❤️</span>
                    <span class="relative z-10">6 TÍNH NĂNG ĐỈNH CAO</span>
                </span>
            </div>

            <!-- Title with 3D Effect -->
            <h2 class="relative text-2xl md:text-3xl font-bold mb-2 leading-tight">
                <span class="inline-block">
                    Dành Riêng Cho
                    <!-- 3D Shadow Layer -->
                    <span class="absolute inset-0 bg-gradient-to-r from-rose-500/20 to-purple-500/20 blur opacity-75 -z-10"></span>
                </span>

                <!-- Gradient Highlight -->
                <span class="block mt-2">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-500 via-pink-500 to-purple-600 relative">
                        YÊU GẦN & YÊU XA
                        <!-- Glow Effect -->
                        <span class="absolute inset-0 bg-gradient-to-r from-rose-500/50 via-pink-500/50 to-purple-600/50 blur rounded-lg -z-10"></span>
                    </span>
                </span>
            </h2>
        </div>

        <!-- 6 Features Grid -->
        <div class="grid md:grid-cols-3 gap-4 md:gap-8 max-w-6xl mx-auto">

            <!-- 1. YÊU GẦN: Check-in NFC -->
            <div class="group relative p-8 rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-rose-100 hover:border-rose-300">
                <div class="absolute inset-0 bg-gradient-to-br from-rose-500/5 to-pink-500/5 rounded-2xl opacity-0 group-hover:opacity-100"></div>

                <div class="relative text-center space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-r from-rose-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto group-hover:scale-110 shadow-lg">
                        <span class="text-2xl">📍</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Check-in NFC</h3>
                        <p class="text-gray-600 text-sm">Quét khi gặp - Streak 47 ngày 🔥</p>
                    </div>
                    <div class="bg-rose-50 p-3 rounded-xl">
                        <div class="flex items-center justify-center text-xs text-rose-600">
                            <span class="w-2 h-2 bg-rose-500 rounded-full mr-2 animate-pulse"></span>
                            127 kỷ niệm
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. YÊU GẦN: Love Map -->
            <div class="group relative p-8 rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-emerald-100 hover:border-emerald-300">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 rounded-2xl opacity-0 group-hover:opacity-100"></div>

                <div class="relative text-center space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center mx-auto group-hover:scale-110 shadow-lg">
                        <span class="text-2xl">🗺️</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Love Map</h3>
                        <p class="text-gray-600 text-sm">Bản đồ 127 nơi hẹn hò</p>
                    </div>
                    <div class="bg-emerald-50 p-3 rounded-xl text-center">
                        <div class="text-xs text-emerald-600">Hà Nội • SG • Đà Lạt</div>
                    </div>
                </div>
            </div>

            <!-- 3. YÊU GẦN: Love Challenge -->
            <div class="group relative p-8 rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-yellow-100 hover:border-yellow-300">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/5 to-amber-500/5 rounded-2xl opacity-0 group-hover:opacity-100"></div>

                <div class="relative text-center space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-amber-500 rounded-2xl flex items-center justify-center mx-auto group-hover:scale-110 shadow-lg">
                        <span class="text-2xl">🎯</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Love Challenge</h3>
                        <p class="text-gray-600 text-sm">"Chụp 10 ảnh công viên"</p>
                    </div>
                    <div class="bg-yellow-50 p-3 rounded-xl text-center">
                        <div class="text-xs text-yellow-600">7/10 ❤️</div>
                    </div>
                </div>
            </div>

            <!-- 4. YÊU XA: Chat Realtime -->
            <div class="group relative p-8 rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-purple-100 hover:border-purple-300">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-500/5 rounded-2xl opacity-0 group-hover:opacity-100"></div>

                <div class="relative text-center space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto group-hover:scale-110 shadow-lg">
                        <span class="text-2xl">💌</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Chat Realtime</h3>
                        <p class="text-gray-600 text-sm">Tin nhắn + ảnh + voice ngay lập tức</p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-xl">
                        <div class="flex items-center justify-center text-xs text-purple-600">
                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-2 animate-pulse"></span>
                            Online 3 phút trước
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. YÊU XA: Secret Letter -->
            <div class="group relative p-8 rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-pink-100 hover:border-pink-300">
                <div class="absolute inset-0 bg-gradient-to-br from-pink-500/5 to-rose-500/5 rounded-2xl opacity-0 group-hover:opacity-100"></div>

                <div class="relative text-center space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-r from-pink-500 to-rose-500 rounded-2xl flex items-center justify-center mx-auto group-hover:scale-110 shadow-lg">
                        <span class="text-2xl">✉️</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Secret Letter</h3>
                        <p class="text-gray-600 text-sm">Thư tình hẹn ngày mở</p>
                    </div>
                    <div class="bg-pink-50 p-3 rounded-xl text-center">
                        <div class="text-xs text-pink-600">Mở ngày: 25/12 🎄</div>
                    </div>
                </div>
            </div>

            <!-- 6. YÊU XA: Heartbeat Signal -->
            <div class="group relative p-8 rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-red-100 hover:border-red-300">
                <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-rose-500/5 rounded-2xl opacity-0 group-hover:opacity-100"></div>

                <div class="relative text-center space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-rose-500 rounded-2xl flex items-center justify-center mx-auto group-hover:scale-110 shadow-lg">
                        <span class="text-2xl">💓</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Heartbeat</h3>
                        <p class="text-gray-600 text-sm">Nút "Nhớ em/anh" ngay lập tức</p>
                    </div>
                    <div class="bg-red-50 p-3 rounded-xl text-center">
                        <div class="text-xs text-red-600 animate-pulse">💓 2 phút trước</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- How It Works - Interactive Timeline -->
<section id="how-to-use" class="py-8 md:py-12 bg-gradient-to-r from-rose-50 via-pink-50 to-purple-50 overflow-hidden">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-4 md:mb-6">
            <div class="inline-flex items-center px-4 sm:px-6 py-3 bg-gradient-to-r from-rose-500 via-pink-500 to-purple-500 text-white font-semibold rounded-full mb-6 shadow-lg shadow-rose-500/25">
                <span class="text-xl mr-2">✨</span>
                3 BƯỚC ĐƠN GIẢN
            </div>
            <h2 class="font-bold text-gray-800 leading-tight">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-500 via-pink-500 to-purple-600 relative text-2xl md:text-3xl">
                    ĐỂ NHẬN THẺ
                    <span class="absolute inset-0 bg-gradient-to-r from-rose-500/30 via-pink-500/30 to-purple-600/30 blur rounded-lg -z-10"></span>
                </span>
            </h2>
        </div>

        <!-- Steps -->
        <div class="relative max-w-5xl mx-auto">
            <!-- MOBILE: Vertical -->
            <div class="md:hidden relative">
                <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-gradient-to-b from-rose-500 to-purple-500"></div>
                <div class="space-y-4">
                    <!-- Step 1 -->
                    <div class="relative text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-rose-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl z-10">
                            <span class="text-xl font-bold text-white">1</span>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-lg">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Đặt Mua Online</h3>
                            <p class="text-gray-600 text-sm">Thanh toán • Xác nhận</p>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                                <div class="bg-gradient-to-r from-rose-500 to-pink-500 h-2 rounded-full" style="width: 33%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-pink-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl z-10">
                            <span class="text-xl font-bold text-white">2</span>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-lg">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Cài Đặt NFC</h3>
                            <p class="text-gray-600 text-sm">Tải app • Quét mã • Lưu kỷ niệm đầu</p>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                                <div class="bg-gradient-to-r from-pink-500 to-purple-500 h-2 rounded-full" style="width: 66%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-rose-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl z-10">
                            <span class="text-xl font-bold text-white">3</span>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-lg">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Chạm Để Yêu</h3>
                            <p class="text-gray-600 text-sm">Chạm tay • Xem kỷ niệm • Chia sẻ ngay</p>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                                <div class="bg-gradient-to-r from-purple-500 to-rose-500 h-2 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DESKTOP: Horizontal -->
            <div class="hidden md:block relative">
                <div class="absolute top-20 left-12 right-12 h-1 bg-gradient-to-r from-rose-500 via-pink-500 to-purple-500 rounded-full"></div>
                <div class="grid grid-cols-3 gap-10">
                    <!-- Step 1 -->
                    <div class="relative text-center">
                        <div class="relative inline-block mx-auto mb-6">
                            <div class="w-20 h-20 bg-gradient-to-r from-rose-500 to-pink-500 rounded-full flex items-center justify-center shadow-xl">
                                <span class="text-2xl font-bold text-white relative z-10">1</span>
                            </div>
                            <div class="absolute -inset-2 w-24 h-24 rounded-full bg-rose-500/20 animate-ping"></div>
                            <div class="absolute inset-0 w-20 h-20 rounded-full bg-rose-500/30 blur"></div>
                        </div>
                        <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Đặt Mua Online</h3>
                            <p class="text-gray-600 mb-6">Chọn thiết kế • Thanh toán • Xác nhận</p>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-rose-500 to-pink-500 h-2 rounded-full" style="width: 33%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative text-center z-10">
                        <div class="relative inline-block mx-auto mb-6">
                            <div class="w-20 h-20 bg-gradient-to-r from-pink-500 to-purple-500 rounded-full flex items-center justify-center shadow-xl">
                                <span class="text-2xl font-bold text-white relative z-10">2</span>
                            </div>
                            <div class="absolute -inset-2 w-24 h-24 rounded-full bg-pink-500/20 animate-ping" style="animation-delay: 0.3s"></div>
                            <div class="absolute inset-0 w-20 h-20 rounded-full bg-pink-500/30 blur"></div>
                        </div>
                        <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Cài Đặt NFC</h3>
                            <p class="text-gray-600 mb-6">Tải app • Quét mã • Lưu kỷ niệm đầu</p>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-pink-500 to-purple-500 h-2 rounded-full" style="width: 66%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative text-center">
                        <div class="relative inline-block mx-auto mb-6">
                            <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-rose-500 rounded-full flex items-center justify-center shadow-xl">
                                <span class="text-2xl font-bold text-white relative z-10">3</span>
                            </div>
                            <div class="absolute -inset-2 w-24 h-24 rounded-full bg-purple-500/20 animate-ping" style="animation-delay: 0.6s"></div>
                            <div class="absolute inset-0 w-20 h-20 rounded-full bg-purple-500/30 blur"></div>
                        </div>
                        <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Chạm Để Yêu</h3>
                            <p class="text-gray-600 mb-6">Chạm tay • Xem kỷ niệm • Chia sẻ ngay</p>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-purple-500 to-rose-500 h-2 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Info -->
        <div class="mt-10 text-center">
            <div class="inline-flex flex-wrap items-center justify-center px-3 sm:px-6 py-3 
                bg-gradient-to-r from-green-500/10 via-emerald-500/10 to-teal-500/10 
                text-green-800 font-semibold rounded-full shadow-lg border border-green-200 
                max-w-full mx-auto text-sm sm:text-base">

                <!-- Icon -->
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 flex-shrink-0 mb-1 sm:mb-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>

                <!-- Text WRAP RESPONSIVE -->
                <div class="text-center leading-tight">
                    <div class="sm:hidden"> <!-- MOBILE: 1 dòng -->
                        🚚 Giao hàng <strong>toàn quốc</strong> • <strong>2-3 ngày</strong>
                    </div>
                    <div class="hidden sm:block"> <!-- DESKTOP: 2 dòng -->
                        🚚 Giao <strong>hàng toàn quốc</strong> trong <strong>2-3 ngày</strong> • <strong>Miễn phí</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials - Carousel Style -->
<section class="py-8 md:py-12 bg-gradient-to-br from-white via-rose-50 to-pink-50">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-10 sm:mb-16">
            <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-rose-500 via-pink-500 to-purple-500 text-white font-semibold rounded-full mb-6 shadow-lg shadow-rose-500/25">
                <span class="text-xl mr-2">💕</span>
                CÂU CHUYỆN TÌNH YÊU
            </div>
            <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto">
                <span class="text-rose-600 font-semibold">5.0/5 ★★★★★</span> - <span class="text-gray-500 italic">1,247 cặp đôi</span>
            </p>
        </div>

        <!-- Testimonials Grid -->
        <div class="grid md:grid-cols-3 gap-12 md:gap-6 sm:gap-8 max-w-6xl mx-auto">

            <!-- Testimonial 1 -->
            <div class="group relative bg-white/80 backdrop-blur-sm rounded-3xl p-6 sm:p-8 border border-white/50 hover:border-rose-200 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <!-- Avatar -->
                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2">
                    <div class="w-16 h-16 bg-gradient-to-r from-rose-400 to-pink-400 rounded-full flex items-center justify-center shadow-xl border-4 border-white">
                        <span class="text-white font-bold text-lg">HN</span>
                    </div>
                </div>

                <!-- Content -->
                <div class="pt-4 text-center space-y-4">
                    <!-- Stars -->
                    <div class="flex justify-center text-yellow-400 text-xl">
                        ★★★★★
                    </div>

                    <!-- Quote -->
                    <div class="relative">
                        <p class="text-gray-700 font-medium italic text-sm sm:text-base leading-relaxed px-4">
                            "Mỗi lần chạm vòng tay là một lần yêu lại từ đầu. <span class="text-rose-600">LoveApp thực sự là phép màu!</span>"
                        </p>
                    </div>

                    <!-- Author -->
                    <div class="pt-4 border-t border-gray-100">
                        <div class="font-semibold text-gray-800 text-sm sm:text-base">Hương & Nam</div>
                        <div class="text-xs text-gray-500 mt-1">4 tháng sử dụng</div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="group relative bg-white/80 backdrop-blur-sm rounded-3xl p-6 sm:p-8 border border-white/50 hover:border-purple-200 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <!-- Avatar -->
                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2">
                    <div class="w-16 h-16 bg-gradient-to-r from-pink-400 to-purple-400 rounded-full flex items-center justify-center shadow-xl border-4 border-white">
                        <span class="text-white font-bold text-lg">TL</span>
                    </div>
                </div>

                <!-- Content -->
                <div class="pt-4 text-center space-y-4">
                    <!-- Stars -->
                    <div class="flex justify-center text-yellow-400 text-xl">
                        ★★★★★
                    </div>

                    <!-- Quote -->
                    <div class="relative">
                        <p class="text-gray-700 font-medium italic text-sm sm:text-base leading-relaxed px-4">
                            "Công nghệ NFC thay đổi cách chúng tôi <span class="text-purple-600">yêu nhau</span>. Bất cứ lúc nào cũng gần nhau!"
                        </p>
                    </div>

                    <!-- Author -->
                    <div class="pt-4 border-t border-gray-100">
                        <div class="font-semibold text-gray-800 text-sm sm:text-base">Lan & Tuấn</div>
                        <div class="text-xs text-gray-500 mt-1">8 tháng sử dụng</div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="group relative bg-white/80 backdrop-blur-sm rounded-3xl p-6 sm:p-8 border border-white/50 hover:border-pink-200 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <!-- Avatar -->
                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-400 to-rose-400 rounded-full flex items-center justify-center shadow-xl border-4 border-white">
                        <span class="text-white font-bold text-lg">MP</span>
                    </div>
                </div>

                <!-- Content -->
                <div class="pt-4 text-center space-y-4">
                    <!-- Stars -->
                    <div class="flex justify-center text-yellow-400 text-xl">
                        ★★★★★
                    </div>

                    <!-- Quote -->
                    <div class="relative">
                        <p class="text-gray-700 font-medium italic text-sm sm:text-base leading-relaxed px-4">
                            "Món quà <span class="text-pink-600">ý nghĩa nhất</span> trong đời. LoveApp kết nối trái tim chúng tôi mãi mãi."
                        </p>
                    </div>

                    <!-- Author -->
                    <div class="pt-4 border-t border-gray-100">
                        <div class="font-semibold text-gray-800 text-sm sm:text-base">Mai & Phong</div>
                        <div class="text-xs text-gray-500 mt-1">1 năm sử dụng</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include __DIR__ . '/../layout/footer.php'; ?>