# Nikolay Ladygin / FoodSoul-test-task

## Task

Original task (in Russian): https://docs.google.com/document/d/11xyT6yRENQgaXN9Dm6pVrZ7NWVE3jaXJk8ZnpVOuuv8/edit?tab=t.0

### Translation

**Task:** URL Shortening Project Development

**Requirements:**

* Ability to shorten URLs via a web form
* Ability to shorten URLs via an API (JSON)
* Use MariaDB as the database
* Frameworks are not allowed
* Composer is not allowed
* Must follow OOP MVC principles

**For additional complexity:**

* Add user authentication and registration with email confirmation


## Setup Instructions

1. Deploy the project using Docker:

   ```
   docker compose up -d
   ```

2. By default, the application will be available at [http://localhost:8080/](http://localhost:8080/).
   You can change the port or other settings by editing the **app** container in `compose.yaml`.

3. To shorten a URL, either:

   * Enter your long URL into the form on the homepage, **or**
   * Send an API request to:

     ```
     http://localhost:8080/api/v1/shorten?url=<encoded-URL>
     ```
