# Koriym.TicketSan

This is minimum API / Web application for BEAR.Sunday.
 
  * RESTful API
  * Smart cache invalidation (not TTL based)
  * Web form validation
  * PHPunit test
  * [DB query object](https://github.com/ray-di/Ray.AuraSqlModule) injection

# Installation

    composer install
    composer setup

# Usage

## local

Post ticket
```
php bootstrap/api.php post 'app://self/ticket?title=title1'
```

```
201 Created
Location: /tickets/6bdb967b-616f-4c54-a65c-66599ba8be0e
content-type: application/hal+json
```

Get created ticket
```
php bootstrap/api.php get 'app://self/tickets/6bdb967b-616f-4c54-a65c-66599ba8be0e'
```

```
200 OK
ETag: 1055411361
Last-Modified: Sun, 18 Feb 2018 01:41:55 GMT
content-type: application/hal+json


{
    "id": "6bdb967b-616f-4c54-a65c-66599ba8be0e",
    "title": "title1",
    "description": "",
    "status": "",
    "assignee": "",
    "created": "2018-05-23 13:53:42",
    "updated": "2018-05-23 13:53:42",
    "_links": {
        "self": {
            "href": "/tickets/6bdb967b-616f-4c54-a65c-66599ba8be0e"
        }
    }
}
```

Get all tickets
```
php bootstrap/api.php get 'app://self/tickets'
```

## REST API

```
composer run serve-api --timeout=0
```

Serve API document for human
```
http://127.0.0.1:8081/rels/ 
```

CURIes
 
```
curl -i -X GET http://127.0.0.1:8081/
```

POST ticket
```
curl -i -X POST http://127.0.0.1:8081/ticket -d 'title=title1'
```

```
HTTP/1.1 201 Created
Host: 127.0.0.1:8081
Date: Sun, 18 Feb 2018 03:32:42 +0100
Connection: close
X-Powered-By: PHP/7.1.10
Location: /tickets/18
content-type: application/hal+json
```

GET ticket
```
curl -i -X GET http://127.0.0.1:8081/tickets/18
```

```
HTTP/1.1 200 OK
Host: 127.0.0.1:8081
Date: Sun, 18 Feb 2018 03:33:26 +0100
Connection: close
X-Powered-By: PHP/7.1.10
ETag: 2637290215
Last-Modified: Sun, 18 Feb 2018 02:33:26 GMT
content-type: application/hal+json

{
    "ticket": {
        "id": "18",
        "title": "title1",
        "description": "",
        "status": "",
        "assignee": "",
        "created": "2018-02-18 03:32:42",
        "updated": "2018-02-18 03:32:42"
    },
    "_links": {
        "self": {
            "href": "/tickets/18"
        }
    }
}
```

## HTML

```
composer run serve --timeout=0
```

Request [http://127.0.0.1:8080/](http://127.0.0.1:8080/)

### QA

    composer test       // phpunit
    composer coverage   // test coverate
    composer cs         // lint
    composer cs-fix     // lint fix
    vendor/bin/phptest  // test + cs
    vendor/bin/phpbuild // phptest + doc + qa
