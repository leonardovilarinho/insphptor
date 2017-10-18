cs:
	phpcs --standard=PSR2 source/

fix:
	phpcbf --standard=PSR2 source/
	phpcbf --standard=PSR2 tests/

all:
	git add .
	git commit -m "${m}"

push:
	git push

test:
	phpunit