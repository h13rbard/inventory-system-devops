terraform {
  backend "s3" {
    bucket         = "syslac-terraform-state-2026"
    key            = "prod/terraform.tfstate"
    region         = "us-east-2"
    dynamodb_table = "terraform-locks"
    encrypt        = true
  }
}

