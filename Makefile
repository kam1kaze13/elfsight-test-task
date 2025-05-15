build-dev:
	cp ./.env.example ./.env
	cp ./backend/src/.env.example ./backend/src/.env
	cp ./backend/src/.env.test.example ./backend/src/.env.test
	docker compose build

run:
	docker compose up

stop:
	docker compose down
