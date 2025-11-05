-- SQL Script to add userid column to bid table
-- Run this in phpMyAdmin if the bid table doesn't have a userid column

-- Add userid column to bid table
ALTER TABLE `bid` 
ADD COLUMN `userid` INT(11) NULL AFTER `bid_price`,
ADD KEY `userid` (`userid`);

-- If you want to add a foreign key constraint (optional)
-- Uncomment the following line if you have a users table with userid as primary key
-- ALTER TABLE `bid` 
-- ADD CONSTRAINT `fk_bid_userid` 
-- FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) 
-- ON DELETE CASCADE ON UPDATE CASCADE;

-- Verify the changes
DESC bid;
