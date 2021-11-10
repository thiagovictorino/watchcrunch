## Instructions
To run this repository smoothly you should have the [Laravel sail](https://laravel.com/docs/8.x/sail) locally configured.

With the repo cloned, You have to ***copy the .env.example to .env*** 

Then, you should run

```shell
$ sail up
```
Wait for the containers installations.

```shell
$ sail composer install
```
Now all servers are up and running. 

To run all tests you should run

```shell
$  sail php ./vendor/bin/pest
```

### Using only the docker exec

If you don't want to install sail locally, you can use docker instead.

```shell
$  docker-compose up -d
```

Wait for the containers installations.

```shell
$ docker exec watchcrunch_laravel.test_1 composer install
```
Now all servers are up and running.

To run all tests you should run

```shell
$  docker exec watchcrunch_laravel.test_1 php ./vendor/bin/pest
```
