# Another DDD with Hexagonal architecture implementation using PHP and Symfony

This is a simplified version and for demo purposes, there are numerous aspects to improve this implementation, feel free 
to send your PR.

## Build app
This app can be run using Docker, to build the image run the next command:

    docker build -t app .

## Run tests
To create an abstraction with the host, you can run the test over the previous built docker image:

    docker run --rm -it app composer test

## Run the app
To run the app using docker, you must build the image using the previous build step, after that you can
run the next command to run the app on port 8000.

    docker run --rm -it -p 8000:8000 app

Using another terminal or your browser you can check the search endpoint:

    curl http://localhost:8000/beers?query=pizza

And the detail endpoint:

    curl http://localhost:8000/beers/13

If you have je `jq` tool installed in your system, you can get a pretty version this these commands:

    curl http://localhost:8000/beers?query=nachos | jq -r '.'
    curl http://localhost:8000/beers/12 | jq -r '.'
