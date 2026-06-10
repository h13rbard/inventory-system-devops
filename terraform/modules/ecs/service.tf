resource "aws_ecs_service" "this" {
name            = "${var.project_name}-service"
cluster         = aws_ecs_cluster.this.id
task_definition = aws_ecs_task_definition.app.arn
desired_count   = 1
launch_type     = "FARGATE"

network_configuration {
subnets         = var.public_subnet_ids
security_groups = [var.ecs_security_group_id]
assign_public_ip = true
}

load_balancer {
target_group_arn = var.target_group_arn
container_name   = "nginx"
container_port   = 80
}

depends_on = [aws_ecs_cluster.this]
}
