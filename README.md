# CarBrand App

TaskApp is a simple task management application built with Laravel. It allows users to create and view Brand,Models with attachments.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [API Endpoints](#api-endpoints)

## Requirements

To run this project, ensure your server meets the following requirements:

- **PHP**: 8.2+ or higher
- **Composer**: Latest version

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/samir480/car_brand.git
2. Install dependencies
   ```bash
   cd car_brand
   composer install
   npm install
3. Create a .env file
   ```bash
   cp .env.example .env
4. Generate an application key
   ```bash
   php artisan key:generate
5. Configure your database:
   ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password

8. Run the development server with vite:
   ```bash
   composer run dev



## API Endpoints

1. Brands
   
   Brand List (GET)
   ```bash
   /api/brands
    ```
   ```bash
   {
    "data": [
        {
            "id": 26,
            "name": "hyndai",
            "logo": "http://127.0.0.1:8000/storage/logos/1JYfCS6Jfnob0QRgVpzy10iMApCCJudY77rfmJMH.jpg"
        },
        {
            "id": 27,
            "name": "Tata",
            "logo": "http://127.0.0.1:8000/storage/logos/ET8Q5NjucKnbdABVbJmNQMVYHYa1w4uX6UhcFH0k.jpg"
        }
        ]
    }
   ```
   Brand Details (GET)
   ```bash
   /api/brand/{brand}
   ```
   ```bash
   {
    "data": {
        "id": 26,
        "name": "hyndai",
        "logo": "http://127.0.0.1:8000/storage/logos/1JYfCS6Jfnob0QRgVpzy10iMApCCJudY77rfmJMH.jpg",
        "models": [
            {
                "id": 3,
                "name": "h1",
                "year": 2002,
                "image": "http://127.0.0.1:8000/storage/images/egP5ID8eXQWgGiDC8opzKHUL4z8Q8D8h0OVYPdp3.jpg"
            }
        ]
    }
    }
   ```
3. Brand Model
    Create Model (POST)
   ```bash
   /api/model/store
    ```
   ```bash
    {
      "name": "H1",
      "year": "2022",
      "brand_id": "1",
    }

   ```






