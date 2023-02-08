-- Must be run as "root", cannot be run as "db_mng_arven"
DELIMITER $$
CREATE TRIGGER generate_serial 
BEFORE INSERT ON Devices FOR EACH ROW 
BEGIN 
    declare serial_prefix char(5); 
    declare current_year int; 
    declare serial char(10); 
    declare id int; 
    set @serial_prefix = 'rx-ar'; 
    set @current_year = YEAR(CURDATE()); 
    set @serial = CONCAT(@serial_prefix,@current_year,'-'); 
    set @id = IFNULL((SELECT id FROM devices ORDER BY id DESC LIMIT 1),0) + 1; 
    set NEW.serial = CONCAT(@serial,LPAD(@id, 4, 0)); 
END$$
DELIMITER ;