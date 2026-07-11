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
**logout** 
    - the logout function is destroy
    - Auth::logout()
    - return redirect()->route('welcome')