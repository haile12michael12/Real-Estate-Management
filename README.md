# Real Estate Management System

A modern and feature-rich real estate management system built with PHP, following MVC architecture and best practices.

## Features

- **Property Management**
  - Add, edit, and delete properties
  - Multiple property images
  - Property categories
  - Property status tracking
  - Property search and filtering

- **Category Management**
  - Create and manage property categories
  - Category-based property filtering
  - SEO-friendly category URLs

- **Admin Panel**
  - Secure admin authentication
  - Dashboard with key metrics
  - User management
  - Property management
  - Category management

- **User Features**
  - Property search
  - Property filtering
  - Property favorites
  - Property requests
  - User dashboard

## System Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Composer (for dependency management)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/real-estate-management.git
cd real-estate-management
```

2. Create a `.env` file in the root directory:
```env
DB_HOST=localhost
DB_NAME=real_estate
DB_USER=your_username
DB_PASS=your_password
APP_URL=http://localhost/real-estate
ADMIN_URL=http://localhost/real-estate/admin
```

3. Create the database and import the schema:
```bash
mysql -u your_username -p your_database < database/schema.sql
```

4. Set up the web server:
   - Point your web server's document root to the `public` directory
   - Ensure the `uploads` directory is writable by the web server

5. Configure your web server:
   - For Apache, ensure mod_rewrite is enabled
   - For Nginx, use the provided nginx configuration

## Project Structure

```
real-estate-management/
├── app/
│   ├── core/                 # Core system files
│   │   ├── bootstrap.php     # Application bootstrap
│   │   ├── Config.php        # Configuration management
│   │   ├── Controller.php    # Base controller
│   │   ├── Database.php      # Database handling
│   │   ├── Model.php         # Base model
│   │   └── Session.php       # Session management
│   ├── Controllers/          # Application controllers
│   ├── Models/               # Application models
│   ├── Views/                # Application views
│   └── MiddleWares/          # Application middlewares
├── config/                   # Configuration files
├── public/                   # Public assets
│   ├── css/                  # Stylesheets
│   ├── js/                   # JavaScript files
│   ├── images/              # Image assets
│   └── uploads/             # User uploads
├── database/                # Database files
├── vendor/                  # Composer dependencies
├── .env                     # Environment variables
├── .gitignore              # Git ignore file
└── README.md               # This file
```

## Core Components

### Database
- PDO-based database connection
- Prepared statements for security
- Query builder methods
- Transaction support

### Session
- Secure session handling
- Flash messages
- Authentication helpers
- CSRF protection

### Config
- Environment-based configuration
- Configuration caching
- URL and path helpers
- Database configuration

### Model
- Active Record pattern
- Relationship handling
- Query building
- Data validation

### Controller
- Request handling
- Response generation
- View rendering
- Input validation

## Usage

### Creating a New Model

```php
namespace App\Models;

use App\Core\Model;

class Property extends Model
{
    protected $table = 'properties';
    protected $fillable = ['title', 'description', 'price', 'location'];
}
```

### Creating a New Controller

```php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Property;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = (new Property())->all();
        $this->view('properties/index', ['properties' => $properties]);
    }
}
```

### Using the Session

```php
// Set a flash message
$this->session->setFlash('success', 'Property created successfully');

// Get a flash message
$message = $this->session->getFlash('success');
```

### Database Queries

```php
// Using the query builder
$properties = $this->db->select('properties', '*', 'status = :status', [':status' => 'active']);

// Using the model
$property = (new Property())->find(1);
```

## Security Features

- SQL injection prevention
- XSS protection
- CSRF protection
- Secure password hashing
- Input validation
- Output escaping

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support, email support@yourdomain.com or create an issue in the repository.

## Acknowledgments

- [Bootstrap](https://getbootstrap.com/) for the frontend framework
- [Font Awesome](https://fontawesome.com/) for the icons
- [jQuery](https://jquery.com/) for JavaScript functionality