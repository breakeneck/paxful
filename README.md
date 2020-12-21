To start application, please, run 

```
docker-compose up
```

and then run database migrations executing **init.sh** script


To proceed with api payments, you have to execute 
```
POST http://localhost:8000/api/login
{"username": "Jack", "password" : "Jack"}
```

and then just
```
POST http://localhost:8000/api/pay
{"dest_user_id": 5, "amount": 50, "access_token":""}
```

with access_token, received from previous request
