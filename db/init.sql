CREATE TABLE visitor_info (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              ip_address VARCHAR(45) NOT NULL,
                              user_agent VARCHAR(255) NOT NULL,
                              view_date DATETIME NOT NULL,
                              page_url VARCHAR(2083) NOT NULL,
                              views_count INT NOT NULL
);
ALTER TABLE visitor_info ADD INDEX ip_user_page_idx (ip_address(15), user_agent(100), page_url(100));
