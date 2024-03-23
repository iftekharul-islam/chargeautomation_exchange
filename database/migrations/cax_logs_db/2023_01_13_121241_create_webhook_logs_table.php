<?php
"CREATE TABLE IF NOT EXISTS webhook_logs (
id int NOT NULL AUTO_INCREMENT,
partner_id int NULL,
partner_user_id int NULL,
pms_name VARCHAR(75) NULL,
url LONGTEXT NOT NULL,
pms_response LONGTEXT NOT NULL,
cax_response LONGTEXT NOT NULL,
status TINYINT(1) NOT NULL,
partner_user_response LONGTEXT NULL,
attempt TINYINT(1) NOT NULL,
created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
?>