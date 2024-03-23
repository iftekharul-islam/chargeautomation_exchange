<?php
"CREATE TABLE IF NOT EXISTS http_logs (
id int NOT NULL AUTO_INCREMENT,
partner_id int NULL,
partner_user_id int NULL,
request_url LONGTEXT NOT NULL,
request_data LONGTEXT NOT NULL,
response_data LONGTEXT NOT NULL,
response_code VARCHAR(10) NOT NULL,
created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
?>