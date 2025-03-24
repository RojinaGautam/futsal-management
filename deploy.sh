#!/bin/bash

# Exit immediately if a command exits with a non-zero status
set -e

# FTP server details
FTP_HOST="ftp.dstudiosnepal.com"
FTP_USERNAME="dstudios"
FTP_PASSWORD="R1-m(D2WpnA9e7"
LOCAL_DIR="/futsal-management"
REMOTE_DIR="/public_html/rave-futsal.dstudiosnepal.com"

# Print debug information
echo "FTP_HOST: $FTP_HOST"
echo "FTP_USERNAME: $FTP_USERNAME"
echo "LOCAL_DIR: $LOCAL_DIR"
echo "REMOTE_DIR: $REMOTE_DIR"

# Use lftp to mirror the local directory to the remote directory, skipping SSL verification
lftp -d -c "
set ssl:verify-certificate no;
open -u $FTP_USERNAME,$FTP_PASSWORD $FTP_HOST;
mirror -R --verbose --only-newer --parallel=10 $LOCAL_DIR $REMOTE_DIR;
bye;
"