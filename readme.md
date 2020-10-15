# <h1>Shop Delivery Project</h1>

### BAD TEAM

### API BASE URL: https://sups.kz/api/V1
### FIREBASE ACCOOUNT
email: ??? 
<br>
password: ???
<hr/>

<h3> Примечание: знак ' || ' значит ИЛИ </h3>

<hr>
<br> INVALID_FIELD = 1;
<br> UNAUTHORIZED = 2;
<br> SYSTEM_ERROR = 3;
<br> AUTH_ERROR = 4;
<br> ACCESS_DENIED = 5;
<br> UNIQUE_RESOURCE_CONFLICT = 6;
<br> RESOURCE_NOT_FOUND = 7;
<br> INVALID_ARGUMENT = 8;
<br> INVALID_TOKEN = 9;
<br> INVALID_RESET_CODE = 10;
<br> INVALID_PASSWORD_FORMAT = 11;
<br> INVALID_EMAIL_FORMAT = 12;
<br> INVALID_USERNAME_FORMAT = 13;
<br> EXPIRED_RESET_CODE = 14;
<br> EXPIRED_TOKEN = 15;
<br> EMPTY_CODE = 16;
<br> FILE_NOT_FOUND = 17;
<br> TOO_LARGE_FILE_SIZE = 18;
<br> REQUIRED_PARAMS_NOT_FOUND = 19;
<br> ALREADY_EXISTS = 20;
<br> ALREADY_REQUESTED = 21;
<br> NOT_ALLOWED = 22;
<br> PASSWORDS_MISMATCH = 23;
<br> FIELD_REQUIRED = 24;
<br> FORBIDDEN = 25;
<br> INVALID_CODE = 26;
<hr>

#### IMAGE BASE URL: https://sups.kz
##### Токен передается через HEADER: Authorization => Bearer Token
### Авторизация и регистрация:
#### URL: https://sups.kz/api/V1/login && https://sups.kz/api/V1/register
````
    Authorization : Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvdGVuc2VuZC5tZVwvYXBpXC92MVwvbG9naW4iLCJpYXQiOjE1Nzk2MjcxNjYsImV4cCI6MTU3OTYzMDc2NiwibmJmIjoxNTc5NjI3MTY2LCJqdGkiOiJPeUg5T3hZcVY2d0d6QllyIiwic3ViIjoxLCJwcnYiOiJlZTVhYzY5NDI5YzU1NmQ3NWRiZTdmZjRlNThiOTdjZDRmNzE0MmViIn0.Ykb0nBteVz3KBVmfxAcPHtgA9JPyfD3CArwSL4P3onA
````
```
    POST Request:
    {
    	"phone" : "123", required
    	"password" : "password", required
        "push_id" : "fcm_token", required
        "platform" : "IOS" // IOS или ANDROID в стринге 
    }
    
    Response
   {
       "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvc3Vwcy5relwvYXBpXC9WMVwvcmVnaXN0ZXIiLCJpYXQiOjE2MDI3OTA5NjksImV4cCI6MTYzODc5MDk2OSwibmJmIjoxNjAyNzkwOTY5LCJqdGkiOiI4MmdVcVBXUGJxZld5ZmdOIiwic3ViIjozLCJwcnYiOiIwYTY1NDRkZGVhNjVjNzNjMWRkZWQwY2JhMDlmYTE4NmMxYWVjYWU2In0.PidQuREHSiPt7N5_sRqRHnQzuVj8rvH8SIF-hfRBROk",
       "user": {
           "id": 3,
           "name": null,
           "surname": null,
           "email": null,
           "phone": "7077376258",
           "birth_date": null,
           "sex": null,
           "avatar_path": null,
           "notification": 1,
           "email_verified_at": null,
           "created_at": "2020-10-15T19:42:49.000000Z",
           "updated_at": "2020-10-15T19:42:49.000000Z",
           "deleted_at": null,
           "role_id": 2
       }
   }

```
### Категории:
#### URL: https://sups.kz/api/V1/categories
````
    Authorization : Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvdGVuc2VuZC5tZVwvYXBpXC92MVwvbG9naW4iLCJpYXQiOjE1Nzk2MjcxNjYsImV4cCI6MTU3OTYzMDc2NiwibmJmIjoxNTc5NjI3MTY2LCJqdGkiOiJPeUg5T3hZcVY2d0d6QllyIiwic3ViIjoxLCJwcnYiOiJlZTVhYzY5NDI5YzU1NmQ3NWRiZTdmZjRlNThiOTdjZDRmNzE0MmViIn0.Ykb0nBteVz3KBVmfxAcPHtgA9JPyfD3CArwSL4P3onA
````
```
    GET Request:
    {
    	
    }
    
    Response
   [
       {
           "id": 1,
           "name": "Пицца",
           "created_at": "2020-10-15T19:32:56.000000Z",
           "updated_at": "2020-10-15T19:32:56.000000Z",
           "deleted_at": null
       },
       {
           "id": 2,
           "name": "Бургер",
           "created_at": "2020-10-15T19:33:01.000000Z",
           "updated_at": "2020-10-15T19:33:01.000000Z",
           "deleted_at": null
       },
       {
           "id": 3,
           "name": "Плов",
           "created_at": "2020-10-15T19:33:06.000000Z",
           "updated_at": "2020-10-15T19:33:06.000000Z",
           "deleted_at": null
       }
   ]
```
### Продукты:
#### URL: https://sups.kz/api/V1/products
````
    Authorization : Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvdGVuc2VuZC5tZVwvYXBpXC92MVwvbG9naW4iLCJpYXQiOjE1Nzk2MjcxNjYsImV4cCI6MTU3OTYzMDc2NiwibmJmIjoxNTc5NjI3MTY2LCJqdGkiOiJPeUg5T3hZcVY2d0d6QllyIiwic3ViIjoxLCJwcnYiOiJlZTVhYzY5NDI5YzU1NmQ3NWRiZTdmZjRlNThiOTdjZDRmNzE0MmViIn0.Ykb0nBteVz3KBVmfxAcPHtgA9JPyfD3CArwSL4P3onA
````
```
    GET Request:
    {
    	category_id: numeric required if favorite false
        favorite: boolean 0 || 1 required if category_id null
    }
    
    Response
   [
       {
           "id": 1,
           "name": "Болоньезе",
           "description": "Очень вкусная пицца этого года",
           "price": 1700,
           "image_path": "images/products/160279043762652a04-da58-4162-9c36-719f2eb1a15cimg.jpg",
           "category_id": 1,
           "created_at": "2020-10-15T19:33:57.000000Z",
           "updated_at": "2020-10-15T19:33:57.000000Z",
           "favorite": 1
       }
   ]
```
### Добавить в избранное:
#### URL: https://sups.kz/api/V1/favorite
````
    Authorization : Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvdGVuc2VuZC5tZVwvYXBpXC92MVwvbG9naW4iLCJpYXQiOjE1Nzk2MjcxNjYsImV4cCI6MTU3OTYzMDc2NiwibmJmIjoxNTc5NjI3MTY2LCJqdGkiOiJPeUg5T3hZcVY2d0d6QllyIiwic3ViIjoxLCJwcnYiOiJlZTVhYzY5NDI5YzU1NmQ3NWRiZTdmZjRlNThiOTdjZDRmNzE0MmViIn0.Ykb0nBteVz3KBVmfxAcPHtgA9JPyfD3CArwSL4P3onA
````
```
    GET Request:
    {
    	product_id: numeric required 
    }
    
    Response
   {
       "favorite": true || false
   }
```



