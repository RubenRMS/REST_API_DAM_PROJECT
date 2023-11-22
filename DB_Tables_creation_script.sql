-- Creates all the necessary tables
-- ======================
--   UNRELATED TABLES
-- ======================

-- Create the car_classes table
CREATE TABLE car_classes (
  class_id INT AUTO_INCREMENT PRIMARY KEY,
  class_name VARCHAR(50) NOT NULL, -- ADD UNIQUE TODO
  /*eng_type ENUM('combustion', 'electric','hybrid') NOT NULL, -- edit so its only 1 tupple
  fuel ENUM('gas-oil', 'petrol')*/

  engine ENUM('petrol','gas-oil','electric','petrol/hybrid','gas-oil/hybrid') NOT NULL
   
);

-- banking information
CREATE TABLE Banking (
  -- acc_holder_name VARCHAR(100) NOT NULL -- maybe
  bank_id INT AUTO_INCREMENT PRIMARY KEY,
  IBAN VARCHAR(50) NOT NULL,
  credit_card VARCHAR(50) NOT NULL,
  bank_name VARCHAR(100) NOT NULL UNIQUE 
);

-- ======================
--   RELATED TABLES
-- ======================


-- Create the profile table
CREATE TABLE profile (
    profile_id INT AUTO_INCREMENT PRIMARY KEY,

  
    bio VARCHAR(255),
    location VARCHAR(255)

);


/*

The "profile_cars" table has two foreign keys, one referencing the "profile" table and the other referencing the "cars" table. You can insert a new row into the "profile_cars" table to add a car to a profile's "cars_av" list.

To retrieve a profile's list of cars, you can use a JOIN query between the "profile" and "profile_cars" tables, like this:

SELECT c.*
FROM cars c
JOIN profile_cars pc ON pc.car_id = c.car_id
WHERE pc.profile_id = <profile_id>;
This query returns all the cars associated with the given "profile_id".

*/
-- in app wallet
CREATE TABLE wallet (
  wallet_id INT AUTO_INCREMENT PRIMARY KEY,
  balance DECIMAL(10,2) NOT NULL,
  currency CHAR(10) NOT NULL,-- USD EUR etc
  bank_id INT,
  FOREIGN KEY (bank_id) REFERENCES Banking(bank_id)
);

-- user registry
CREATE TABLE users (
  -- id 
  user_id INT AUTO_INCREMENT PRIMARY KEY,

  -- irl data
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  phone_number VARCHAR(20) NOT NULL,
  address VARCHAR(100) NOT NULL,
  -- site wise data
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(254) NOT NULL, -- replace varchar with email -- DONE
  password char(32) NOT NULL, -- replace varchar with md5 -- DONE

  -- is_admin ENUM('yes', 'no') NOT NULL DEFAULT 'no', -- create enum for category for admin and user types -- DONE
  is_admin TINYINT(1) DEFAULT 0,

  -- wallet info
  wallet_id INT,
  FOREIGN KEY (wallet_id) REFERENCES wallet(wallet_id) ON DELETE SET NULL,

  -- create user profile table
  profile_id INT,
  FOREIGN KEY (profile_id) REFERENCES profile(profile_id) ON DELETE SET NULL

  -- use LAST_INSERT_ID()

);

-- Create the cars table
CREATE TABLE cars (
  car_id INT AUTO_INCREMENT PRIMARY KEY,
  make VARCHAR(50) NOT NULL,
  model VARCHAR(50) NOT NULL,
  year INT NOT NULL,
  color VARCHAR(20) NOT NULL,
  seats INT NOT NULL,-- ADD SEATS ammnt -- TODO
  plate VARCHAR(50) NOT NULL UNIQUE, -- ADD PLATE UNIQUE
  class_id INT NOT NULL,
  FOREIGN KEY (class_id) REFERENCES car_classes(class_id),
  /* car owner ID is so car remains in DB with reference to user but
  users are still able to delete their profile */
  owner_id INT NOT NULL, 
  FOREIGN KEY (owner_id) REFERENCES users(user_id),

  photo_url VARCHAR(800) NOT NULL,

  pricexday DECIMAL(10, 2) NOT NULL



);

CREATE TABLE rentals (
    rental_id INT AUTO_INCREMENT PRIMARY KEY,
    -- car owner
    renter INT NOT NULL,
    FOREIGN KEY (renter) REFERENCES profile(profile_id),

    -- car renter
    rentee INT NOT NULL,
    FOREIGN KEY (rentee) REFERENCES profile(profile_id),

    score INT DEFAULT NULL,-- 0 to 10
    message TEXT,

    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_cost DECIMAL(10, 2) NOT NULL,

    car_id INT NOT NULL,
    FOREIGN KEY (car_id) REFERENCES cars(car_id)

);

-- available cars up to rent from each user
CREATE TABLE profile_cars (
    profile_id INT NOT NULL,
    car_id INT NOT NULL UNIQUE,
    -- profile_vis TINYINT(1) DEFAULT 0,
    FOREIGN KEY (profile_id) REFERENCES profile(profile_id),
    FOREIGN KEY (car_id) REFERENCES cars(car_id)
);





