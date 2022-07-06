# Coding Exercise - PHP/Laravel - Contacts
## Table of Contents
- [Coding Exercise - PHP/Laravel - Contacts](#coding-exercise---phplaravel---contacts)
  - [Table of Contents](#table-of-contents)
  - [About](#about)
  - [Create](#create)
    - [Example Usage](#example-usage)
  - [Read](#read)
    - [Example Usage](#example-usage-1)
  - [Update](#update)
    - [Example Usage](#example-usage-2)
  - [Delete](#delete)
    - [Example Usage](#example-usage-3)
  - [Authors Notes](#authors-notes)

## About
This Laravel project implements the ability Create / Read / Update / Delete (CRUD) Contacts in a MySQL database via API calls.

All example data used in this README was provided by https://www.fakenamegenerator.com

## Create
Creating a new contact is done via a POST request to `http://<url>/api/v1/contact/create` and has to contain **all** data required for a new contact.

The newly created contact is then returned.
### Example Usage
Request:
```bash
curl --location --request POST 'http://<url>/api/v1/contact/create' \
--form 'first_name="Robert"' \
--form 'last_name="Castro"' \
--form 'email_address="RobertLCastro@dayrep.com"' \
--form 'phone_number="+ 01 303-413-0019"' \
--form 'company="Matrix Architectural Service"' \
--form 'street="Sweetwood Drive"' \
--form 'date_of_birth="20-12-1974"'
```
Response:
```json
{
    "first_name": "Robert",
    "last_name": "Castro",
    "email_address": "RobertLCastro@dayrep.com",
    "phone_number": "+ 01 303-413-0019",
    "company": "Matrix Architectural Service",
    "street": "Sweetwood Drive",
    "date_of_birth": "1974-12-20T00:00:00.000000Z",
    "updated_at": "2022-07-06T14:51:19.000000Z",
    "created_at": "2022-07-06T14:51:19.000000Z",
    "id": 1
}
```
## Read
Reading/Getting an existing contact is done via a GET request to `http://<url>/api/v1/contact/read`. If any paramaters are provided contacts will be filtered for them.

Any found contact will then be returned as part of an array. (This array can be empty if no contact was found)
### Example Usage
Request
```bash
curl --location --request GET 'http://<url>/api/v1/contact/read'
```
Response
```json
[
    {
        "id": 1,
        "first_name": "Robert",
        "last_name": "Castro",
        "email_address": "RobertLCastro@dayrep.com",
        "phone_number": "+ 01 303-413-0019",
        "company": "Matrix Architectural Service",
        "street": "Sweetwood Drive",
        "date_of_birth": "1974-12-20T00:00:00.000000Z",
        "created_at": "2022-07-06T14:51:19.000000Z",
        "updated_at": "2022-07-06T14:51:19.000000Z"
    },
    {
        "id": 2,
        "first_name": "Tanja",
        "last_name": "Holzman",
        "email_address": "TanjaHolzman@jourrapide.com",
        "phone_number": "+43 0676 659 72 24",
        "company": "House Works",
        "street": "Annenstrasse 8",
        "date_of_birth": "1950-02-15T00:00:00.000000Z",
        "created_at": "2022-07-06T15:02:02.000000Z",
        "updated_at": "2022-07-06T15:02:02.000000Z"
    }
]
```
Request:
```bash
curl --location --request GET 'http://<url>/api/v1/contact/read?keyword=Tanja'
```
Response:
```json
[
    {
        "id": 2,
        "first_name": "Tanja",
        "last_name": "Holzman",
        "email_address": "TanjaHolzman@jourrapide.com",
        "phone_number": "+43 0676 659 72 24",
        "company": "House Works",
        "street": "Annenstrasse 8",
        "date_of_birth": "1950-02-15T00:00:00.000000Z",
        "created_at": "2022-07-06T15:02:02.000000Z",
        "updated_at": "2022-07-06T15:02:02.000000Z"
    }
]
```
Request:
```bash
curl --location --request GET 'http://<url>/api/v1/contact/read?keyword=Nobody'
```
Response:
```json
[]
```
## Update
Updating a contact is done via a POST request to `http://<url>/api/v1/contact/update` and **has to** contain the ID of the contact you want to edit. Only properties you edit have to be set, unchanged properties can be null or not sent at all.

It will return both the original and updated contact.

### Example Usage
Request:
```bash
curl --location --request POST 'http://<url>/api/v1/contact/update' \
--form 'id="1"' \
--form 'phone_number="+ 49 06573 13 62 12"' \
--form 'street="Luetzowplatz 66"'
```
Response:
```json
{
    "old": {
        "id": 1,
        "first_name": "Robert",
        "last_name": "Castro",
        "email_address": "RobertLCastro@dayrep.com",
        "phone_number": "+ 01 303-413-0019",
        "company": "Matrix Architectural Service",
        "street": "Sweetwood Drive",
        "date_of_birth": "1974-12-20T00:00:00.000000Z",
        "created_at": "2022-07-06T14:51:19.000000Z",
        "updated_at": "2022-07-06T14:51:19.000000Z"
    },
    "new": {
        "id": 1,
        "first_name": "Robert",
        "last_name": "Castro",
        "email_address": "RobertLCastro@dayrep.com",
        "phone_number": "+ 49 06573 13 62 12",
        "company": "Matrix Architectural Service",
        "street": "Luetzowplatz 66",
        "date_of_birth": "1974-12-20T00:00:00.000000Z",
        "created_at": "2022-07-06T14:51:19.000000Z",
        "updated_at": "2022-07-06T15:27:04.000000Z"
    }
}
```
## Delete
Deleting a contact is done via a POST request to `http://<url>/api/v1/contact/update` and **has to** contain the ID of the contact you want to delete.

It will return the deleted contact on success.

### Example Usage
Request:
```bash
curl --location --request POST 'http://<url>/api/v1/contact/delete' \
--form 'id="1"'
```
Response:
```json
{
    "id": 1,
    "first_name": "Robert",
    "last_name": "Castro",
    "email_address": "RobertLCastro@dayrep.com",
    "phone_number": "+ 49 06573 13 62 12",
    "company": "Matrix Architectural Service",
    "street": "Luetzowplatz 66",
    "date_of_birth": "1974-12-20T00:00:00.000000Z",
    "created_at": "2022-07-06T14:51:19.000000Z",
    "updated_at": "2022-07-06T15:27:04.000000Z"
}
```

## Authors Notes
This was the very first time I have worked with Laravel so I have to assume some of my approaches were less than optimal as they're heavily based on the example-app provided when creating a new Laravel application, the [documentation](https://laravel.com/docs/9.x/) as well as [Laravel 8 From Scratch](https://laracasts.com/series/laravel-8-from-scratch).

I have decided on the `http://<url>/api/v1/<etc>` URL due to having worked with a few APIs in the past which ranged from v1 all the way to v10.

The task of creating an API to store and manipulate contacts seemed very daunting to me at first, however, after somewhat familiarizing myself with Laravel, it was actually fun how much simpler it was to implement than I had initially thought.

I am aware that Laravel also implements tools for authentification using a token for example, but I believe that doing so would be beyond the scope of this exercise.

The tools I used for this project were:
- [Visual Studio Code](https://code.visualstudio.com)
- [Docker](https://www.docker.com)
- [Postman](https://www.postman.com)