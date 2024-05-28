* Please run the commands below:
    ```bash
    sail up -d
    sail artisan migrate:fresh --seed
    sail artisan tinker
    ```
  In Tinker, run:
    ```php
    User::find(2)->createToken('test')
    ```
  To authenticate the user, use the `plainTextToken` as the bearer token in Postman.
    ```bash
    sail artisan queue:work
    ```

* Postman collection:
  [docs/cart.json](docs/cart.json)

* You can use your Mailtrap (or other driver) in the `.env` file.
