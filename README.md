# Codemal 7 Day project

## API Documentation

### Base Url

The Base URL for all all endpoint is : `https://codemal.newwaymm.com`

### Event Route

#### Get All Events

- __URL__: `/events`
- __Method__: `GET`
- __Description__: Retrieve a list of all events.
- __Example Request__: 

    ```bash
    GET https://codemal.newwaymm.com/api/events
    ```
- __Example Response__:

    ```json
        {
            "id": 4,
            "title": "Et et hic fuga animi.",
            "description": "Quasi et eos minima illum dolore ducimus labore. Voluptatem qui perspiciatis nobis qui    nesciunt qui. Placeat nihil veniam nemo occaecati earum ut ipsum molestiae. Et molestiae eos itaque in     non nam.",
            "image": "https://via.placeholder.com/800x600.png/00bb66?text=events+consequatur",
            "start_date": "2010-02-07",
            "end_date": "2012-01-13",
            "org_name": "Ernser-O'Conner",
            "org_email": "casper.ellie@wilderman.com",
            "org_phone": "1-857-331-5297",
            "org_logo": "https://via.placeholder.com/200x200.png/003322?text=logos+voluptatem",
            "category_id": 2,
            "limit": 65,
            "location": "837 Gisselle Divide\nSouth Carroll, CA 89897-7226",
            "plaform": "Online",
            "created_by": null,
            "created_at": "2024-09-02T14:46:17.000000Z",
            "updated_at": "2024-09-02T14:46:17.000000Z",
            "rating": null
        }
    ```
  
#### Get Latest Events

- __URL__: `/events/latest`
- __Method__: `GET`
- __Description__: Retrieve the latest events.
- __Example Request__:
  
    ```bash
    GET https://codemal.newwaymm.com/api/events/lastest
    ```
- __Example Response__: 
  
    ```json
        {
            "id": 51,
            "title": "event1",
            "description": "hvbubvqv9qff",
            "image": "events/images/9ziflaHdT1byN2xNoagNdqIvykP39Fy6tZMKc2yU.jpg",
            "start_date": "2024-09-04",
            "end_date": "2024-09-07",
            "org_name": null,
            "org_email": null,
            "org_phone": null,
            "org_logo": "events/org_logos/D9MVO9mHIBtN0ytoR2Nvtha22UP8Ij23eugJUG0m.jpg",
            "category_id": 1,
            "limit": null,
            "location": null,
            "plaform": null,
            "created_by": null,
            "created_at": "2024-09-04T08:58:10.000000Z",
            "updated_at": "2024-09-04T08:58:10.000000Z",
            "rating": null
        }
    ```

#### Get Event Detail

- __URL__: `/event/{id}`
- __Method__: `GET`
- __Description__: Retrieve detailed information about a specific event by ID.
- __Example Request__:
  
    ```bash
    GET https://codemal.newwaymm.com/api/event/5
    ```
- __Example Response__:
  
    ```json
        {
            "event": {
                "id": 4,
                "title": "Et et hic fuga animi.",
                "description": "Quasi et eos minima illum dolore ducimus labore. Voluptatem qui perspiciatis nobis qui nesciunt qui. Placeat nihil veniam nemo occaecati earum ut ipsum molestiae. Et molestiae eos itaque in non nam.",
                "image": "https://via.placeholder.com/800x600.png/00bb66?text=events+consequatur",
                "start_date": "2010-02-07",
                "end_date": "2012-01-13",
                "org_name": "Ernser-O'Conner",
                "org_email": "casper.ellie@wilderman.com",
                "org_phone": "1-857-331-5297",
                "org_logo": "https://via.placeholder.com/200x200.png/003322?text=logos+voluptatem",
                "category_id": 2,
                "limit": 65,
                "location": "837 Gisselle Divide\nSouth Carroll, CA 89897-7226",
                "plaform": "Online",
                "created_by": null,
                "created_at": "2024-09-02T14:46:17.000000Z",
                "updated_at": "2024-09-02T14:46:17.000000Z",
                "rating": null
            }
        }
    ```

#### Search Event Title and Category

- __URL__: `/events/search`
- __Method__: `GET`
- __Description__: Search for events based on title and category.
- __Query Parameters__: 
  - `title` (string, optional): The title of the event.
  - `category` (string, optional): The title of the event.
- __Example Request__: 
  
    ```bash
    GET https://codemal.newwaymm.com/api/events/search?title=workshop&category=technology
    ```
- __Example Response__: 
  
    ```json
        "events": {
            "data": [
                    {
                        "id": 51,
                        "title": "event1",
                        "description": "hvbubvqv9qff",
                        "image": "events/images/9ziflaHdT1byN2xNoagNdqIvykP39Fy6tZMKc2yU.jpg",
                        "start_date": "2024-09-04",
                        "end_date": "2024-09-07",
                        "org_name": null,
                        "org_email": null,
                        "org_phone": null,
                        "org_logo": "events/org_logos/D9MVO9mHIBtN0ytoR2Nvtha22UP8Ij23eugJUG0m.jpg",
                        "category_id": 1,
                        "limit": null,
                        "location": null,
                        "plaform": null,
                        "created_by": null,
                        "created_at": "2024-09-04T08:58:10.000000Z",
                        "updated_at": "2024-09-04T08:58:10.000000Z",
                        "rating": null
                    },
                    {
                        "etc..."
                    }
                ]
            }
    ```

### Auth Route

#### Rigister User

- __URL__: `/register`
- __Method__: `POST`
- __Description__: Register new user.
- __Example Request__: 
  
    ```bash
    POST https://codemal.newwaymm.com/api/register
    ```
- __Example Request Body__: 

    ```json
        {
            "name": "User1",
            "email": "user1@example.com",
            "phone": "0912345678",
            "password": "password123"
        }
    ```

- __Example Response__:
  
    ```json
        {
            "message": "Register successfully",
            "data": {
                "name": "User1",
                "email": "user1@example.com",
                "phone": "0912345678",
                "updated_at": "2024-09-05T11:42:47.000000Z",
                "created_at": "2024-09-05T11:42:47.000000Z",
                "id": 9
            },
            "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNzI1NTM2NTY3LCJleHAiOjE3MjU1NDAxNjcsIm5iZiI6MTcyNTUzNjU2NywianRpIjoiVTN1MThCOEF2SzNwdlhLbSIsInN1YiI6IjkiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.mdtPOUoU7e9P"
        }
    ```

#### Login User

- __URL__: `/login`
- __Method__: `POST`
- __Description__: Login a user.
- __Example Request__: 
  
    ```bash
    POST https://codemal.newwaymm.com/api/login
    ```
- __Example Request Body__: 
  
    ```json
        {
            "email": "user5@example.com",
            "password": "password123"
        }
    ```
- __Example Response__: 
  
    ```json
        {
        "message": "Login successfully.",
        "user": {
            "id": 6,
            "avatar": null,
            "name": "User5",
            "email": "user5@example.com",
            "phone": "09774829397",
            "email_verified_at": null,
            "created_at": "2024-09-04T09:05:42.000000Z",
            "updated_at": "2024-09-04T09:05:42.000000Z"
        },
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzI1NDY5NDM1LCJleHAiOjE3MjU0NzMwMzUsIm5iZiI6MTcyNTQ2OTQzNSwianRpIjoiaHlNOWd6OG1TYkVsbUNoSSIsInN1YiI6IjYiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.vjf"
        }
    ```

#### Forgot Password


#### Reset Password


#### Logout User

- __URL__: `/logout`
- __Method__: `POST`
- __Description__: Logout User.
- __Example Request__:
  
    ```bash
    POST https://codemal.newwaymm.com/api/logout
    ```
- __Example Response__:
  
    ```json
        {
            "message": "Successfully logged out"
        }
    ```

#### Get Profile

- __URL__: `/profile`
- __Method__: `GET`
- __Description__: Get the authenticated user's profile.
- __Example Request__:
  
    ```bash
    GET https://codemal.newwaymm.com/api/profile
    ```
- __Example Response__: 

    ```json
        {
            "id": 6,
            "avatar": null,
            "name": "User5",
            "email": "user5@example.com",
            "phone": "09774829397",
            "email_verified_at": null,
            "created_at": "2024-09-04T09:05:42.000000Z",
            "updated_at": "2024-09-04T09:05:42.000000Z"
        }
    ```

#### Protected Event Routes

- __URL__: `/event/create`
- __Method__: `POST`
- __Description__: Create a new event **(requires authentication)**.
- __Example Request__: 
  
    ```bash
    POST https://codemal.newwaymm.com/api/event/create
    ```
- __Example Request Body__:
  
    | Field         | Type     | Required |
    | ------------- | -------- | -------- |
    | title         | String   | true     |
    | `description` | `String` | false    |
    | `image`       | `file`   | [x]     |
    | `start_date`  | `date`   | false    |
    | `end_date`    | `date`   | [ ]    |
    | `org_name`    | `String` | [ ] |

- [X]
- __Example Response__: 

    ```json
        {
        "message": "Event created successfully",
        "data": {
            "title": "event1",
            "description": "hvbubvqv9qff",
            "image": "events/images/LnXpGCjJfINhxK3tYVmIAHAHGJIMCXgfzP03gPbD.jpg",
            "start_date": "2024-09-04",
            "end_date": "2024-09-07",
            "org_name": null,
            "org_email": null,
            "org_phone": null,
            "org_logo": null,
            "category_id": "1",
            "limit": null,
            "location": null,
            "plaform": null,
            "created_by": 6,
            "updated_at": "2024-09-04T17:23:04.000000Z",
            "created_at": "2024-09-04T17:23:04.000000Z",
            "id": 52
            }
        }
    ```
    
