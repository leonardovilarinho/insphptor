cs:
	phpcs --standard=PSR2 source/

fix:
	phpcbf --standard=PSR2 source/

fix-tests:
	phpcbf --standard=PSR2 tests/

all:
	make fix
	make fix-tests
	git add .
	git commit -m "${m}"

push:
	git push

test:
	phpunit