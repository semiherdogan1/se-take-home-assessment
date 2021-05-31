# Ideasoft Take-Home Assesment

## Requirements

- [Laravel 8 Requirements](https://laravel.com/docs/8.x/deployment#server-requirements)
- PHP >= 7.3
- MySQL >= 5.7

## Installation

- `cp .env.example .env`
- Fill db related variables in `.env`
- `php composer.phar install`
- `php artisan key:generate`
- Run `php artisan migrate` to migrate database.
- If you want to fill database with dummy data you can run this command: `php artisan db:seed`.

## Notes

- For login and register, I have used [Laravel Sanctum](https://laravel.com/docs/8.x/sanctum) library. (Only using
  in `app/Services/CustomerService`)
- For cache, I have used laravel's default caching mechanism.
- For payload validation, I have used laravel's request classes. You can see in `app/Http/Requests`.
- For db structure you can see migrations in `database/migrations` folder. Alternatively you may
  check [db_structure.sql](db_structure.sql) file.

## Notes for docker

- If you need to run this project in docker container, I have added [Laravel Sail](https://laravel.com/docs/8.x/sail)
  package as dev dependency.
- You can check [docker-compose.yml](docker-compose.yml) file.
- Next you need to update env variables. (you can see updates here `vendor/laravel/sail/src/Console/InstallCommand.php`
  line: 112).
- Then run this command from root folder of this project`./vendor/bin/sail up -d`

---

# Endpoints

* You can check [requests.http](requests.http) file to see all request examples. (You can also use this file in phpstorm
  as http client)

## Register

- Register a new user.

### Request

* POST `/api/register`

```json
{
  "name": "Semih ERDOGAN",
  "email": "semih@semiherdogan.net",
  "password": "XXXXXX"
}
```

### Success Response

```json
{
  "code": 0,
  "message": null,
  "data": {
    "id": 8,
    "name": "Semih ERDOGAN",
    "email": "semih@semiherdogan.net"
  }
}

```

### Error Response

```json
{
  "code": 2001,
  "message": "The email has already been taken.",
  "data": null
}
```

---

## Login

- Send login credentials and get api token.

### Request

* POST `/api/login`

```json
{
  "email": "semih@semiherdogan.net",
  "password": "XXXXXX"
}
```

### Success Response

```json
{
  "code": 0,
  "message": null,
  "data": {
    "token_type": "Bearer",
    "access_token": "XXXXXXXXXXXXXXXXXXX"
  }
}
```

### Error Response

```json
{
  "code": 2002,
  "message": "Invalid login details.",
  "data": null
}
```

---

## Products

- Gets product list.

### Request

* GET `/api/products` (`Authorization: Bearer {{auth_token}}`)

### Success Response

```json
{
  "code": 0,
  "message": null,
  "data": [
    {
      "id": 1,
      "name": "Ad non facere distinctio nihil.",
      "category_id": 1,
      "category": "non_test",
      "price": 892.36,
      "stock": 3
    },
    {
      "id": 2,
      "name": "Voluptate assumenda numquam quasi illo.",
      "category_id": 2,
      "category": "test",
      "price": 796.19,
      "stock": 9
    }
  ]
}
```

---

## Orders

- Get order list for customer.

### Request

* GET `/api/orders` (`Authorization: Bearer {{auth_token}}`)

### Success Response

```json
{
  "code": 0,
  "message": null,
  "data": [
    {
      "id": 4,
      "total": 32940.56,
      "items": [
        {
          "product_id": 3,
          "quantity": 3,
          "unit_price": 180.05,
          "total": 32417.42
        },
        {
          "product_id": 1,
          "quantity": 4,
          "unit_price": 22.87,
          "total": 523.14
        }
      ]
    },
    {
      "id": 5,
      "total": 61152.8,
      "items": [
        {
          "product_id": 2,
          "quantity": 14,
          "unit_price": 143.62,
          "total": 20626.95
        },
        {
          "product_id": 4,
          "quantity": 7,
          "unit_price": 201.31,
          "total": 40525.85
        }
      ]
    }
  ]
}
```

---

## Add product

- Add product into active order list (card).

### Request

* POST `/api/orders` (`Authorization: Bearer {{auth_token}}`)

### Success Response

```json
{
  "code": 0,
  "message": null,
  "data": null
}
```

---

## Delete product

- Delete product from active order list.

### Request

* DELETE `/api/orders` (`Authorization: Bearer {{auth_token}}`)

### Success Response

```json
{
  "code": 0,
  "message": null,
  "data": null
}
```

---

## Discounts

- Get discounts for active order (card).

### Request

* GET `/api/discounts` (`Authorization: Bearer {{auth_token}}`)

### Success Response

```json
{
  "code": 0,
  "message": null,
  "data": {
    "order_id": 28,
    "discounts": [
      {
        "reason": "10_PERCENT_OVER_1000",
        "amount": 157.5,
        "subtotal": 1417.53
      },
      {
        "reason": "BUY_5_GET_1",
        "amount": 71.15,
        "subtotal": 284.6
      },
      {
        "reason": "CHEAPEST_20_PERCENT_OVER_BUY_2",
        "amount": 40.65,
        "subtotal": 365.87
      }
    ],
    "total": 1575.03,
    "total_discounts": 269.3,
    "discounted_total": 1305.73
  }
}
```

### Success (bu no discounts) Response

```json
{
  "code": 0,
  "message": null,
  "data": {
    "order_id": 32,
    "discounts": [],
    "total": 892.36,
    "total_discounts": 0,
    "discounted_total": 892.36
  }
}
```
