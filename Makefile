# images for app
IMAGE_NAME=jimmyruan/docu-pet-api-image
TAG=latest


# Bring up all services
up:
	docker-compose up -d

# Stop all services
stop:
	docker-compose down

# build DocuPet app image
build-app:
	docker build --platform linux/amd64 -f docker/Dockerfile -t $(IMAGE_NAME):$(TAG) .

# push DocuPet app image to docker cloud
push-app:
	docker push $(IMAGE_NAME):$(TAG)
