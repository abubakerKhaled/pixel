# How to make the Authentication task?

## Description
Implement the UI and forms for registration, login, and profile editing. Then update the dev-specific endpoints within your `routes/web.php` file accordingly.

## Feature

- **Profile editing**
    - What are the fields we want to edit in the form?
        - Name
        - Handle 
        - Bio

- **Steps**
    1. User must be authenticated.
    2. User must enter a uniqe handle.
    3. User must enter the password, to check if he is the real user.


- **Implementation**
    - Create a form to edit the profile
    - form filds are:
        - Name
        - Handle 
        - Bio
        - password confirmation (to check if he is the real user)

    - the user sumbit the form 
    - we check the password to be the correct one
    - if yes change the fields
    - if no redirect to the profile page with error message



### Controller details
- name is `Profile\ProfileController`
- methods:
    - `edit` - show the profile edit form
    - `update` - update the profile


### Routes details
- `GET /profile` - show the profile edit form
- `PUT /profile` - update the profile
