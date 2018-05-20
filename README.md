# Test task laravel

### Requirements
1. [Composer](https://getcomposer.org/download/)
2. [Docker](https://www.docker.com/community-edition)

## Installing

```bash
user@user:~# git clone https://github.com/xo666/test_task_laravel.git
user@user:~# cd test_task_laravel
user@user:~# composer install
user@user:~# docker-compose up -d
user@user:~# docker exec -it test_task_laravel_app_1 bash
root@a1bfb171ddaa:/var/www# cp .env.example .env 
root@a1bfb171ddaa:/var/www# php artisan key:generate
root@a1bfb171ddaa:/var/www# php artisan migrate
root@a1bfb171ddaa:/var/www# php artisan passport:install
root@a1bfb171ddaa:/var/www# php artisan config:clear
```

## Cron

Task: Create a script that stores the sum of all transactions from previous day.
      Attach a file where you add the command you use to set up the cron job to run every 2 days at 23:47

Whats done:

1) Created Command SummTransactions.php (`transactions:summ`)

2) Created cronjob file: `crontab`

# Usage Front

1) Registration: `http://localhost:8080/register`

2) Authorization: `http://localhost:8080/login`

3) Page with transactions list, which loads from API `http://localhost:8080/transactions`

## Usage API

### 1)Authorization

*P.S First you need to register user, you can do it from : `http://localhost:8080/register`*

**Request**:
```json
{
   "request_type": POST,
   "url" : "http://localhost:8080/api/auth",
   "post_parameters": {
      "email" : "string",
      "password" : "string",
   }
}
```

**Response**:
```json
{
    "data": {
        "token": "........."
    }
}
```

## `Next: Save this token.`

**Every request to the API should containt:**
```php
    <?php
    $requestHeaders = [
        "Authorization" => "Bearer {$token}"
    ];
```


### 2) Add new Customer

**Request**:
```json
{
   "request_type": POST,
   "url" : "http://localhost:8080/api/customer/create",
   "post_parameters": {
      "name" : "string",
      "cnp" : "string",
   },
   "headers" : {
      "Authorization" : "Bearer {$token}"
   }
}
```

**Response**:
```json
{
    "customer_id": 1
}
```


### 3)Getting transaction by customer_id and transactionId 

**Request**:
```json
{
   "request_type": GET,
   "url" : "http://localhost:8080/api/transaction/{customer_id}/{transactionId}",
   "headers" : {
      "Authorization" : "Bearer {$token}"
   }
}
```

**Response**:
```json
{
    "id": 1,
    "customer_id": 1,
    "amount": "1000.00",
    "created_at": "2018-05-20 19:45:30",
    "updated_at": "2018-05-20 19:45:30"
}
```

### 4)Getting transaction by Filters

*Filters*:

| *Description*   |      *Parameters*      |  *Format* |
|----------|:-------------:|------:|
| Customer id |  **customer_id** | Int |
| Amount min |  **amount_min** | Int |
| Amount max |  **amount_max** | Int |
| Date range |  [ **date_from**, **date_to** ] | Date('yyyy-mm-dd') |
| Offset |  **offset** | Int |
| Limit |  **limit** | Int |


**Request**:

```json
{
   "request_type": GET,
   "url" : "http://localhost:8080/api/transaction{?filters}",
   "headers" : {
      "Authorization" : "Bearer {$token}"
   }
}
```

**Response**:

```json
[
    {
         "id": 1,
         "customer_id": 1,
         "amount": "500.00",
         "created_at": "2018-05-20 19:45:30",
         "updated_at": "2018-05-20 19:45:30"
    },
    {
         "id": 2,
         "customer_id": 1,
         "amount": "1000.00",
         "created_at": "2018-05-20 19:45:30",
         "updated_at": "2018-05-20 19:45:30"
    }
    ....
]
```

### 5)Adding new transaction

**Request**:
```json
{
   "request_type": POST,
   "url" : "http://localhost:8080/api/transaction",
   "post_parameters" : {
      "customer_id" : "Int",
      "amount" : "Numeric", 
   },
   "headers" : {
      "Authorization" : "Bearer {$token}"
   }
}
```

**Response**:
```json
{
    "message": "Transaction Created, Id:3",
    "data": {
        "customer_id": "1",
        "amount": "300",
        "updated_at": "2018-05-20 17:52:10",
        "created_at": "2018-05-20 17:52:10",
        "id": 3
    }
}
```

### 6)Updating new transaction

**Request**:
```json
{
   "request_type": PATCH,
   "url" : "http://localhost:8080/api/transaction/{transaction_id}",
   
   "patch_parameters" : {
      "amount" : "Numeric", 
   },
   "headers" : {
      "Authorization" : "Bearer {$token}"
   }
}
```

**Response**:
```json
{
    "id": 1,
    "customer_id": 1,
    "amount": "300",
    "created_at": "2018-05-20 19:45:30",
    "updated_at": "2018-05-20 17:54:24"
}
```

### 7)Delete transaction

**Request**:
```json
{
   "request_type": DELETE,
   "url" : "http://localhost:8080/api/transaction/{transaction_id}",
   "headers" : {
      "Authorization" : "Bearer {$token}"
   }
}
```

**Response**:
```json
{
    "data": "success/failt"
}
```