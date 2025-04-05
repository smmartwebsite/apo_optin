<?php
// Database configuration
$db_host = 'localhost';
$db_name = 'app_optin';
$db_user = 'root';
$db_pass = '';

// Create connection
try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    
    // Basic validation
    $errors = [];
    if (empty($name)) $errors[] = "Name is required";
    if (empty($contact)) $errors[] = "Contact number is required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    
    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("INSERT INTO names (name, contact, email, city) VALUES (:name, :contact, :email, :city)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':city', $city);
            $stmt->execute();
            
            $success_message = "Thank you, $name! Your registration was successful.";
        } catch(PDOException $e) {
            $errors[] = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Power of Building an Auto Pilot Organization</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --black: #000000;
            --accent: #ff6b6b;
            --accent-light: #ff8e8e;
            --white: #ffffff;
            --gray: #f5f5f5;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--black);
            color: var(--white);
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            min-height: 80vh;
            display: flex;
            align-items: center;
            text-align: center;
            padding: 4rem 0;
            position: relative;
        }
        
        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            background: linear-gradient(45deg, var(--accent), var(--accent-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        /* Countdown Section */
        .countdown {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 3rem 0;
            text-align: center;
        }
        
        .countdown h2 {
            font-size: 2rem;
            margin-bottom: 2rem;
            color: var(--accent);
        }
        
        .countdown-container {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }
        
        .countdown-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 10px;
            min-width: 100px;
            backdrop-filter: blur(5px);
        }
        
        .countdown-box span {
            display: block;
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--white);
        }
        
        .countdown-box small {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        /* Speakers Section */
        .speakers {
            padding: 4rem 0;
            text-align: center;
        }
        
        .speakers h2 {
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: var(--accent);
        }
        
        .speakers-grid {
            display: flex;
            justify-content: center;
            gap: 3rem;
            flex-wrap: wrap;
        }
        
        .speaker-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
            width: 300px;
            transition: transform 0.3s ease;
        }
        
        .speaker-card:hover {
            transform: translateY(-10px);
        }
        
        .speaker-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: var(--gray);
            margin: 0 auto 1.5rem;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--black);
            font-size: 3rem;
        }

        .speaker-image img {
            width: 140%;
        }
        
        .speaker-card h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .speaker-card p {
            opacity: 0.8;
            font-style: italic;
        }
        
        /* Form Section */
        .registration {
            padding: 4rem 0;
            background: linear-gradient(45deg, var(--accent), var(--accent-light));
        }
        
        .form-container {
            background-color: var(--black);
            max-width: 600px;
            margin: 0 auto;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .form-container h2 {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .form-group input {
            width: 100%;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: var(--white);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.2);
        }
        
        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(45deg, var(--accent), var(--accent-light));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }
        
        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .error {
            color: #ff3333;
            margin-bottom: 1rem;
        }
        
        .success {
            color: #4CAF50;
            margin-bottom: 1rem;
            font-weight: bold;
        }
        
        /* CTA Section */
        .cta {
            padding: 4rem 0;
            text-align: center;
        }
        
        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
        }
        
        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }
        
        .cta-btn {
            padding: 1rem 2rem;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .cta-primary {
            background: linear-gradient(45deg, var(--accent), var(--accent-light));
            color: white;
        }
        
        .cta-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .countdown-box {
                min-width: 80px;
                padding: 1rem;
            }
            
            .countdown-box span {
                font-size: 2rem;
            }
            
            .speakers-grid {
                gap: 2rem;
            }
            
            .speaker-card {
                width: 100%;
                max-width: 300px;
            }
        }

        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* This creates the parallax effect */
            min-height: 100vh;
            display: flex;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(255,107,107,0.2), rgba(255,142,142,0.2));
            z-index: 0;
            transform: translateZ(-1px) scale(1.5);
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            transform: translateZ(0);
        }
        
        /* New Parallax Section */
        .parallax {
            background: url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .parallax::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }
        
        .parallax-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            padding: 2rem;
            text-align: center;
        }
        
        .parallax-content h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(45deg, var(--accent), var(--accent-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .parallax-content p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
    </style>
</head>
<body>
<section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>The Power of Building an Auto Pilot Organization</h1>
                <p>Transform your business from being dependent on you to running automatically with systems and teams that deliver consistent results.</p>
                <div class="cta-buttons">
                    <a href="#register" class="cta-btn cta-primary">Register Now</a>
                    <a href="#learn-more" class="cta-btn cta-secondary">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Countdown Section -->
    <section class="countdown">
        <div class="container">
            <h2>Event Starts In:</h2>
            <div class="countdown-container">
                <div class="countdown-box">
                    <span id="days">00</span>
                    <small>Days</small>
                </div>
                <div class="countdown-box">
                    <span id="hours">00</span>
                    <small>Hours</small>
                </div>
                <div class="countdown-box">
                    <span id="minutes">00</span>
                    <small>Minutes</small>
                </div>
                <div class="countdown-box">
                    <span id="seconds">00</span>
                    <small>Seconds</small>
                </div>
            </div>
        </div>
    </section>

    <!-- New Parallax Section -->
    <section class="parallax">
        <div class="parallax-content">
            <h2>Why Most Entrepreneurs Feel Trapped</h2>
            <p>Discover how to break free from the constraints holding back your business growth and unlock your true potential.</p>
        </div>
    </section>

    <!-- Speakers Section -->
    <section class="speakers" id="learn-more">
        <div class="container">
            <h2>Meet Our Experts</h2>
            <div class="speakers-grid">
                <div class="speaker-card">
                    <div class="speaker-image">
                        <img src="speaker1.png" alt="Deepak Dhabalia">
                    </div>
                    <h3>Deepak Dhabalia</h3>
                    <p>Lead-Speaker</p>
                </div>
                <div class="speaker-card">
                    <div class="speaker-image">
                        <img src="speaker2.png" alt="Santosh Nair">
                    </div>
                    <h3>Santosh Nair</h3>
                    <p>Co-Speaker</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Second Parallax Section -->
    <section class="parallax" style="background-image: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80')">
        <div class="parallax-content">
            <h2>Create Lasting Impact</h2>
            <p>Learn the strategies to build a self-sustaining organization that continues to grow without your constant involvement.</p>
        </div>
    </section>

    <!-- Registration Form -->
    <section class="registration" id="register">
        <div class="container">
            <div class="form-container">
                <h2>Register Now</h2>
                
                <?php if (!empty($errors)): ?>
                    <div class="error">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($success_message)): ?>
                    <div class="success">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>
                
                <form method="post">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact">Contact Number</label>
                        <input type="tel" id="contact" name="contact" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" required>
                    </div>
                    
                    <button type="submit" class="submit-btn">Submit</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="cta">
        <div class="container">
            <h2>Ready to Transform Your Business?</h2>
            <div class="cta-buttons">
                <a href="#register" class="cta-btn cta-primary">Register Now</a>
            </div>
        </div>
    </section>

    <script>
        // Countdown to April 23, 2025
        function updateCountdown() {
            const targetDate = new Date("April 23, 2025 09:00:00").getTime();
            const now = new Date().getTime();
            const distance = targetDate - now;
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById("days").textContent = days.toString().padStart(2, "0");
            document.getElementById("hours").textContent = hours.toString().padStart(2, "0");
            document.getElementById("minutes").textContent = minutes.toString().padStart(2, "0");
            document.getElementById("seconds").textContent = seconds.toString().padStart(2, "0");
            
            if (distance < 0) {
                clearInterval(countdownTimer);
                document.getElementById("days").textContent = "00";
                document.getElementById("hours").textContent = "00";
                document.getElementById("minutes").textContent = "00";
                document.getElementById("seconds").textContent = "00";
            }
        }
        
        updateCountdown();
        const countdownTimer = setInterval(updateCountdown, 1000);
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Enhanced Parallax Effect with Scroll Event
        window.addEventListener('scroll', function() {
            const scrollPosition = window.pageYOffset;
            const hero = document.querySelector('.hero');
            const parallaxSections = document.querySelectorAll('.parallax');
            
            // Hero section parallax
            hero.style.backgroundPositionY = scrollPosition * 0.5 + 'px';
            
            // Additional parallax sections
            parallaxSections.forEach(section => {
                section.style.backgroundPositionY = -(scrollPosition * 0.3) + 'px';
            });
        });
    </script>
</body>
</html>