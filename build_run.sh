docker build . -t sensor-test
docker container run sensor-test:latest $1
