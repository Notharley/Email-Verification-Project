#!/bin/bash

CRON_JOB="*/5 * * * * php $(pwd)/cron.php"
( crontab -l 2>/dev/null; echo "$CRON_JOB" ) | crontab -
echo "CRON job set to run every 5 minutes."
