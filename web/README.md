
# Running Project With Docker

## Prerequisites
* Docker installed on your machine
* Docker Compose installed on your machine
## Setup Instructions
* Clone this repository to your local machine
* Navigate to the project directory
  Run the following command to build the Docker containers:

```
docker-compose up -d
```

# Running App Locally

This repository contains a Laravel application that can be easily set up and run locally on your machine.

## Prerequisites
- PHP installed on your machine
- Composer installed on your machine
- MySQL or any other database management system installed on your machine

## Setup Instructions
1. Clone this repository to your local machine
2. Navigate to the project directory
3. Install PHP dependencies by running:
   ```
   composer install
   ```
4. Copy the `.env.example` file to `.env` and update the database configurations
5. Generate a new application key by running:
   ```
   php artisan key:generate
   ```
6. Run the database migrations to set up the database schema:
   ```
   php artisan migrate db:seed
   ```
7. Start the Laravel development server by running:
   ```
   php artisan serve
   ```
8. You can now access the Laravel application at `http://localhost:8000`

9. now can run the tests with
    ```
    php artisan test
   ```
## Additional Notes
- You can test the app using Postman by calling the API routes.
- After seeding the database, you can call the API routes as follows:
1. To report a delay for an order: : 
   ```
   http://localhost:8000/api/orders/{order_id}/delay
   ```
2. To assign a delayed order to an agent :
   ```
   http://localhost:8000/api/agents/{agent_id}/assign-delay-order
   ```
3. To get a report of vendor delays : 
   ```
   http://localhost:8000/api/vendors/get-delayed-orders-report
   ```
4. To mark an assigned delayed order as resolved by an agent:   
   ```
   http://localhost:8000/api/agents/{agent_id}/resolve-order
   ```

## Additional Information About My Approach

- The most important issue was handling the queue for delayed orders. Ideally, Redis should be used to manage the queue, as it easily supports FIFO and effectively manages race conditions. However, due to time constraints, I implemented a simpler solution


- When handling race conditions in assigning delayed orders to agents, there are various approaches. One option is to use Laravel's cache lock feature, but this method is not scalable. I opted to use database transactions, which offer a more reliable and scalable solution.


- I used a DTO (Data Transfer Object) for the responses in the service layer. Generally, it's best practice to create a specific DTO for each function. I am aware of this, but due to time constraints and the need for simplicity, I used a single DTO for all methods in this task.
