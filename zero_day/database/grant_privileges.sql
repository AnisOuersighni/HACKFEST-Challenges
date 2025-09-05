-- grant_privileges.sql
GRANT ALL PRIVILEGES ON *.* TO 'root'@'172.28.0.3' IDENTIFIED BY 'DedSec_Revenge!!!' WITH GRANT OPTION;
FLUSH PRIVILEGES;
GRANT ALL PRIVILEGES ON *.* TO 'root'@'172.28.0.4' IDENTIFIED BY 'DedSec_Revenge!!!' WITH GRANT OPTION;
FLUSH PRIVILEGES;

-- Grant privileges to 'jerbi' user to connect from localhost
GRANT ALL PRIVILEGES ON zero_day.* TO 'jerbi'@'localhost' IDENTIFIED BY 'zer0_day_p@Sswo0rd'WITH GRANT OPTION;

-- Grant privileges to 'jerbi' user to connect from db container (172.28.0.3)
GRANT ALL PRIVILEGES ON zero_day.* TO 'jerbi'@'172.28.0.3' IDENTIFIED BY 'zer0_day_p@Sswo0rd'WITH GRANT OPTION;
FLUSH PRIVILEGES;
-- Grant privileges to 'jerbi' user to connect from web container (172.28.0.4)
GRANT ALL PRIVILEGES ON zero_day.* TO 'jerbi'@'172.28.0.4' IDENTIFIED BY 'zer0_day_p@Sswo0rd'WITH GRANT OPTION;
FLUSH PRIVILEGES;

-- Ensure privileges are applied immediately
FLUSH PRIVILEGES;
-- Create the 'users' table
CREATE TABLE IF NOT EXISTS login_table (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL
);


-- Create the 'secrets' table
CREATE TABLE IF NOT EXISTS secrets (
  operation VARCHAR(255) PRIMARY KEY,
  status VARCHAR(255) NOT NULL
);
CREATE TABLE logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    log_message TEXT
);



-- Insert sample users
INSERT INTO login_table (username, password) VALUES ('admin', 'admin');
INSERT INTO login_table (username, password) VALUES ('DedSec', 'Notimportant :)');
INSERT INTO login_table (username, password) VALUES ('M.Holloway ', 'Notimportant either :)');
INSERT INTO login_table (username, password) VALUES ('A.Pearce  ', 'dude are you  still looking here ? ');


-- Insert sample secrets
INSERT INTO secrets (operation, status) VALUES 
('zero_day', 'Our Agent Marcus Holloway exfiltrated successfully the NexusCorp_archive_cookie=5e884898da28047151d0e56f8dc6292773603d0d9f89e1a91fce2281e9b04fc0  the next step is /secret_archive.php;)'),
('social_justice', 'Our Agent Aiden Pearce exfiltrated successfully super importants records of politicians that were later SOLD in black market for 3Billions $ ;)');


INSERT INTO logs (username, log_message) VALUES
('admin', 'Login attempt successful from IP 192.168.1.10. User credentials validated.'),
('admin', 'Access to surveillance feed successful. Video stream from camera 4 initiated.'),
('admin', 'User attempted to access restricted mission data. Access denied.'),
('admin', 'Security alert: Unauthorized access attempt from IP 192.168.1.50 detected.'),
('admin', 'Mission data retrieved: NexusCorp archive data. Encryption keys requested.');