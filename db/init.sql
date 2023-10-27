CREATE USER 'exporter'@'localhost' IDENTIFIED BY 'XXXXXXXX';
GRANT PROCESS, REPLICATION CLIENT ON *.* TO 'exporter'@'localhost';
GRANT SELECT ON performance_schema.* TO 'exporter'@'localhost';
CREATE TABLE visitor_info
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    ip_address  VARCHAR(45)   NOT NULL,
    user_agent  VARCHAR(255)  NOT NULL,
    view_date   DATETIME      NOT NULL,
    page_url    VARCHAR(2083) NOT NULL,
    views_count INT           NOT NULL
);
INSERT INTO visitor_info (ip_address, user_agent, view_date, page_url, views_count)
VALUES ('192.168.0.1', 'Mozilla/5.0', NOW(), 'http://example.com', 1);
