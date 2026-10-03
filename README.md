# WEBDEV3 – Week 8: Form Handling and Validation

**Project:** forms-lab-w8 (Course management)
**Framework:** Laravel (PHP 8.2+), SQLite
**Student:** _Your Name_  •  **Section:** _Your Section_  •  **Date:** October 2026

## Description

A small Laravel app for managing courses. It demonstrates safe, user-friendly
forms: CSRF protection, old-input redisplay, validation with Form Request
classes, per-field error messages, and secure image uploads.

## Setup

```bash
composer install
cp .env.example .env          # Windows: copy .env.example .env
php artisan key:generate
```

Make sure `.env` has `DB_CONNECTION=sqlite`, then:

```bash
php artisan storage:link
php artisan migrate:fresh --seed
php artisan serve
```

Open http://127.0.0.1:8000/courses

> `migrate:fresh` drops all tables. Use it only on a lab/dev database.

## Features

| Feature | Where |
| --- | --- |
| Create and edit forms sharing one partial | `resources/views/courses/_form.blade.php` |
| CSRF protection and method spoofing (`@csrf`, `@method`) | `create`, `edit` and `show` views |
| Old input redisplay, including select and checkbox state | `_form`, `forms/input`, `forms/select` |
| Form Requests (store/update), `ignore()` on update | `app/Http/Requests/StoreCourseRequest.php`, `UpdateCourseRequest.php` |
| Custom messages, attribute names, `prepareForValidation()` | `StoreCourseRequest.php` |
| Custom validation rule (3–7 capital letters + 1 digit) | `app/Rules/ValidCourseCode.php` |
| Reusable Blade components with per-field errors | `resources/views/components/forms/` |
| Error summary and flash status message | `_form.blade.php`, `components/layout.blade.php` |
| Image upload on the public disk with random filename | `CourseController@store` / `@update` |
| Old image deleted on replace and on delete | `CourseController@update` / `@destroy` |
| Delete as POST + `@method('DELETE')` with confirm dialog | `courses/show.blade.php` |
| POST–Redirect–GET on every write | `CourseController` |

## Validation rules (courses)

| Field | Rules |
| --- | --- |
| code | required, string, max:20, ValidCourseCode, unique (ignores own record on update) |
| title | required, string, max:255 |
| description | nullable, string, max:1000 |
| units | required, integer, between:1,6 |
| instructor_id | nullable, exists:instructors,id |
| is_active | boolean |
| image | nullable, image, max:2048 (KB) |

## Routes

| Verb | URL | Method | Name |
| --- | --- | --- | --- |
| GET | /courses | index | courses.index |
| GET | /courses/create | create | courses.create |
| POST | /courses | store | courses.store |
| GET | /courses/{course} | show | courses.show |
| GET | /courses/{course}/edit | edit | courses.edit |
| PUT | /courses/{course} | update | courses.update |
| DELETE | /courses/{course} | destroy | courses.destroy |

## Project structure (files written this week)

```
app/Http/Controllers/CourseController.php
app/Http/Requests/StoreCourseRequest.php
app/Http/Requests/UpdateCourseRequest.php
app/Models/Course.php, Instructor.php
app/Rules/ValidCourseCode.php
database/migrations/..._create_instructors_table.php
database/migrations/..._create_courses_table.php
database/factories/CourseFactory.php, InstructorFactory.php
database/seeders/DatabaseSeeder.php
resources/views/components/layout.blade.php
resources/views/components/forms/input.blade.php, select.blade.php
resources/views/courses/_form, create, edit, index, show .blade.php
routes/web.php
```

## Test checklist

- [x] Empty submit shows errors next to the fields and an error summary; typed values are kept
- [x] Duplicate course code shows the custom message "That course code is already taken."
- [x] Invalid code (e.g. `abc`) becomes `ABC` and is rejected by the custom rule
- [x] Course created with an image; flash message "Course created." is shown
- [x] Stored file has a random name in `storage/app/public/courses`
- [ ] Edit without changing the code saves (ignore works)
- [ ] Replacing the image removes the old file
- [ ] Unticked "Active" stays unticked after a validation error
- [ ] Delete asks for confirmation and removes the record and its image

_Tick the remaining boxes after you test them._

## Security notes

- Server-side validation of every field; only `validated()` data is saved.
- The client's filename is never used; Laravel generates a random name.
- Uploads are stored in `storage/app/public`, not directly in `public/`.
- Only the relative image path is saved in the database.
- Every form includes `@csrf`; removing it returns **419 Page Expired**.
