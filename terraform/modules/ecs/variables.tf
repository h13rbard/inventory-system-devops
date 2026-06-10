variable "project_name" {}
variable "public_subnet_ids" { type = list(string) }
variable "ecs_security_group_id" {}
variable "target_group_arn" {}

variable "nginx_image" {}
variable "php_image" {}

variable "execution_role_arn" {}
variable "task_role_arn" {}

variable "tags" {
type = map(string)
}
