# EduAPI Documentation

**EduAPI** is an API for managing student and payment data in an educational institution.

## Authentication

To access the API, you need to authenticate by sending a POST request to the `/auth` endpoint with your credentials.

Example request body:

```json
{
  "email": "user1@example.com",
  "password": "password"
}
```

## Students

- `GET /students`: Get a list of all students.
- `POST /students`: Create a new student record.
- `GET /students/{studentId}`: Get a specific student by ID.
- `PUT /students/{studentId}`: Update a specific student by ID.
- `DELETE /students/{studentId}`: Delete a specific student by ID.

## Payments

- `GET /payments`: Get a list of all payments.
- `POST /payments`: Create a new payment record.
- `GET /payments/{paymentId}`: Get a specific payment by ID.
- `PUT /payments/{paymentId}`: Update a specific payment by ID.
- `DELETE /payments/{paymentId}`: Delete a specific payment by ID.

## Available Routes

Here are some sample requests to get you started:

```http
GET /students
GET /students/1
POST /students
PUT /students/1
DELETE /students/1

GET /payments
GET /payments/1
POST /payments
PUT /payments/1
DELETE /payments/1
```
