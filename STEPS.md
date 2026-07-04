# How to make the Authentication task?

## Description
Implement the UI and forms for registration, login, and profile editing. Then update the dev-specific endpoints within your `routes/web.php` file accordingly.

## Steps

1. **Create the registration form**. It should include: First Name, Last Name, Username, Email, Password, Confirm Password. 
2. **Validate the form** on the client and server side.
3. **Create a controller** to handle the registration request. It should create a new user in the database and log them in.



# Store Function of the AuthController
## Description
Create the store method of the AuthController to handle the registration request.
## Steps
1. **Validate the form** on the client and server side.
    - What are the fields we need in form?
        - Name
        - Email
        - Handle (in the profile of the users)
        - Password
        - Confirm Password
    - What are the rules for each field?
        - Name: required, string, max:255, min:3, trim
        - Email: required, email, unique:users, trim
        - Handle: required, string, max:255, min:3, trim, unique:profiles, handle
        - Password: required, string, max:255, min:8, trim, confirmed
        - Confirm Password: required, string, max:255, min:8, trim
2. **Create the new user** in the database
3. **Create the new profile** in the database and link it to the new user
4. **Log in the new user** in the application
5. **Redirect the new user** to the feed page
