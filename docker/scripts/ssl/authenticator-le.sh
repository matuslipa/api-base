#!/bin/bash

PERMISSION_GROUP=simplo
PROJECT_DIR="/var/dev-docker"

echo $CERTBOT_VALIDATION > $PROJECT_DIR/apps/le.html
chgrp $PERMISSION_GROUP $PROJECT_DIR/apps/le.html
