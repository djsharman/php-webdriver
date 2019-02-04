#!/usr/bin/env bash
#docker exec --user www-data -it docker_php_test_1  /bin/bash
docker exec  -it docker_php_test_1  /bin/bash -c 'cd /workspace/examples/src; /bin/bash'
