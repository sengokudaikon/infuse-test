# INFUSEMedia Test

This is a technical test task for INFUSEMedia. Here are the steps to install and use it.

## Installation

Clone the project to your local machine:
https://github.com/sengokudaikon/infuse-test.git

## Setup

Use Makefile commands:
- to set the project up 
```make start```
- to launch the project
```make up```
- to stop the project
```make stop```
- to restart the project
```make restart```
- to reset the project 
```make reset```

## Usage

The project is available on http://localhost:8080
The access points are 
- http://localhost:8080/index.html 
- http://localhost:8080/index.php 
- http://localhost:8080/index2.html

Monitoring is available on http://localhost:3000

If the dashboards aren't available, you can set them up in the GUI by adding the following data sources:
- Prometheus: http://prometheus:9090

and then importing the dashboards from the following files:
- /grafana/dashboards/nginx.json
- /grafana/dashboards/mysql.json

Sometimes, the nginx exporter can malfunction. In this case, you can restart it with the following command:
```make restart-nginx-exporter```

The quality control is done with the following tools:
- PHP_CodeSniffer ```make phpcs```
- Psalm ```make psalm```
