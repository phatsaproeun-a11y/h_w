<?php 
session_start();

  include("connection.php");
  include("functions.php");

  $user_data = check_login($con);
  
  // If not logged in, redirect to login page
  if(!$user_data) {
    header("Location: login.php");
    die;
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Team | Creative Minds</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: #fff;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            text-align: center;
            padding: 40px 0;
            animation: fadeInDown 1.5s ease-out;
        }

        h1 {
            font-size: 3.5rem;
            margin-bottom: 10px;
            background: linear-gradient(to right, #00b4db, #0083b0);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .tagline {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .team-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 40px;
            margin-top: 30px;
        }

        .member-card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            overflow: hidden;
            width: 320px;
            padding: 25px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            transition: transform 0.5s ease, box-shadow 0.5s ease;
            opacity: 0;
            transform: translateY(50px);
        }

        .member-card:nth-child(1) {
            animation: slideUp 1s ease 0.3s forwards;
        }

        .member-card:nth-child(2) {
            animation: slideUp 1s ease 0.6s forwards;
        }

        .member-card:nth-child(3) {
            animation: slideUp 1s ease 0.9s forwards;
        }

        .member-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(0, 180, 219, 0.3);
        }

        .image-container {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            margin: 0 auto 25px;
            overflow: hidden;
            border: 5px solid #00b4db;
            box-shadow: 0 10px 25px rgba(0, 180, 219, 0.3);
            position: relative;
            background: rgba(0, 180, 219, 0.1);
        }

        .member-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .image-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 180, 219, 0.2), transparent);
            z-index: 1;
        }

        .member-card:hover .member-img {
            transform: scale(1.1);
        }

        .member-name {
            font-size: 1.8rem;
            margin-bottom: 8px;
            color: #00b4db;
        }

        .member-role {
            font-size: 1.1rem;
            color: #8fd3f4;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .member-bio {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 25px;
            color: #d1e8ff;
            min-height: 100px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .member-bio::-webkit-scrollbar {
            width: 4px;
        }

        .member-bio::-webkit-scrollbar-thumb {
            background: #00b4db;
            border-radius: 10px;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-icon:hover {
            background: #00b4db;
            transform: translateY(-5px);
        }

        .skills {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .skill-tag {
            background: rgba(0, 180, 219, 0.2);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            border: 1px solid rgba(0, 180, 219, 0.3);
            transition: all 0.3s ease;
        }

        .skill-tag:hover {
            background: rgba(0, 180, 219, 0.4);
            transform: translateY(-2px);
        }

        footer {
            text-align: center;
            margin-top: 60px;
            padding: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeIn 2s ease-out;
        }

        .team-motto {
            font-style: italic;
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: #8fd3f4;
        }

        /* User greeting */
        .user-greeting {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeIn 1s ease-out;
        }

        .user-greeting span {
            color: #00b4db;
            font-weight: bold;
        }

        .logout-btn {
            margin-left: 15px;
            padding: 5px 15px;
            background: rgba(255, 50, 50, 0.2);
            border: 1px solid rgba(255, 100, 100, 0.3);
            border-radius: 20px;
            color: #ff6b6b;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 50, 50, 0.4);
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Responsive Design */
        @media (max-width: 1100px) {
            .team-section {
                gap: 30px;
            }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }
            
            .member-card {
                width: 100%;
                max-width: 400px;
            }
            
            .team-section {
                gap: 40px;
            }
            
            .user-greeting {
                position: static;
                margin: 20px auto;
                width: fit-content;
                display: block;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 2rem;
            }
            
            .tagline {
                font-size: 1rem;
            }
            
            .member-name {
                font-size: 1.5rem;
            }
            
            .image-container {
                width: 150px;
                height: 150px;
            }
            
            .user-greeting {
                font-size: 0.9rem;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="user-greeting">
        Welcome, <span><?php echo htmlspecialchars($user_data['user_name'] ?? 'User'); ?></span>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
    
    <div class="container">
        <header>
            <h1>Our Creative Team</h1>
            <p class="tagline">Meet the talented individuals who combine innovation, expertise, and passion to deliver exceptional results. We're dedicated to pushing boundaries and creating amazing experiences.</p>
        </header>

        <section class="team-section">
            <!-- Member 1 -->
            <div class="member-card">
                <div class="image-container">
                    <!-- Replaced broken GitHub link with placeholder -->
                    <img src="https://github.com/Samnang-Sokhorm/image/blob/main/photo_2025-12-11_02-17-58.jpg?raw=true" alt="Proeun Phatsa" class="member-img">
                </div>
                <h2 class="member-name">Proeun Phatsa</h2>
                <p class="member-role">Lead Designer & UI/UX Expert</p>
                <p class="member-bio">Proeun specializes in creating intuitive and beautiful user interfaces. With over 8 years of experience, he has worked with top tech companies to design award-winning digital products that combine aesthetics with functionality.</p>
                <div class="skills">
                    <span class="skill-tag">UI/UX Design</span>
                    <span class="skill-tag">Figma</span>
                    <span class="skill-tag">Adobe Creative Suite</span>
                    <span class="skill-tag">Prototyping</span>
                </div>
                <div class="social-links">
                    <a href="#" class="social-icon" aria-label="LinkedIn Profile"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-icon" aria-label="Twitter Profile"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon" aria-label="Dribbble Portfolio"><i class="fab fa-dribbble"></i></a>
                    <a href="mailto:proeun@example.com" class="social-icon" aria-label="Send Email"><i class="fas fa-envelope"></i></a>
                </div>
            </div>

            <!-- Member 2 -->
            <div class="member-card">
                <div class="image-container">
                    <!-- Replaced broken GitHub link with placeholder -->
                    <img src="https://github.com/Samnang-Sokhorm/image/blob/main/photo_2025-12-11_02-19-01.jpg?raw=true" alt="Chhoum Malis" class="member-img">
                </div>
                <h2 class="member-name">Chhoum Malis</h2>
                <p class="member-role">Full Stack Developer</p>
                <p class="member-bio">Chhoum is a versatile developer with expertise in both frontend and backend technologies. She loves solving complex problems and building scalable applications that make a difference in people's lives.</p>
                <div class="skills">
                    <span class="skill-tag">React</span>
                    <span class="skill-tag">Node.js</span>
                    <span class="skill-tag">Python</span>
                    <span class="skill-tag">MongoDB</span>
                </div>
                <div class="social-links">
                    <a href="#" class="social-icon" aria-label="GitHub Profile"><i class="fab fa-github"></i></a>
                    <a href="#" class="social-icon" aria-label="LinkedIn Profile"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-icon" aria-label="Stack Overflow Profile"><i class="fab fa-stack-overflow"></i></a>
                    <a href="mailto:chhoum@example.com" class="social-icon" aria-label="Send Email"><i class="fas fa-envelope"></i></a>
                </div>
            </div>

            <!-- Member 3 -->
            <div class="member-card">
                <div class="image-container">
                    <!-- Replaced broken GitHub link with placeholder -->
                    <img src="https://github.com/Samnang-Sokhorm/image/blob/main/image_2024-11-04_16-18-12.png?raw=true" alt="Sokhorn Samnang" class="member-img">
                </div>
                <h2 class="member-name">Sokhorn Samnang</h2>
                <p class="member-role">Project Manager & Strategist</p>
                <p class="member-bio">Sokhorn ensures that projects are delivered on time and exceed client expectations. With a background in both business and technology, he bridges the gap between vision and execution.</p>
                <div class="skills">
                    <span class="skill-tag">Agile/Scrum</span>
                    <span class="skill-tag">Strategic Planning</span>
                    <span class="skill-tag">Client Relations</span>
                    <span class="skill-tag">Risk Management</span>
                </div>
                <div class="social-links">
                    <a href="#" class="social-icon" aria-label="LinkedIn Profile"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-icon" aria-label="Twitter Profile"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon" aria-label="Personal Website"><i class="fas fa-globe"></i></a>
                    <a href="mailto:sokhorn@example.com" class="social-icon" aria-label="Send Email"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
        </section>

        <footer>
            <p class="team-motto">"Individual commitment to a group effort - that is what makes a team work, a company work, a society work, a civilization work." - Vince Lombardi</p>
            <p>&copy; <?php echo date('Y'); ?> Creative Minds Team. All rights reserved.</p>
        </footer>
    </div>

    <script>
        // Add some interactive animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.member-card');
            
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-15px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
            
            // Smooth hover for skill tags
            const skillTags = document.querySelectorAll('.skill-tag');
            skillTags.forEach(tag => {
                tag.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                });
                
                tag.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            // Smooth scroll for any anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if(targetId !== '#') {
                        const targetElement = document.querySelector(targetId);
                        if(targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>