# Laravel RESTful API Application

This is a simple Laravel application that manages "User" and "Post" entities. The application implements a RESTful API that allows the following operations:

## Prerequisites
- Docker
- Docker Compose

## Installation

1. Build and start the Docker containers:
    ```sh
    docker-compose up --build -d
    ```

2. Install the dependencies:
    ```sh
    docker-compose exec php composer install
    ```

3. Create the `.env` file from the example and generate an application key:
    ```sh
    cp src/.env.example src/.env
    docker-compose exec php php artisan key:generate
    ```

4. Run the migrations:
    ```sh
    docker-compose exec php php artisan migrate
    ```

## Usage

The application will be available at `http://localhost`. You can interact with the API using tools like `curl`, Postman, or any other API client.

### API Endpoints

#### Users
- `GET /api/users`: Retrieve a list of users
- `GET /api/users/{id}`: Retrieve user details by ID
- `POST /api/users`: Create a new user
- `PUT /api/users/{id}`: Update user details
- `DELETE /api/users/{id}`: Delete a user

#### Posts
- `GET /api/posts`: Retrieve a list of posts
- `GET /api/posts/{id}`: Retrieve post details by ID
- `POST /api/posts`: Create a new post
- `PUT /api/posts/{id}`: Update post details
- `DELETE /api/posts/{id}`: Delete a post
- `GET /api/users/{userId}/posts`: Retrieve all posts of a user

## Running Tests

To run the tests, execute the following command:
```sh
docker-compose exec php php artisan test
