resource "aws_ecs_task_definition" "app" {
family                   = "${var.project_name}-task"
requires_compatibilities = ["FARGATE"]
network_mode             = "awsvpc"
cpu                      = 512
memory                   = 1024
execution_role_arn      = var.execution_role_arn
task_role_arn           = var.task_role_arn

container_definitions = jsonencode([
{
name  = "nginx"
image = var.nginx_image

logConfiguration = {
  logDriver = "awslogs"
  options = {
    awslogs-group         = "/ecs/syslac-lab"
    awslogs-region        = "us-east-2"
    awslogs-stream-prefix = "ecs"
  }
}
  portMappings = [{
    containerPort = 80
    hostPort      = 80
  }]
},
{
  name  = "php"
  image = var.php_image

	environment = [
{
name  = "DB_HOST"
value = "inventory-db.c1y8a4yo0p0l.us-east-2.rds.amazonaws.com"
},
{
name  = "DB_PORT"
value = "3306"
},
{
name  = "DB_DATABASE"
value = "inventario"
},
{
name  = "DB_USERNAME"
value = "admin"
},
{
name  = "DB_PASSWORD"
value = "sistemas26#"
}
]

logConfiguration = {
  logDriver = "awslogs"
  options = {
    awslogs-group         = "/ecs/syslac-lab"
    awslogs-region        = "us-east-2"
    awslogs-stream-prefix = "ecs"
  }
}

  portMappings = [{
    containerPort = 9000
    hostPort      = 9000
  }]
}

])
}
