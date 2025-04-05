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
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    
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
            
            echo "<div class='success-message'>Thank you for registering! We'll contact you soon.</div>";
        } catch(PDOException $e) {
            echo "<div class='error-message'>Error: " . $e->getMessage() . "</div>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<div class='error-message'>$error</div>";
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #ff6b6b, #ff8e8e);
            --black: #000000;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: var(--black);
        }

        .hero {
            background: var(--primary-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="white" stroke-width="0.5" opacity="0.1"/></svg>') center/cover;
            opacity: 0.1;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-text p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .countdown {
            display: flex;
            gap: 20px;
            margin: 30px 0;
        }

        .countdown-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            min-width: 100px;
        }

        .countdown-number {
            font-size: 2rem;
            font-weight: 700;
        }

        .countdown-label {
            font-size: 0.8rem;
            text-transform: uppercase;
        }

        .speakers {
            display: flex;
            gap: 20px;
            margin: 40px 0;
        }

        .speaker {
            background: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .speaker:hover {
            transform: translateY(-5px);
        }

        .speaker img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            background: #eee;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 8px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #ff6b6b;
        }

        .cta-button {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }

        .success-message, .error-message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .hero-content {
                grid-template-columns: 1fr;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }

            .countdown {
                flex-wrap: wrap;
            }

            .speakers {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>The Power of Building an Auto Pilot Organization</h1>
                    <p>Transform your business into a self-sustaining, high-performance organization that runs like clockwork.</p>
                    
                    <div class="countdown" id="countdown">
                        <div class="countdown-item">
                            <div class="countdown-number" id="days">00</div>
                            <div class="countdown-label">Days</div>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-number" id="hours">00</div>
                            <div class="countdown-label">Hours</div>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-number" id="minutes">00</div>
                            <div class="countdown-label">Minutes</div>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-number" id="seconds">00</div>
                            <div class="countdown-label">Seconds</div>
                        </div>
                    </div>

                    <div class="speakers">
                        <div class="speaker">
                            <img src="https://via.placeholder.com/150" alt="Speaker 1">
                            <h3>Expert Speaker 1</h3>
                            <p>Business Transformation Specialist</p>
                        </div>
                        <div class="speaker">
                            <img src="https://via.placeholder.com/150" alt="Speaker 2">
                            <h3>Expert Speaker 2</h3>
                            <p>Organizational Development Expert</p>
                        </div>
                    </div>
                </div>

                <div class="form-container">
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
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" required>
                        </div>
                        <button type="submit" class="cta-button">Register Now</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Countdown Timer
        function updateCountdown() {
            const eventDate = new Date('April 23, 2025 09:00:00').getTime();
            const now = new Date().getTime();
            const distance = eventDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = days.toString().padStart(2, '0');
            document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);

        // Form Animation
        const formInputs = document.querySelectorAll('.form-group input');
        formInputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.style.transform = 'scale(1.02)';
            });
            input.addEventListener('blur', () => {
                input.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>