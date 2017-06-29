access-web-container:
	docker exec -it cid10_api_web bash

run-command:
	docker exec -it cid10_api_web php App/Core/Console/execute.php bash
