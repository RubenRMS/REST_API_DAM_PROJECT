<?php

class Database
{
    //DB connection
    protected $connection = null;
    public function __construct()
    {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
    	
            if ( mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    //select for regular SQL
    public function select_original($query = "" , $params = [])
    {
        try {
            
            $stmt = $this->executeStatement( $query , $params );
            
            if (!$stmt) {
                throw new Exception("Query failed: " . $query);
            }
            
            $result = $stmt->get_result();
            
            if (!$result) {                
                //throw new Exception("Failed to get result set: " . $query);
                //throw new Exception(mysqli_error($this->connection));
                throw new Exception (mysqli_error($this->connection));

            }                                                
            
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            
            
            $stmt->close();
            return $rows;
        } catch(Exception $e) {
            throw new Exception( $e->getMessage() );
        }
        return false;
    }

    public function select($query = "" , $params = [])
    {
        try {
            
            $stmt = $this->executeStatement( $query , $params );
           
            $result = $stmt->get_result();
            $table_name = $result->fetch_field_direct(0)->table;

                $rows = $result->fetch_all(MYSQLI_ASSOC);
                                    
            if($result->num_rows > 0){

                
                
                $response = array(
                    "status" => true,
                    "message" => "result set found",
                    $table_name => $rows
                );

            } else{
                $response=array("status" => false,
                "message" => "no rows returned");

                $response = array(
                    "status" => true,
                    "message" => "no rows returned",
                    $table_name => $rows
                );
            }
            
            
            $stmt->close();

            return $response;
        } catch(Exception $e) {
            throw new Exception( $e->getMessage() );
        }
        return false;
    }

    //used for eg: registering a user
    public function insert($query = "" , $params = []) {
        try {
            //only binds params without executing
            $stmt = $this->bind_params( $query , $params );
            
            if($stmt->execute()) {
                
                $rows=array("status" => true,
                 "message" => "Successfully inserted");

            }else{

                $error_message = mysqli_error($this->connection);
                
                $rows=array("status" => false,
                "message" => "Insert error: $error_message");

            }

            /*
            if (!$stmt) {
                throw new Exception("Query failed: " . $query);
            }
            
            $result = $stmt->get_result();
            //var_dump($result);//debug stuff

            if (!$result) {
                
                //throw new Exception("Failed to get result set: " . $query);
                //throw new Exception(mysqli_error($this->connection));
                throw new Exception (mysqli_error($this->connection));

            }
            
            $rows = $result->fetch_all(MYSQLI_ASSOC);            
            */
            $stmt->close();
            return $rows;
        } catch(Exception $e) {
            throw new Exception( $e->getMessage() );
        }
        return false;
    }

    public function insert_multi($queries = [] , $params = []) {
        try {
            //only binds params without executing
            $stmts = [];
            
            foreach($queries as $query) {
                $stmts[] = $this->bind_params($query, $params);
            }
            $this->connection->begin_transaction();
            
            foreach ($stmts as $stmt) {
                $stmt->execute();
            }
            

            $error = false;
            foreach ($stmts as $stmt) {
                if ($stmt->errno != 0) {
                    $error = true;
                    break;
                }
            }
    
            if ($error) {
                $error_message = $this->connection->error;
                $this->connection->rollback();
                $rows = array("status" => false, "message" => "Insert error: $error_message");
            } else {
                $this->connection->commit();
                $rows = array("status" => true, "message" => "Successfully inserted");
            }


            return $rows;
        } catch(Exception $e) {
            throw new Exception( $e->getMessage() );
        }

        return false;
    }

    //Login function
    public function session_login($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );                                   

            $result = $stmt->get_result();
            
            /*$vars=$stmt->fetch();
            $isad = $vars["is_admin"];
            var_dump($isad);*/
            
            //test things
            //only is_admin field
            //$row1 = mysqli_fetch_assoc($result);
            //echo $row1['is_admin'];                                                                        
        
            //move rows obtainment into if conditional
            /*$user_data=$result->fetch_all(MYSQLI_ASSOC);
            echo $user;
            var_dump($user);*/

            //code ok
            /*$rows1 = [];
            while($row = $result->fetch_row()) {
            $rows1[] = $row;

            var_dump($row);
            }*/
            
            //if rows are returned it means the user exists, so login
            if($result->num_rows > 0){

                //gets DB key name and their values
                $rows1 = array();
                while($row = $result->fetch_assoc()) {
                    $rows = array();
                    foreach($row as $key => $value) {
                        $rows[$key] = $value;
                    }
                    $rows1[] = $rows;
                }

                //dict with status, msg and user data dict obj
                $response = array(
                    "status" => true,
                    "message" => "Successfully Login!",
                    "user" => $rows1[0]
                );
                               
                $rows=$response;

                } else{
                $rows=array("status" => false,
                "message" => "Invalid Username or Password!");
            }
                
            
            $stmt->close();
            return $rows;

        } catch(Exception $e) {
            throw new Exception( $e->getMessage() );
        }
        return false;
    }


    private function executeStatement($query = "" , $params = [])
    {
        try {
            //echo"inside executestatement try\n";
            $stmt = $this->connection->prepare( $query );
            //echo"inside executestatement try2\n";
            if($stmt === false) {
                //echo"failed1\n";
                throw New Exception("Unable to do prepared statement: " . $query);
            }
            //echo"after if1\n";


            if( $params ) {

                //$stmt->bind_param($params[0], $params[1]);

                $cnt=count($params);

                for ($i=0; $i<$cnt; $i++) {
                    
                    $stmt->bind_param($params[$i]);

                }

            }            
            
            $stmt->execute();        
            return $stmt;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
    }

    private function bind_params($query = "" , $params = [])
    {
        try {
            //echo"inside executestatement try\n";
            $stmt = $this->connection->prepare( $query );
            //echo"inside executestatement try2\n";
            if($stmt === false) {
                //echo"failed1\n";
                throw New Exception("Unable to do prepared statement: " . $query);
            }
            //echo"after if1\n";


            if( $params ) {

                //$stmt->bind_param($params[0], $params[1]);

                $cnt=count($params);

                for ($i=0; $i<$cnt; $i++) {
                    
                    $stmt->bind_param($params[$i]);
                    //var_dump($params[$i]);

                }

            }            
                                
            return $stmt;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
    }

    public function return_list_objs($query = "" , $params = []) // TEST FUNCTION THING FOR LISTS
    {
        try {
            $stmt = $this->executeStatement( $query , $params );                                   

            $result = $stmt->get_result();                        
            
            //if rows are returned it means the user exists, so login
            if($result->num_rows > 0){                     

                //gets DB key name and their values
                $rows1 = array();
                while($row = $result->fetch_assoc()) {
                    $rows = array();
                    foreach($row as $key => $value) {
                        $rows[$key] = $value;
                    }
                    $rows1[] = $rows;
                    
                }                                 
                
                
                $response = array(
                    "status" => true,
                    "message" => "found rows:",
                    "rows" => $rows1
                );


                $rows=$response;

                } else{
                $rows=array("status" => false,
                "message" => "no data");
            }
                
            
            $stmt->close();
            return $rows;

        } catch(Exception $e) {
            throw new Exception( $e->getMessage() );
        }
        return false;
    }

}



