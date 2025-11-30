 # AfriConnect Market 

**An e-commerce platform empowering Ghanaian artisans and SMEs**

AfriConnect Market is a mobile-first web platform that connects local artisans with buyers nationwide and internationally, offering secure payments, integrated logistics, and AI-powered tools.


---

## Features

### For Sellers
- **Product Management**: Easy listing with bulk upload capabilities
- **Inventory Tracking**: Real-time stock management with low-stock alerts
- **Analytics Dashboard**: Track sales, views, and revenue
- **Mobile Money Payouts**: Weekly automated payments via MTN, Vodafone

### For Buyers
- **Advanced Search**: Full-text search with intelligent filtering
- **Secure Checkout**: Multi-step process with order tracking
- **Multiple Payment Options**: Mobile money, cards, PayPal, Cash on Delivery
- **Escrow Protection**: Payments held until delivery confirmed
- **Review System**: Rate products and sellers

### For Admins
- **Comprehensive Dashboard**: User, product, and order management
- **Analytics & Reports**: Sales trends, revenue tracking, user metrics
- **Content Moderation**: Product approval and quality control
- **Dispute Resolution**: Order and payment issue management

---

## 🛠️ Tech Stack

### Backend
- **Language**: PHP 8.1+
- **Database**: MySQL 8.0+
- **Architecture**: MVC (Model-View-Controller)
- **Database Management**: phpMyAdmin

### Frontend
- **HTML5**: Semantic markup
- **CSS3**: Responsive design with mobile-first approach
- **JavaScript**: Dynamic interactions
- **Framework**: Tailwind CSS / Bootstrap (optional)

### External Integrations
- **Payment Gateways**: 
  - MTN Mobile Money API
  - Vodafone Cash API
  - Paystack (Card payments)
  - PayPal REST API
- **AI Service**: OpenAI API for product descriptions
- **SMS/Email**: Notification services
- **Logistics**: Ghana Post, Glovo, Bolt APIs

---

## System Architecture

```
┌─────────────────────────────────────────┐
│         PRESENTATION LAYER              │
│   (HTML, CSS, JavaScript, PWA)          │
└──────────────┬──────────────────────────┘
               │
┌──────────────▼──────────────────────────┐
│       APPLICATION LAYER (PHP MVC)       │
│  Controllers → Business Logic → Models  │
└──────────────┬──────────────────────────┘
               │
┌──────────────▼──────────────────────────┐
│           DATA LAYER                    │
│  MySQL | File Storage | Cache (Redis)  │
└──────────────┬──────────────────────────┘
               │
┌──────────────▼──────────────────────────┐
│      EXTERNAL INTEGRATIONS              │
│  Payment APIs | SMS | Email | AI | Logistics │
└─────────────────────────────────────────┘
```

---

## Installation

### Prerequisites
- PHP 8.1 or higher
- MySQL 8.0 or higher
- Composer (PHP package manager)
- Web server (Apache/Nginx) or XAMPP for local development

### Step 1: Clone Repository
```bash
git clone https://github.com/Nhyira-J/africonnect-market-1.git
cd africonnect-market-1
```

### Step 2: Install Dependencies
```bash
composer install
```

### Step 3: Configure Environment
```bash
# Copy example environment file
cp .env.example .env

# Edit .env file with your database credentials
nano .env
```

### Step 4: Database Setup
```bash
# Import database schema
mysql -u your_username -p your_database < database/schema.sql

# Or use phpMyAdmin to import the schema.sql file
```

### Step 5: Set Permissions
```bash
# Set proper permissions for storage and cache directories
chmod -R 775 storage/
chmod -R 775 cache/
```

### Step 6: Start Development Server

**Using XAMPP:**
1. Place project in `htdocs/` folder
2. Start Apache and MySQL
3. Access: `http://localhost/africonnect-market-1`

**Using PHP Built-in Server:**
```bash
php -S localhost:8000 -t public/
```

---

## Database Setup

### Database Schema
The database includes the following core tables:

- `users` - User accounts (buyers, sellers, admins)
- `products` - Product listings
- `categories` - Product categories (hierarchical)
- `orders` - Customer orders
- `order_items` - Order line items
- `payments` - Payment transactions
- `invoices` - Generated invoices
- `cart` - Shopping cart
- `cart_items` - Cart contents
- `reviews` - Product reviews

### Import Schema
```sql
-- Create database
CREATE DATABASE africonnect_market;

-- Import schema
mysql -u root -p africonnect_market < database/schema.sql
```

---

##  Configuration

### Environment Variables (.env)

```env
# Application
APP_NAME="AfriConnect Market"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=africonnect_market
DB_USERNAME=root
DB_PASSWORD=

# Payment Gateways
MTN_API_KEY=your_mtn_api_key
VODAFONE_API_KEY=your_vodafone_api_key
PAYSTACK_SECRET_KEY=your_paystack_secret_key
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_SECRET=your_paypal_secret

# AI Service
OPENAI_API_KEY=your_openai_api_key

# Mail
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=

# SMS
SMS_API_KEY=your_sms_api_key
```

---

## Usage

### For Sellers
1. Register as a seller
2. Complete profile with business details
3. Add products with images and descriptions
4. Manage inventory and orders from dashboard
5. Receive weekly payouts to mobile money account

### For Buyers
1. Browse or search for products
2. Add items to cart
3. Checkout with preferred payment method
4. Track order status
5. Confirm delivery and leave review

### For Admins
1. Access admin dashboard
2. Manage users, products, and orders
3. View analytics and reports
4. Handle disputes and moderation

---

## Project Structure

```
africonnect-market/
├── app/
│   ├── controllers/        # Request handlers
│   │   ├── AuthController.php
│   │   ├── ProductController.php
│   │   ├── OrderController.php
│   │   └── ...
│   ├── models/            # Business logic & database
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Order.php
│   │   └── ...
│   ├── views/             # HTML templates
│   │   ├── home.php
│   │   ├── products/
│   │   ├── cart.php
│   │   └── ...
│   ├── config/            # Configuration files
│   └── helpers/           # Utility functions
├── public/                # Web root
│   ├── index.php          # Entry point
│   ├── css/
│   ├── js/
│   └── images/
├── database/
│   ├── schema.sql         # Database structure
│   └── migrations/
├── storage/
│   ├── logs/
│   ├── cache/
│   └── uploads/
├── tests/                 # Unit and integration tests
├── vendor/                # Composer dependencies
├── .env.example           # Environment template
├── .gitignore
├── composer.json
└── README.md
```

---

## 📡 API Documentation

### Authentication
```php
POST /api/auth/register
POST /api/auth/login
POST /api/auth/logout
```

### Products
```php
GET    /api/products           # List all products
GET    /api/products/{id}      # Get single product
POST   /api/products           # Create product (seller only)
PUT    /api/products/{id}      # Update product
DELETE /api/products/{id}      # Delete product
```

### Orders
```php
GET    /api/orders             # List user orders
GET    /api/orders/{id}        # Get order details
POST   /api/orders             # Create order
PUT    /api/orders/{id}/status # Update order status
```

### Payments
```php
POST   /api/payments/initiate  # Initiate payment
POST   /api/payments/verify    # Verify payment
GET    /api/payments/{id}      # Get payment status
```

---


**Project Link**: [https://github.com/Nhyira-J/africonnect-market-1](https://github.com/Nhyira-J/africonnect-market-1)

