#!/usr/bin/env bash
set -x
awslocal s3api head-bucket --bucket dev || awslocal s3 mb s3://dev
set +x
