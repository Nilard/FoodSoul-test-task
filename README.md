# Nikolay Ladygin / FoodSoul-test-task

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
