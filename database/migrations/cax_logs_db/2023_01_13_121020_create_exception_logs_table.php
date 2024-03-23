<?php
"CREATE TABLE IF NOT EXISTS exception_logs (
id int NOT NULL AUTO_INCREMENT,
partner_id int NULL,
partner_user_id int NULL,
exception_code VARCHAR(10) NOT NULL,
exception_message LONGTEXT NOT NULL,
stack_trace LONGTEXT NULL,
request_url LONGTEXT NULL,
extra_data LONGTEXT NULL,
created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
?>