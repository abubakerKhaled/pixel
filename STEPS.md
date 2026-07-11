# How to make the Authentication task?

## Description
Implement the UI and forms for registration, login, and profile editing. Then update the dev-specific endpoints within your `routes/web.php` file accordingly.

## Feature

- **Login Feature**
    - Create the login form
    - create the login controller


### Steps

- create SessionsController
- create a logout feature
- create a login feature


### Implentation details
**login** 
    - We have the form with the Email and password fields
    - the user enters the email and password and we check if the user exists in the database
    - if the user exist we check the password
    - if the password correct log the user in
    - if the password is not match show error message in the login page
    - if the user is not exist show error message in the login page

