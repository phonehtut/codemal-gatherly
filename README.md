# Codemal 7 Day project

## Api route

### Event Api

1. Show All Event
    - **Endpoint**: `GET https://codemal.newwaymm.com/api/events`
    - **Description**: Retrieves a list of all events.

2. Show Latest Events
    - **Endpoint:** `GET https://codemal.newwaymm.com/api/lastest`
    - **Description:** Retrieves a list of latest events.

3. Create Event
    - **Endpoint:** `POST https://codemal.newwaymm.com/api/create`
    - **Description:** Allows the creation of a new event.
    - **Payload**: 
```json
{
    "message": "Event created successfully",
    "date": {
        "title": "event1",
        "description": "hvbubvqv9qff",
        "image": "events/images/2nTD8w0Ai1hn05XaC9PVPhrXFv9dWEvbjzMTngpi.jpg",
        "start_date": "2024-09-04",
        "end_date": "2024-09-07",
        "org_name": null,
        "org_email": null,
        "org_phone": null,
        "org_logo": "events/logos/VsKZegCCfuOCoOL5FYppmrkDJrdai2rDdkZyfcxx.jpg",
        "category_id": "1",
        "limit": null,
        "location": null,
        "plaform": null,
        "created_by": 3,
        "updated_at": "2024-09-03T20:09:09.000000Z",
        "created_at": "2024-09-03T20:09:09.000000Z",
        "id": 56
    }
}
   ```


- `https://codemal.newwaymm.com/api/{eventId}` <- Event Detail Route


### Form Api

- `https://codemal.newwaymm.com/api/{eventId}/form` <- submit register form
