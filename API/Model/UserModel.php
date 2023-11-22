<?php

require_once PROJECT_ROOT_PATH . "/Model/Database.php";
class UserModel extends Database
{
    public function getUsers($limit)
    {
        //test query
        return $this->select("SELECT * FROM users ORDER BY user_id ASC LIMIT ?", ["i", $limit]);
    }

    public function user_login($pw,$mail)
    {        

        //forms query to send to DB
        $query = "SELECT * FROM users
        JOIN profile ON users.profile_id=profile.profile_id
        WHERE email = '{$mail}' AND password = '{$pw}'";

        //$query = "SELECT * From users WHERE email = '{$mail}' AND password = '{$pw}'";
        
        //adds params to an array
        $params = array($pw,$mail);

        //sends params + query 
        return $this->session_login($query, $params);
       
    }

    public function user_register_old($firstname,$lastname,$phone,$addr,$username,$email,$password)
    {                                        

        //forms query to send to DB
        $query = "INSERT INTO users (first_name, last_name, phone_number, address, username, email, password) 
        VALUES ('{$firstname}', '{$lastname}', '{$phone}', '{$addr}', '{$username}', '{$email}', '{$password}')";
    
        //adds params to an array
        $params = array($firstname,$lastname,$phone,$addr,$username,$email,$password);
        
        //sends params + query 
        return $this->insert($query, $params);

    }


    public function user_register($firstname,$lastname,$phone,$addr,$username,$email,$password)
    {                                        
        

        $queries = array(
            "INSERT INTO profile (bio, location) VALUES ('', '')",
            "INSERT INTO users (first_name, last_name, phone_number, address, username, email, password, profile_id) 
            VALUES ('{$firstname}', '{$lastname}', '{$phone}', '{$addr}', '{$username}', '{$email}', '{$password}', LAST_INSERT_ID() )"
        );        

        //adds params to an array
        $params = array($firstname,$lastname,$phone,$addr,$username,$email,$password);
        
        //sends params + query
        return $this->insert_multi($queries, $params);

    }

    public function car_insert($make,$model,$year,$color,$seats,$plate,$class_id,$usr_id,$photo,$pricexday)
    {                                        

        //forms query to send to DB
        $query = "INSERT INTO cars (make, model, year, color,seats,plate, class_id, owner_id, photo_url, pricexday) 
        VALUES ('{$make}', '{$model}', '{$year}', '{$color}', '{$seats}', '{$plate}', '{$class_id}','{$usr_id}','{$photo}','{$pricexday}')";
    
        //adds params to an array
        $params = array($make,$model,$year,$color,$seats,$plate,$class_id,$usr_id,$photo,$pricexday);
        
        //sends params + query 
        return $this->insert($query, $params);

    }

    public function car_delete($car_id)
    {                                        

        //forms query to send to DB
        $query = "DELETE FROM cars WHERE car_id ='{$car_id}' ";
    
        //adds params to an array
        $params = array($car_id);
        
        //sends params + query 
        return $this->insert($query, $params);

    }

    public function car_edit($car_id,$make,$model,$year,$color,$seats,$plate,$class_id,$usr_id,$photo,$pricexday)
    {                                        

        //forms query to send to DB        
        $query = "UPDATE cars
        SET make = '{$make}', 
            model = '{$model}', 
            year = '{$year}', 
            color = '{$color}', 
            seats = '{$seats}', 
            plate = '{$plate}', 
            class_id = '{$class_id}', 
            owner_id = '{$usr_id}', 
            photo_url = '{$photo}',
            pricexday = '{$pricexday}'
        WHERE car_id = '{$car_id}'";

        
        //$query = "UPDATE cars SET plate = '{$new_plate}' WHERE plate = '{$plate}'";
    
        //adds params to an array
        $params = array($car_id,$make,$model,$year,$color,$seats,$plate,$class_id,$usr_id,$photo,$pricexday);
        
        //sends params + query
        return $this->insert($query, $params);

    }


    public function profile_new($id)
    {                                        
        
        $queries = array(
            "INSERT INTO profile (bio, location) VALUES ('', '')",
            "UPDATE users SET profile_id = LAST_INSERT_ID() WHERE user_id = '{$id}'"
        );

        //adds params to an array
        $params = array($id);
        
        //sends params + query
        return $this->insert_multi($queries, $params);

    }

    public function profile_edit($bio, $location,$user_id)
    {                                        
        
        //forms query to send to DB        
        $query = "UPDATE profile 
        SET bio = COALESCE(NULLIF('{$bio}', ''), bio), 
        location = COALESCE(NULLIF('{$location}', ''), location)
        WHERE profile_id IN (SELECT profile_id FROM users WHERE user_id = '{$user_id}')";
    
        //adds params to an array
        $params = array($bio,$location,$user_id);
        
        //sends params + query
        return $this->insert($query, $params);

    }

    public function profile_delete($user_id)
    {                                        
        
        //forms query to send to DB        
        $query = "DELETE FROM profile WHERE profile_id IN (SELECT profile_id FROM users WHERE user_id = '{$user_id}')";
    
        //adds params to an array
        $params = array($user_id);
        
        //sends params + query
        return $this->insert($query, $params);

    }

    public function cars_by_owner($owner_id) //unfinished
    {
        
        //forms query to send to DB
        $query = "SELECT * from cars JOIN car_classes ON cars.class_id = car_classes.class_id where owner_id = '{$owner_id}'";
        //$query = "SELECT * from cars where owner_id = '{$owner_id}'";

        //adds params to an array
        $params = array($owner_id);

        //sends params + query
        return $this->select($query, $params);

    }

    public function all_cars()
    {
        
        //forms query to send to DB
        $query = "SELECT * from cars JOIN car_classes ON cars.class_id = car_classes.class_id";

        //adds params to an array
        $params = array();

        //sends params + query
        return $this->select($query, $params);

    }

    public function car_publish($user_id,$car_id) //unfinished
    {
        
        //forms query to send to DB
        $query = "INSERT INTO profile_cars (profile_id, car_id)
                VALUES (
                (SELECT profile_id FROM users WHERE user_id = '{$user_id}'),
                '{$car_id}'
                );";

        //adds params to an array
        $params = array($user_id,$car_id);

        //sends params + query
        return $this->insert($query, $params);

    }

    public function car_unpublish($car_id) //unfinished
    {
        
        //forms query to send to DB
        $query = "DELETE from profile_cars where car_id = '{$car_id}'";

        //adds params to an array
        $params = array($car_id);

        //sends params + query
        return $this->insert($query, $params);

    }

    public function car_publish_all($user_id) //unfinished
    {
        
        //forms query to send to DB
        $query = "INSERT IGNORE INTO profile_cars (profile_id, car_id)
                    SELECT 
                    (SELECT profile_id FROM users WHERE user_id = '{$user_id}'),
                    car_id
                    FROM cars 
                    WHERE owner_id = '{$user_id}'";

        //adds params to an array
        $params = array($user_id);

        //sends params + query
        return $this->insert($query, $params);

    }

    public function car_unpublish_all($user_id) //unfinished
    {
        
        //forms query to send to DB
        $query = "DELETE FROM profile_cars WHERE profile_id in (SELECT profile_id FROM users WHERE user_id = '{$user_id}')";

        //adds params to an array
        $params = array($user_id);

        //sends params + query
        return $this->insert($query, $params);

    }
    

    public function all_car_classes()
    {
        
        //forms query to send to DB
        $query = "SELECT * from car_classes";

        //adds params to an array
        $params = array();

        //sends params + query
        return $this->select($query, $params);

    }

    public function car_info($car_id) //unfinished
    {
        
        //forms query to send to DB
        $query = "SELECT *
                    FROM cars
                    JOIN car_classes ON cars.class_id = car_classes.class_id
                    WHERE cars.car_id = '{$car_id}'";

        //adds params to an array
        $params = array($car_id);

        //sends params + query
        return $this->select($query, $params);

    }

    public function new_rent($renter_id,$rentee_id,$start_date,$end_date,$total_cost,$car_id) //unfinished
    {

        //forms query to send to DB
        $query = "INSERT INTO rentals
                (renter, rentee, start_date, end_date, total_cost, car_id)
                VALUES
                ((SELECT profile_id from users where user_id='{$renter_id}')
                ,(SELECT profile_id from users where user_id='{$rentee_id}')
                ,'{$start_date}', '{$end_date}', '{$total_cost}', '{$car_id}')";

        //DATE FORMAT YYYY-MM-DD

        //adds params to an array
        $params = array($renter_id,$rentee_id,$start_date,$end_date,$total_cost,$car_id);

        //sends params + query
        return $this->insert($query, $params);

    }

    public function edit_rent($start_date,$end_date,$total_cost,$rental_id) //unfinished
    {

        //forms query to send to DB
        $query = "UPDATE rentals SET
                start_date = '{$start_date}',
                end_date = '{$end_date}',
                total_cost = '{$total_cost}'
                WHERE rental_id = '{$rental_id}'";

        //DATE FORMAT YYYY-MM-DD

        //adds params to an array
        $params = array($start_date,$end_date,$total_cost,$rental_id);

        //sends params + query
        return $this->insert($query, $params);

    }

    public function delete_rent($rental_id) //unfinished
    {

        //forms query to send to DB
        $query = "DELETE from rentals where rental_id = '{$rental_id}'";

        //DATE FORMAT YYYY-MM-DD

        //adds params to an array
        $params = array($rental_id);

        //sends params + query
        return $this->insert($query, $params);

    }


    public function rentals_list()
    {
        
        //forms query to send to DB
        $query = "SELECT * from rentals
        JOIN cars ON rentals.car_id=cars.car_id
        JOIN car_classes ON cars.class_id=car_classes.class_id";

        //adds params to an array
        $params = array();

        //sends params + query
        return $this->select($query, $params);

    }

    public function my_rentals_list($user_id)
    {
        
        //forms query to send to DB
        $query = "SELECT * from rentals
        JOIN cars ON rentals.car_id=cars.car_id
        JOIN car_classes ON cars.class_id=car_classes.class_id 
        WHERE rentee=(select profile_id from users where user_id='{$user_id}')";

        //adds params to an array
        $params = array($user_id);

        //sends params + query
        return $this->select($query, $params);

    }

    public function rentals_active()
    {
        
        //forms query to send to DB
        $query = "SELECT * FROM rentals
        JOIN cars ON rentals.car_id=cars.car_id
        JOIN car_classes ON cars.class_id=car_classes.class_id
        WHERE CURDATE() BETWEEN start_date AND end_date";

        //adds params to an array
        $params = array();

        //sends params + query
        return $this->select($query, $params);

    }

    public function my_rentals_active($user_id)
    {
        
        //forms query to send to DB
        $query = "SELECT * FROM rentals
        JOIN cars ON rentals.car_id=cars.car_id
        JOIN car_classes ON cars.class_id=car_classes.class_id
        WHERE CURDATE() BETWEEN start_date AND end_date
        AND 
        rentee=(select profile_id from users where user_id='{$user_id}')";

        //adds params to an array
        $params = array($user_id);

        //sends params + query
        return $this->select($query, $params);

    }

    public function rentals_inactive()
    {
        
        //forms query to send to DB
        $query = "SELECT * FROM rentals 
        JOIN cars ON rentals.car_id=cars.car_id
        JOIN car_classes ON cars.class_id=car_classes.class_id
        WHERE CURDATE() < start_date";

        //adds params to an array
        $params = array();

        //sends params + query
        return $this->select($query, $params);

    }

    public function my_rentals_inactive($user_id)
    {
        
        //forms query to send to DB
        $query = "SELECT * FROM rentals 
        JOIN cars ON rentals.car_id=cars.car_id
        JOIN car_classes ON cars.class_id=car_classes.class_id
        WHERE CURDATE() < start_date 
        AND 
        rentee=(select profile_id from users where user_id='{$user_id}')";

        //adds params to an array
        $params = array($user_id);

        //sends params + query
        return $this->select($query, $params);

    }

    public function rentals_closed()
    {
        
        //forms query to send to DB
        $query = "SELECT * FROM rentals 
        JOIN cars ON rentals.car_id=cars.car_id
        JOIN car_classes ON cars.class_id=car_classes.class_id
        WHERE CURDATE() > end_date";

        //adds params to an array
        $params = array();

        //sends params + query
        return $this->select($query, $params);

    }

    public function my_rentals_closed($user_id)
    {
        
        //forms query to send to DB
        $query = "SELECT * FROM rentals 
        JOIN cars ON rentals.car_id=cars.car_id
        JOIN car_classes ON cars.class_id=car_classes.class_id
        WHERE CURDATE() > end_date
        AND
        rentee=(select profile_id from users where user_id='{$user_id}')";

        //adds params to an array
        $params = array($user_id);

        //sends params + query
        return $this->select($query, $params);

    }

    public function rentals_rented($user_id) //unfinished
    {

        //forms query to send to DB

        $query = "SELECT * from rentals
        JOIN cars ON rentals.car_id=cars.car_id
        JOIN car_classes ON cars.class_id=car_classes.class_id
        WHERE renter 
        in (select profile_id from users where user_id= '{$user_id}') 
        AND end_date < CURDATE() AND score IS NOT NULL";
          

        /*$query = "SELECT * from rentals
        WHERE renter 
        in (select profile_id from users where user_id= '{$user_id}') 
        AND end_date < CURDATE()";*/

        //adds params to an array
        $params = array($user_id);

        //sends params + query
        return $this->select($query, $params);

    }

    public function rentals_rentees($user_id) //unfinished
    {

        //forms query to send to DB
        $query = "SELECT * from rentals 
        JOIN cars ON rentals.car_id=cars.car_id
        JOIN car_classes ON cars.class_id=car_classes.class_id
        where rentee 
        in (select profile_id from users where user_id= '{$user_id}')
         AND end_date < CURDATE()";

        //adds params to an array
        $params = array($user_id);

        //sends params + query
        return $this->select($query, $params);

    }

    public function profile_cars_available($user_id) //unfinished
    {

        //forms query to send to DB
        $query = "SELECT * from cars 
        JOIN profile_cars 
        ON cars.car_id=profile_cars.car_id 
        AND profile_cars.profile_id = (select profile_id from users where user_id= '{$user_id}' )";

        //adds params to an array
        $params = array($user_id);

        //sends params + query
        return $this->select($query, $params);

    }

    public function rental_review($rental_id,$msg,$score) //unfinished
    {

        //forms query to send to DB
        $query = "UPDATE rentals SET message = '{$msg}', score = '{$score}' WHERE rental_id = '{$rental_id}'";

        //adds params to an array
        $params = array($rental_id,$msg,$score);

        //sends params + query
        return $this->insert($query, $params);

    }
    

    public function cars_location($loc) //unfinished
    {

        //forms query to send to DB
        $query = "SELECT cars.*
        FROM cars cars
        JOIN users u ON cars.owner_id = u.user_id
        WHERE u.profile_id IN (
          SELECT p.profile_id
          FROM profile p
          WHERE p.location = '{$loc}')";

        

        //adds params to an array
        $params = array($loc);

        //sends params + query
        return $this->select($query, $params);

    }
    





}
