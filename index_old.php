<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AfriConnect - Authentic Crafts, Empowered Communities</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        /* Header & Navigation */
        header {
            background: #cebe46ff;
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        nav {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: black;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: black;
            text-decoration: none;
            font-weight: 500;
            transition: transform 0.3s;
            display: inline-block;
        }

        .nav-links a:hover {
            transform: translateY(-2px);
        }

        .cta-btn {
            background: white;
            color: #0b0b0bff;
            padding: 0.7rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
        }

        .cta-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        /* Hero Section */
        .hero {
            margin-top: 80px;
            background: #c6b461ff;
            padding: 6rem 2rem;
            text-align: center;
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            from { transform: translateY(0); }
            to { transform: translateY(-100px); }
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: 3.5rem;
            color: black;
            margin-bottom: 1rem;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease;
        }

        .hero p {
            font-size: 1.3rem;
            color: black;
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease 0.2s backwards;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            animation: fadeInUp 1s ease 0.4s backwards;
        }

        .btn-primary {
            background: #1e1d1bff;
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #005030;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .btn-secondary {
            background: #474746ff;
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Features Section */
        .features {
            padding: 5rem 2rem;
            background: white;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            color: #CE1126;
            margin-bottom: 3rem;
        }

        .features-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: linear-gradient(145deg, #f9f9f9, #ffffff);
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            color: #006B3F;
            margin-bottom: 1rem;
        }

        /* Categories Section */
        .categories {
            padding: 5rem 2rem;
            background: #f1eac7ff;
        }

        .category-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .category-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            transition: all 0.3s;
            cursor: pointer;
        }

        .category-card:hover {
            transform: scale(1.05);
        }

        .category-image {
            width: 100%;
            height: 200px;
            background: #e1e0deff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
        }

        .category-info {
            padding: 1.5rem;
            text-align: center;
        }

        .category-info h3 {
            color: #CE1126;
            margin-bottom: 0.5rem;
        }

        /* Testimonials */
        .testimonials {
            padding: 5rem 2rem;
            background: white;
        }

        .testimonial-container {
            max-width: 900px;
            margin: 3rem auto;
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .testimonial {
            background: linear-gradient(145deg, #f9f9f9, #ffffff);
            padding: 2rem;
            border-radius: 15px;
            flex: 1;
            min-width: 280px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            position: relative;
        }

        .testimonial::before {
            content: '"';
            font-size: 4rem;
            color: #FCD116;
            position: absolute;
            top: -10px;
            left: 20px;
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 1rem;
            color: #555;
        }

        .testimonial-author {
            font-weight: bold;
            color: #006B3F;
        }

        /* CTA Section */
        .cta-section {
            padding: 5rem 2rem;
            background: linear-gradient(135deg, #006B3F 0%, #004d2a 100%);
            text-align: center;
            color: white;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .cta-section p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        /* Footer */
        footer {
            background: #1a1a1a;
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            color: #FCD116;
            margin-bottom: 1rem;
        }

        .footer-section a {
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: #FCD116;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .nav-links {
                display: none;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">AfriConnect</div>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#categories">Shop</a></li>
                <li><a href="#testimonials">Stories</a></li>
            </ul>
            <a href="#" class="cta-btn">Join Us</a>
        </nav>
    </header>

    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Authentic Ghanaian Crafts, Direct From Artisans</h1>
            <p>Discover unique handmade treasures while empowering local communities across Ghana</p>
            <div class="hero-buttons">
                <a href="#categories" class="btn-primary">Explore Crafts</a>
                <a href="#" class="btn-secondary">Become an Artisan</a>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <h2 class="section-title">Why Choose AfriConnect?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">✨</div>
                <h3>100% Authentic</h3>
                <p>Every piece is handcrafted by verified Ghanaian artisans, ensuring genuine quality and cultural authenticity.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🤝</div>
                <h3>Fair Trade</h3>
                <p>Artists receive fair compensation for their work, supporting sustainable livelihoods and communities.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🚚</div>
                <h3>Nationwide Delivery</h3>
                <p>Fast and reliable shipping across Ghana, bringing artisan crafts right to your doorstep.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💚</div>
                <h3>Community Impact</h3>
                <p>Your purchase directly supports artisan families and preserves traditional Ghanaian craftsmanship.</p>
            </div>
        </div>
    </section>

    <section class="categories" id="categories">
        <h2 class="section-title">Browse Our Collections</h2>
        <div class="category-grid">
            <div class="category-card">
                <div class="category-image">🪵</div>
                <div class="category-info">
                    <h3>Wood Carvings</h3>
                    <p>Intricate sculptures and functional art</p>
                </div>
            </div>
            <div class="category-card">
                <div class="category-image">🧺</div>
                <div class="category-info">
                    <h3>Woven Baskets</h3>
                    <p>Traditional Bolga and Frafra designs</p>
                </div>
            </div>
            <div class="category-card">
                <div class="category-image">👗</div>
                <div class="category-info">
                    <h3>Kente Cloth</h3>
                    <p>Handwoven royal fabrics</p>
                </div>
            </div>
            <div class="category-card">
                <div class="category-image">🪔</div>
                <div class="category-info">
                    <h3>Pottery & Ceramics</h3>
                    <p>Traditional and contemporary pieces</p>
                </div>
            </div>
            <div class="category-card">
                <div class="category-image">📿</div>
                <div class="category-info">
                    <h3>Beadwork</h3>
                    <p>Jewelry and decorative items</p>
                </div>
            </div>
            <div class="category-card">
                <div class="category-image">🎨</div>
                <div class="category-info">
                    <h3>Paintings</h3>
                    <p>Contemporary and traditional art</p>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials" id="testimonials">
        <h2 class="section-title">Stories From Our Community</h2>
        <div class="testimonial-container">
            <div class="testimonial">
                <p class="testimonial-text">AfriConnect has transformed my business! I can now reach customers across the country and earn a sustainable income for my family.</p>
                <p class="testimonial-author">— Ama Mensah, Basket Weaver from Bolgatanga</p>
            </div>
            <div class="testimonial">
                <p class="testimonial-text">The quality is exceptional! I love knowing that my purchase directly supports talented artisans and their communities.</p>
                <p class="testimonial-author">— Kwame Osei, Customer from Accra</p>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <h2>Join Our Growing Community</h2>
        <p>Whether you're an artisan or a craft lover, there's a place for you</p>
        <div class="hero-buttons">
            <a href="#" class="btn-secondary">Start Selling</a>
            <a href="#" class="btn-primary" style="background: #FCD116; color: #006B3F;">Start Shopping</a>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <a href="#">Our Story</a>
                <a href="#">Mission & Values</a>
                <a href="#">Meet Our Artisans</a>
            </div>
            <div class="footer-section">
                <h3>Support</h3>
                <a href="#">Help Center</a>
                <a href="#">Shipping Info</a>
                <a href="#">Returns Policy</a>
            </div>
            <div class="footer-section">
                <h3>Connect</h3>
                <a href="#">Facebook</a>
                <a href="#">Instagram</a>
                <a href="#">WhatsApp</a>
            </div>
        </div>
        <p>&copy; 2025 AfriConnect. Empowering communities through craft.</p>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll animation to feature cards
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-card, .category-card, .testimonial').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });

        // Add click animation to buttons
        document.querySelectorAll('.btn-primary, .btn-secondary, .cta-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (this.getAttribute('href') === '#') {
                    e.preventDefault();
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                }
            });
        });
    </script>
</body>
</html>