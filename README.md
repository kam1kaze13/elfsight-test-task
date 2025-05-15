# Elfsight Test Task

This is a test task for Elfsight

## Description

This app allows the user to leave a review for one of the Ricky and Morty episodes, with each review receiving an automatic rating calculation using sentiment analysis, as well as getting an average sentiment rating for each episode, including the last 3 reviews.

## Installation

There are two options:

```bash
make build-dev
make run
```
or manually copy .env.example to .env in the project root, and /backend/src/.env.example to /backend/src/.env and /backend/src/.env.test.example to /backend/src/.env.test and then

```bash
docker compose up --build
```

After the project has successfully started, you need to run the following commands to populate the database with episodes

```bash
docker ps
docker exec -it {BACKEND_CONTAINER_ID} bash
php bin/console add:episodes:db
```
To stop the project

```bash
make stop
```
or
```bash
docker compose down
```

## Usage

Two methods are available:

### Submit a review

```
POST http://localhost/api/review/submit/{id}
```
#### Parameters:
text - User review

#### Response
```json
{
    "message": "Review submitted successfully"
}
```

### Get episode's summary

```
GET http://localhost/api/episode/summary/{id}
```

#### Response
```json
{
    "name": "Pilot",
    "airDate": "December 2, 2013",
    "avgSentimentScore": 0.583,
    "reviews": [
        "It's the best episode"
    ]
}
```
