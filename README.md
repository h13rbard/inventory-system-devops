# Syslac Cloud Platform

## 1. Overview

Syslac Cloud Platform is a personal DevOps and Cloud Engineering project designed to modernize and operate a legacy inventory management system using AWS managed services, Infrastructure as Code, observability, and CI/CD practices.

The objective of the project is not only to host an application, but to build a production-like environment following modern cloud-native operational practices.

### Main Goals

* Containerize a legacy PHP application.
* Deploy workloads on AWS ECS Fargate.
* Implement centralized monitoring and logging.
* Automate deployments using GitHub Actions.
* Manage infrastructure through Terraform.
* Build operational visibility with dashboards, alerts, and uptime monitoring.
* Learn production-grade cloud operations through hands-on implementation.

---

## 2. Architecture

### High-Level Architecture

Internet
│
▼
Application Load Balancer (ALB)
│
▼
AWS ECS Fargate
│
├── NGINX Container
└── PHP-FPM Container
│
▼
Amazon RDS MySQL

Observability Stack

Prometheus
Node Exporter
cAdvisor
Loki
Alertmanager
Grafana
Uptime Kuma

CI/CD

GitHub
│
▼
GitHub Actions
│
▼
Amazon ECR
│
▼
Amazon ECS

---

## 3. Infrastructure

### Cloud Provider

* AWS

### Core Services

* Amazon ECS Fargate
* Amazon ECR
* Amazon RDS MySQL
* Application Load Balancer
* IAM
* CloudWatch

### Infrastructure as Code

Infrastructure provisioning and management is performed using Terraform.

Terraform resources include:

* ECS Clusters
* ECS Services
* Task Definitions
* Load Balancers
* Networking components
* IAM configurations

### Domains

Production Services:

* syscla.jgerardogm.lat
* grafana.jgerardogm.lat
* status.jgerardogm.lat

TLS certificates are managed automatically through Traefik and Let's Encrypt.

---

## 4. Monitoring

The platform includes a complete monitoring stack.

### Prometheus

Responsible for collecting metrics from:

* ECS services
* Node Exporter
* cAdvisor
* Infrastructure services

### Grafana

Used to visualize:

* ECS metrics
* Container metrics
* Resource consumption
* CloudWatch metrics
* Service health

### Uptime Kuma

Used for external monitoring of:

* Production application
* Grafana
* Public endpoints

### Alertmanager

Provides alert routing and notification management.

Implemented alerts include:

* Service availability
* Infrastructure health
* Monitoring stack failures

---

## 5. Logging

Centralized logging is implemented using:

### Loki

Stores application and infrastructure logs.

### CloudWatch Logs

Receives ECS container logs using awslogs drivers.

### Grafana Log Exploration

Logs can be queried and correlated with metrics directly from Grafana.

Benefits:

* Faster troubleshooting
* Centralized visibility
* Historical log retention

---

## 6. CI/CD

Continuous delivery is implemented using GitHub Actions.

### Deployment Workflow

Developer Push
↓
GitHub Actions
↓
Build Docker Images
↓
Push Images to Amazon ECR
↓
Update ECS Service
↓
Deploy New Revision

### Current Features

* Automated container builds
* ECR image publishing
* ECS deployments
* Deployment validation
* Service stability verification

### Ongoing Improvements

* Immutable SHA image tagging
* ECS task revision deployments
* Automated rollback strategy

---

## 7. Security

Several security practices have been implemented:

### HTTPS Everywhere

* Traefik reverse proxy
* Let's Encrypt certificates
* Automatic certificate renewal

### IAM

* Role-based access control
* ECS execution roles
* Least-privilege approach

### Future Security Enhancements

* AWS Secrets Manager integration
* Secret rotation
* Enhanced IAM segmentation

---

## 8. Lessons Learned

This project was built following a learn-by-building approach.

Key lessons:

### Infrastructure Failures Are Valuable

Many components required multiple rebuilds and redesigns before reaching stable production operation.

### Observability Is Essential

Monitoring transformed infrastructure management from reactive troubleshooting to proactive operations.

### Automation Reduces Risk

CI/CD pipelines significantly reduce deployment complexity and human error.

### Documentation Matters

Building systems is only part of the job. Being able to explain architecture, decisions, and tradeoffs is equally important.

### Production-Like Experience

This project provided practical experience with:

* AWS
* Terraform
* Docker
* ECS
* Grafana
* Prometheus
* Loki
* Alertmanager
* GitHub Actions

---

## 9. Future Improvements

Planned roadmap:

### Security

* AWS Secrets Manager
* Secret rotation
* Improved IAM policies

### CI/CD

* ECS Task Definition revisioning
* Immutable image deployments
* Automated rollback

### Infrastructure

* Full Terraform coverage
* Multi-environment support
* Disaster recovery automation

### Observability

* Advanced dashboards
* SLO/SLA reporting
* Long-term metrics retention

### Platform Expansion

* Odoo deployment environment
* Multi-cloud experiments
* Additional business services

---

## Author

Juan Gerardo

Cloud / DevOps Engineering Portfolio Project

Built with AWS, Terraform, Docker, Grafana, Prometheus, Loki, Alertmanager and GitHub Actions.
