<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yêu Xa - Couple App</title>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        button.recording {
            background: linear-gradient(to right, #ef4444, #dc2626) !important;
            animation: pulse 1s infinite;
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.7);
        }


        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE và Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 10px rgba(239, 68, 68, 0.7);
            }

            50% {
                transform: scale(1.1);
                box-shadow: 0 0 20px rgba(239, 68, 68, 1);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 10px rgba(239, 68, 68, 0.7);
            }
        }

        #messageBox {
            overflow-y: scroll;
            /* vẫn scroll được */
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE 10+ */
        }

        #messageBox::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Edge */
        }

        /* Font Styles */
        body {
            font-family: 'Poppins', sans-serif;
        }

        h1.text-3xl,
        h2.text-3xl {
            font-family: 'Dancing Script', cursive;
        }

        /* Heart Beat Animation */
        @keyframes heartBeat {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.4);
            }

            100% {
                transform: scale(1);
            }
        }

        .heart-beat {
            animation: heartBeat 1.8s infinite ease-in-out;
        }

        /* Fade In Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 1.2s ease-in-out;
        }

        /* Floating Hearts Background */
        @keyframes floatHeart {
            0% {
                transform: translateY(0);
                opacity: 0.9;
            }

            50% {
                transform: translateY(-120px);
                opacity: 0.4;
            }

            100% {
                transform: translateY(-240px);
                opacity: 0;
            }
        }

        .floating-heart {
            position: absolute;
            font-size: 1.5rem;
            color: #ff8fab;
            animation: floatHeart 5s infinite ease-in-out;
        }

        /* Falling Flower Petals Animation */
        @keyframes fallPetal {
            0% {
                transform: translateY(-100px) rotate(0deg);
                opacity: 0.9;
            }

            50% {
                transform: translateY(60vh) translateX(30px) rotate(200deg);
                opacity: 0.6;
            }

            100% {
                transform: translateY(120vh) translateX(-30px) rotate(400deg);
                opacity: 0;
            }
        }

        .falling-petal {
            position: absolute;
            font-size: 1rem;
            color: #ffb6c1;
            animation: fallPetal 7s infinite ease-in-out;
            z-index: 5;
        }

        .falling-petal.large {
            font-size: 1.5rem;
            animation-duration: 6s;
        }


        /* Sparkle Animation for Buttons */
        @keyframes sparkle {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 105, 180, 0.7);
            }

            50% {
                box-shadow: 0 0 20px 5px rgba(255, 105, 180, 0.3);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 105, 180, 0.7);
            }
        }

        .sparkle-button:hover {
            animation: sparkle 1.5s ease-in-out;
        }

        /* Ripple Effect */
        .ripple {
            position: relative;
            overflow: hidden;
        }

        .ripple::after {
            content: '';
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: rippleEffect 0.6s ease-out;
            top: 50%;
            left: 50%;
            pointer-events: none;
        }

        @keyframes rippleEffect {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }


        /* Card Hover Effect */
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(255, 105, 180, 0.3);
        }

        /* Gradient Border */
        .gradient-border {
            position: relative;
            padding: 3px;
            background: linear-gradient(45deg, #ff6b6b, #ff99cc);
            border-radius: 16px;
        }

        .gradient-border>div {
            background: white;
            border-radius: 13px;
            padding: 1rem;
        }

        /* Image Fallback */
        img {
            background-color: #ffe6e6;
            object-fit: cover;
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .tab-link.active i,
        .tab-link.active span {
            color: #fff;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.7);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-pink-50 via-rose-100 to-purple-50 min-h-screen relative overflow-x-hidden scroll-pt-28 antialiased">
    <!-- Floating Hearts and Falling Petals Background -->
    <div class="fixed inset-0 pointer-events-none">
        <i class="fas fa-heart floating-heart" style="left: 10%; animation-delay: 0s;"></i>
        <i class="fas fa-heart floating-heart" style="left: 25%; animation-delay: 1.2s;"></i>
        <i class="fas fa-heart floating-heart" style="left: 45%; animation-delay: 2.4s;"></i>
        <i class="fas fa-heart floating-heart" style="left: 65%; animation-delay: 3.6s;"></i>
        <i class="fas fa-heart floating-heart" style="left: 85%; animation-delay: 4.8s;"></i>
        <i class="fas fa-flower falling-petal" style="left: 15%; animation-delay: 0.5s;"></i>
        <i class="fas fa-flower falling-petal large" style="left: 30%; animation-delay: 1.5s;"></i>
        <i class="fas fa-flower falling-petal" style="left: 50%; animation-delay: 2.5s;"></i>
        <i class="fas fa-flower falling-petal large" style="left: 70%; animation-delay: 3.5s;"></i>
        <i class="fas fa-flower falling-petal" style="left: 90%; animation-delay: 4.5s;"></i>
    </div>

    <!-- Header -->
    <header class="bg-gradient-to-r from-pink-600 to-purple-600 text-white p-4 shadow-md sticky top-0 z-20">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold flex items-center gap-2">
                <i class="fas fa-heart heart-beat text-2xl"></i>
                <span>Yêu Xa</span>
            </h1>

            <?php $userName = $_SESSION['user_full_name'] ?? 'Chưa đăng nhập'; ?>
            <div class="flex items-center gap-2 bg-pink-500/40 px-3 py-1 rounded-full text-sm">
                <i class="fas fa-user-circle text-lg"></i>
                <span><?= htmlspecialchars($userName) ?></span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto py-6 px-4 md:px-6 relative z-10 pb-24">
        

        <!-- Heartbeat Signal Section -->
        


        <!-- Mood Tracker Section -->
        

        <!-- Love Diary Section -->
        

        <!-- Love Challenge Section -->
        


        <!-- Mini Game Section -->
        

        <!-- Video/Voice Reminder -->
        

    </main>

    <!-- 🔹 Bottom Tab Navigation -->
    


    


    
    <script type="module" src="/love-app/public/js/longdistance_layout.js"></script>
</body>

</html>