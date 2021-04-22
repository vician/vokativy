test:
	docker run -it node -v ${PWD}/src:/src node /src/index.html
