
locals {
  common_tags = {
    Project     = var.project_name
    Environment = var.environment
    ManagedBy   = "Terraform"
  }
}

data "aws_vpc" "production" {
filter {
name   = "tag:Name"
values = ["syslac-vpc-01-vpc"]
}
}

data "aws_subnets" "production" {
filter {
name   = "vpc-id"
values = [data.aws_vpc.production.id]
}
}

module "networking" {
  source = "./modules/networking"

  project_name = var.project_name
  vpc_cidr     = "10.0.0.0/16"

  tags = local.common_tags
}

module "alb" {
  source = "./modules/alb"

  project_name          = var.project_name
  public_subnet_ids     = data.aws_subnets.production.ids
  alb_security_group_id = "sg-0a2d8d916dc169aa7"
  vpc_id                = data.aws_vpc.production.id

  tags = local.common_tags
}

module "ecs" {
  source = "./modules/ecs"

  project_name          = var.project_name
  public_subnet_ids     = data.aws_subnets.production.ids
  ecs_security_group_id = "sg-0a2d8d916dc169aa7"
  target_group_arn      = module.alb.target_group_arn

  nginx_image = "159858924500.dkr.ecr.us-east-2.amazonaws.com/inventory-nginx:latest"
  php_image   = "159858924500.dkr.ecr.us-east-2.amazonaws.com/inventory-php:latest"

  execution_role_arn = var.execution_role_arn
  task_role_arn      = var.task_role_arn

  tags = local.common_tags
}
