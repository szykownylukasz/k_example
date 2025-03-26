# Example Symfony API platform Project

A small programming sample using the Symfony API platform

## Requirements

- **Docker**: Make sure you have the latest version of Docker installed.
- **Docker Compose**: Make sure you have the latest version of Docker Compose installed.

## Installation

1. **Cloning a repository:**

   ```bash
   git clone https://github.com/szykownylukasz/k_example.git
   cd k_example
   ```
2. **Running the docker:**
   docker-compose -p symfony_api up --build -d

3. **Api visibility:**
   By default the API is available on port 81. Port can be changed in docker-compose.yml file. When docker is started, composer packages are built, so when you first start it, you need to wait a moment for them to be built and once that happens, the server should work properly.
   It shouldn't take more than 2 minutes.
   
4. **API documentation is available at the link:**
	http://localhost:81/api/docs
	
	When using the API, you use the API, use content-type: application/ld+json or application/json. For response you can set also application/ld+json or application/json.