# Syslac Cloud Platform

## Overview

Syslac Cloud Platform is a cloud modernization project focused on migrating and operating a legacy inventory management application using AWS managed services, containerization, Infrastructure as Code, and CI/CD practices.

The project demonstrates how a traditional PHP application can be transformed into a cloud-native deployment running on Amazon ECS Fargate.

---

## Project Goals

* Containerize a legacy CodeIgniter application.
* Deploy workloads using AWS ECS Fargate.
* Store container images in Amazon ECR.
* Provision infrastructure using Terraform.
* Implement CI/CD pipelines with GitHub Actions.
* Operate the platform using production-oriented deployment practices.

---

## Architecture

```text
Internet
    │
    ▼
Application Load Balancer
    │
    ▼
AWS ECS Fargate
    │
 ┌──┴──┐
 │     │
 ▼     ▼
NGINX  PHP-FPM
    │
    ▼
Amazon RDS MySQL
```
![](https://github.com/h13rbard/inventory-system-devops/blob/develop/screenshots/architecture-diagram.png)


### Components

* Application Load Balancer
* ECS Fargate Cluster
* NGINX Container
* PHP-FPM Container
* Amazon RDS MySQL
* Amazon ECR
* GitHub Actions
* Terraform

---

## Infrastructure

### Cloud Platform

AWS

### Services Used

* Amazon ECS Fargate
* Amazon ECR
* Amazon RDS MySQL
* Application Load Balancer
* IAM
* CloudWatch

### Infrastructure as Code

Infrastructure provisioning is managed using Terraform.

Current Terraform modules include:

* ECS Cluster
* ECS Services
* Load Balancers
* Networking
* IAM Resources

---

## Containerization

The application is split into two containers:

### NGINX

Responsible for:

* HTTP traffic
* Reverse proxy
* Static content delivery

### PHP-FPM

Responsible for:

* Business logic
* CodeIgniter execution
* Database connectivity

Container images are stored in Amazon ECR.

---

## CI/CD

GitHub Actions automates application deployments.

### Current Pipeline

```text
Git Push
   │
   ▼
GitHub Actions
   │
   ▼
Docker Build
   │
   ▼
Amazon ECR
   │
   ▼
Amazon ECS Deployment
```

### Features

* Automated image builds
* Automated image publishing
* ECS service deployment
* Deployment validation

---

## Security

Implemented security controls include:

* HTTPS with TLS certificates
* IAM roles
* ECS execution roles
* Private container registry

Planned improvements:

* AWS Secrets Manager
* Secret rotation
* Enhanced IAM policies

---

## Lessons Learned

Key lessons learned during the project:

### Build, Break, Rebuild

Understanding cloud systems required repeatedly building, troubleshooting, and redesigning infrastructure components.

### Infrastructure as Code Matters

Terraform significantly improved repeatability and environment consistency.

### Containerization Simplifies Deployments

Docker reduced deployment complexity and improved portability.

### CI/CD Reduces Operational Risk

Automated deployments reduce manual errors and improve consistency.

---

## Future Improvements

Planned roadmap:

### CI/CD

* ECS Task Definition Revisioning
* Immutable Image Deployments
* Automated Rollbacks

### Security

* AWS Secrets Manager
* Secret Rotation

### Infrastructure

* Full Terraform Coverage
* Multi-Environment Deployments

### Scalability

* Auto Scaling Policies
* Blue/Green Deployments

---

## Technologies

* AWS ECS Fargate
* Amazon ECR
* Amazon RDS
* Terraform
* Docker
* GitHub Actions
* NGINX
* PHP-FPM
* CodeIgniter

---

## Author

Juan Gerardo Gutierrez Muñoz

Cloud & DevOps Engineering Portfolio Project
