# API Documentation - `library` Project

## Base URL

`/api`

## Authentication

- Type: Bearer Token (Laravel Sanctum)
- Login endpoint:
    - `POST /api/login`
- Header for protected endpoint:
    - `Authorization: Bearer {token}`
    - `Accept: application/json`

## Route Summary

| Method    | Endpoint                | Auth | Handler                        | Status                                             |
| --------- | ----------------------- | ---- | ------------------------------ | -------------------------------------------------- |
| POST      | `/api/login`            | No   | `AuthController@loginApi`      | OK                                                 |
| POST      | `/api/logout`           | Yes  | `AuthController@logout`        | Active, but uses web logout flow                   |
| GET       | `/api/me`               | Yes  | `AuthController@me`            | Configured, method not found in current controller |
| GET       | `/api/user`             | Yes  | Closure                        | OK                                                 |
| GET       | `/api/books`            | Yes  | `Api\BookController@index`     | OK (status filter bug note below)                  |
| POST      | `/api/books`            | Yes  | `Api\BookController@store`     | OK (publisher validation table mismatch note)      |
| GET       | `/api/books/{book}`     | Yes  | `Api\BookController@show`      | OK                                                 |
| PUT/PATCH | `/api/books/{book}`     | Yes  | `Api\BookController@update`    | OK (publisher validation table mismatch note)      |
| DELETE    | `/api/books/{book}`     | Yes  | `Api\BookController@destroy`   | OK                                                 |
| GET       | `/api/ratings`          | Yes  | `Api\RatingController@index`   | OK                                                 |
| POST      | `/api/ratings`          | Yes  | `Api\RatingController@store`   | OK                                                 |
| GET       | `/api/ratings/{rating}` | Yes  | `Api\RatingController@show`    | Belum implement                                    |
| PUT/PATCH | `/api/ratings/{rating}` | Yes  | `Api\RatingController@update`  | OK                                                 |
| DELETE    | `/api/ratings/{rating}` | Yes  | `Api\RatingController@destroy` | Belum implement                                    |
| GET       | `/api/authors`          | Yes  | `Api\AuthorController@index`   | OK                                                 |
| POST      | `/api/authors`          | Yes  | `Api\AuthorController@store`   | Belum implement                                    |
| GET       | `/api/authors/{author}` | Yes  | `Api\AuthorController@show`    | Belum implement                                    |
| PUT/PATCH | `/api/authors/{author}` | Yes  | `Api\AuthorController@update`  | Belum implement                                    |
| DELETE    | `/api/authors/{author}` | Yes  | `Api\AuthorController@destroy` | Belum implement                                    |

---

## 1) Auth Endpoints

### `POST /api/login`

Login API dan generate Sanctum token.

Request body:

```json
{
    "email": "user@example.com",
    "password": "secret"
}
```
