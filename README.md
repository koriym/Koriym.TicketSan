# Koriym.TicketSan

# Installation

    composer install
    composer setup

# Usage

## local

Post ticket
```
composer api post 'app://self/ticket?title=title1'
```

```
201 Created
Location: /tickets/16
content-type: application/hal+json
```

Get created ticket
```
composer api get 'app://self/tickets/16'
```

```
200 OK
ETag: 1055411361
Last-Modified: Sun, 18 Feb 2018 01:41:55 GMT
content-type: application/hal+json

{
    "ticket": {
        "id": "16",
        "title": "title1",
        "description": "",
        "status": "",
        "assignee": "",
        "created": "2018-02-18 02:39:44",
        "updated": "2018-02-18 02:39:44"
    },
    "_links": {
        "self": {
            "href": "/tickets/16"
        }
    }
}
```

Get all tickets
```
composer api get 'app://self/tickets'
```

## Web-API

```
COMPOSER_PROCESS_TIMEOUT=0 composer serve-api
```

Serve API document for human
```
http://localhost:8081/rels/ 
```

CURIes
 
```
curl -i -X GET http://localhost:8081/
```

POST ticket
```
curl -i -X POST http://localhost:8081/ticket -d 'title=title1'
```

```
HTTP/1.1 201 Created
Host: localhost:8081
Date: Sun, 18 Feb 2018 03:32:42 +0100
Connection: close
X-Powered-By: PHP/7.1.10
Location: /tickets/18
content-type: application/hal+json
```

GET ticket
```
curl -i -X GET http://localhost:8081/tickets/18
```

```
HTTP/1.1 200 OK
Host: localhost:8081
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

## HTML App

    COMPOSER_PROCESS_TIMEOUT=0 composer serve

Request [http://localhost:8080/](http://localhost:8080/)

### QA

    composer test       // phpunit
    composer coverage   // test coverate
    composer cs         // lint
    composer cs-fix     // lint fix
    vendor/bin/phptest  // test + cs
    vendor/bin/phpbuild // phptest + doc + qa
