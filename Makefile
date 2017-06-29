bash:
	docker-compose run --rm web bash

import:
	docker-compose run --rm web php App/Core/Console/execute.php Import
