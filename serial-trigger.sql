-- Must be run as "root", cannot be run as "db_mng_arven"
DELIMITER $$
CREATE TRIGGER GenerateSerial 
BEFORE INSERT ON Devices FOR EACH ROW 
BEGIN 
    declare serial_prefix char(5); 
    declare current_year int; 
    declare serial char(10); 
    declare id int; 
    set @serial_prefix = 'RX-AR'; 
    set @current_year = YEAR(CURDATE()); 
    set @serial = CONCAT(@serial_prefix,@current_year,'-'); 
    set @id = IFNULL((SELECT DeviceID FROM Devices ORDER BY DeviceID DESC LIMIT 1),0) + 1; 
    set NEW.SerialNum = CONCAT(@serial,LPAD(@id, 4, 0)); 
END$$
DELIMITER ;