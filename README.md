# Bookstore

A web-based bookstore application built in PHP as a student project. This project demonstrates a full-featured online bookstore, including user authentication, shopping cart functionality, and an admin panel for managing books and users.

## Table of Contents

- [Project Purpose](#project-purpose)
- [Features](#features)
- [Screenshots](#screenshots)
- [Installation](#installation)
- [Usage](#usage)
- [Folder Structure](#folder-structure)
- [Technologies Used](#technologies-used)
- [Contributing](#contributing)
- [License](#license)

## Project Purpose

This repository was developed as a student project to showcase the implementation of a complete online bookstore. It is intended for developers and students interested in learning about web development with PHP, database integration, and e-commerce application design.

## Features

- User authentication (registration, login, and verification)
- Shopping cart for browsing and purchasing books
- Admin panel for managing books, users, and orders
- Book catalog with product details
- Newsletter subscription
- Basic email notifications (via SwiftMailer)
- Responsive front-end with HTML/CSS
- Database integration with SQL scripts

## Screenshots

*Add screenshots of your application here if possible, e.g., homepage, cart, admin panel*

## Installation

### Requirements

- PHP 5.2 or higher
- MySQL or compatible database
- Web server (e.g., Apache, Nginx)
- (Optional) Composer for PHP dependency management

### Setup Steps

1. **Clone the repository**
   ```sh
   git clone https://github.com/ar27111994/bookstore.git
   cd bookstore
   ```

2. **Database Setup**
   - Create a new MySQL database (e.g., `bookstore`).
   - Import the provided `Database.sql` file to create necessary tables and demo data:
     ```sh
     mysql -u yourusername -p bookstore < Database.sql
     ```

3. **Configure Database Connection**
   - Edit the file `includes/dbconnect.inc.php` and update your database credentials (host, username, password, database name).

4. **(Optional) Install Composer Dependencies**
   - If you want to use SwiftMailer or other PHP libraries, run:
     ```sh
     composer install
     ```

5. **Set up Virtual Host or Access via localhost**
   - Ensure your web server's document root points to the project directory.
   - Access the site via `http://localhost/bookstore` or your configured virtual host.

## Usage

- Visit the homepage (`index.php` or `index.html`) to browse books.
- Register for a new user account (`register.php` or `register.html`).
- Log in to add books to your cart and proceed to checkout.
- Admin users can log in to the admin panel to manage inventory and users.

## Folder Structure

```
bookstore/
│
├── admin/           # Admin panel scripts and pages
├── books/           # Book images or data
├── includes/        # PHP includes (e.g., dbconnect, mailer)
├── js/              # JavaScript files
├── stylesheet/      # CSS and font files
├── images/          # Image assets
├── Database.sql     # SQL schema and seed data
├── index.php        # Main landing page
├── register.php     # User registration
├── checkout.php     # Shopping cart and checkout
├── ...              # Other scripts (login, product details, etc.)
```

## Technologies Used

- PHP
- MySQL
- HTML, CSS, JavaScript
- SwiftMailer for email notifications

## Contributing

This project is intended for educational purposes but contributions are welcome. Please fork the repository and submit a pull request.

## License

*Specify your license here, or state "This project is for educational purposes only."*

---

*Developed by ar27111994 and contributors.*
