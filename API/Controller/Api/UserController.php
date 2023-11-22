<?php

class UserController extends BaseController
{
    /** 
* "/user/list" Endpoint - Get list of users 
*/

    //$token = new Token();


    public function listAction()
    {
        
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new UserModel();
                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }
                $arrUsers = $userModel->getUsers($intLimit);
                $responseData = json_encode($arrUsers);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }


    public function loginAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            
            try {
                $userModel = new UserModel();
                    
                
                if (isset($arrQueryStringParams['password']) &&                            
                isset($arrQueryStringParams['email']) ) {//&& $arrQueryStringParams['limit'] //username, password, email
                   

                    $password = $arrQueryStringParams['password'];//pw
                    //var_dump($password); //var dump like echo

                    $email = $arrQueryStringParams['email'];//email
                    //var_dump($email);
                    
                }
            
                $arrUsers1 = $userModel->user_login($password, $email);//parameters

                $responseData = json_encode($arrUsers1);
                
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }


    }


    public function registerAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            
            try {
                $userModel = new UserModel();

                //$firstname,$lastname,$phone,$addr,$username,$email,$password

                if (isset($arrQueryStringParams['firstname']) &&
                 ($arrQueryStringParams['lastname'])&&
                 ($arrQueryStringParams['phone'])&&
                 ($arrQueryStringParams['addr'])&&
                 ($arrQueryStringParams['username'])&&
                 ($arrQueryStringParams['email'])&&
                 ($arrQueryStringParams['password'])                                            
                 ) {//&& $arrQueryStringParams['limit'] //username, password, email
                   
                    $firstname = $arrQueryStringParams['firstname'];
                    $lastname = $arrQueryStringParams['lastname'];
                    $phone = $arrQueryStringParams['phone'];
                    $addr = $arrQueryStringParams['addr'];
                    $username = $arrQueryStringParams['username'];
                    $email = $arrQueryStringParams['email'];
                    $password = $arrQueryStringParams['password'];                
                }
                
                $arrUsers1 = $userModel->user_register($firstname,$lastname,$phone,$addr,$username,$email,$password);//parameters
                
                                
                $responseData = json_encode($arrUsers1);
                                

                
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function newcarAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            
            try {
                $userModel = new UserModel();                

                if (isset($arrQueryStringParams['make']) &&
                 ($arrQueryStringParams['model'])&&
                 ($arrQueryStringParams['year'])&&
                 ($arrQueryStringParams['color'])&&
                 ($arrQueryStringParams['seats'])&&
                 ($arrQueryStringParams['plate'])&&
                 ($arrQueryStringParams['class_id'])&&                                            
                 ($arrQueryStringParams['usr_id'])&&
                 ($arrQueryStringParams['photo'])&&
                 ($arrQueryStringParams['pricexday'])
                 ) {
                   
                    $make = $arrQueryStringParams['make'];
                    $model = $arrQueryStringParams['model'];
                    $year = $arrQueryStringParams['year'];
                    $color = $arrQueryStringParams['color'];
                    $seats = $arrQueryStringParams['seats'];
                    $plate = $arrQueryStringParams['plate'];
                    $class_id = $arrQueryStringParams['class_id'];
                    $usr_id = $arrQueryStringParams['usr_id'];
                    $photo = $arrQueryStringParams['photo'];
                    $pricexday = $arrQueryStringParams['pricexday'];

                }
                
                $arrUsers1 = $userModel->car_insert($make,$model,$year,$color,$seats,$plate,$class_id,$usr_id,$photo,$pricexday);//parameters
                                                
                $responseData = json_encode($arrUsers1);
                                                
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function delcarAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            
            try {
                $userModel = new UserModel();                

                if (isset($arrQueryStringParams['car_id'])                                            
                 ) {
                   
                    $car_id = $arrQueryStringParams['car_id'];
                    
                }
                
                $arrUsers1 = $userModel->car_delete($car_id);//parameters
                                                
                $responseData = json_encode($arrUsers1);
                                                
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function editcarAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            
            try {
                $userModel = new UserModel();                
                if (isset($arrQueryStringParams['car_id'])&&
                ($arrQueryStringParams['make'])&&
                ($arrQueryStringParams['model'])&&
                ($arrQueryStringParams['year'])&&
                ($arrQueryStringParams['color'])&&
                ($arrQueryStringParams['seats'])&&
                ($arrQueryStringParams['plate'])&&
                ($arrQueryStringParams['class_id'])&&
                ($arrQueryStringParams['usr_id'])&&
                ($arrQueryStringParams['photo'])&&
                ($arrQueryStringParams['pricexday'])
                 ) {
                   
                    $car_id = $arrQueryStringParams['car_id'];
                    $make = $arrQueryStringParams['make'];
                    $model = $arrQueryStringParams['model'];
                    $year = $arrQueryStringParams['year'];
                    $color = $arrQueryStringParams['color'];
                    $seats = $arrQueryStringParams['seats'];
                    $plate = $arrQueryStringParams['plate'];                                      
                    $class_id = $arrQueryStringParams['class_id'];
                    $usr_id = $arrQueryStringParams['usr_id'];
                    $photo = $arrQueryStringParams['photo'];
                    $pricexday = $arrQueryStringParams['pricexday'];

                    
                }

                $arrUsers1 = $userModel->car_edit($car_id,$make,$model,$year,$color,$seats,$plate,$class_id,$usr_id,$photo,$pricexday);//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function newprofileAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            
            try {
                $userModel = new UserModel();
                if (isset($arrQueryStringParams['usr_id'])
                 ) {
                   
                    $id = $arrQueryStringParams['usr_id'];                    
                    
                }

                $arrUsers1 = $userModel->profile_new($id);//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function editprofileAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            
            try {
                $userModel = new UserModel();
                if (isset($arrQueryStringParams['bio'])&&
                ($arrQueryStringParams['location'])&&
                ($arrQueryStringParams['user_id'])
                 ) {
                   
                    $bio = $arrQueryStringParams['bio'];
                    $location = $arrQueryStringParams['location'];
                    $user_id = $arrQueryStringParams['user_id'];
                    
                }
                
                $arrUsers1 = $userModel->profile_edit($bio,$location,$user_id);//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function deleteprofileAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();
                if (isset($arrQueryStringParams['user_id'])
                 ) {

                    $user_id = $arrQueryStringParams['user_id'];

                }

                $arrUsers1 = $userModel->profile_delete($user_id);//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function carsbyownerAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();
                if (isset($arrQueryStringParams['owner_id'])
                 ) {

                    $owner_id = $arrQueryStringParams['owner_id'];

                }

                $arrUsers1 = $userModel->cars_by_owner($owner_id);//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function carsallAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();
                
                $arrUsers1 = $userModel->all_cars();//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function carpublishAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();
                if (isset($arrQueryStringParams['user_id'])&&
                ($arrQueryStringParams['car_id'])
                 ) {

                    $user_id = $arrQueryStringParams['user_id'];
                    $car_id = $arrQueryStringParams['car_id'];

                }

                $arrUsers1 = $userModel->car_publish($user_id,$car_id);//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function carunpublishAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();
                if (isset($arrQueryStringParams['car_id'])                
                 ) {
                    
                    $car_id = $arrQueryStringParams['car_id'];

                }

                $arrUsers1 = $userModel->car_unpublish($car_id);//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function carpublishallAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();
                if (isset($arrQueryStringParams['user_id'])
                 ) {

                    $user_id = $arrQueryStringParams['user_id'];

                }

                $arrUsers1 = $userModel->car_publish_all($user_id);//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function carunpublishallAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();
                if (isset($arrQueryStringParams['user_id'])                
                 ) {
                    
                    $user_id = $arrQueryStringParams['user_id'];

                }

                $arrUsers1 = $userModel->car_unpublish_all($user_id);//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function carclassallAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();
                
                $arrUsers1 = $userModel->all_car_classes();//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function carinfoAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();
                if (isset($arrQueryStringParams['car_id'])
                 ) {

                    $car_id = $arrQueryStringParams['car_id'];

                }

                $arrUsers1 = $userModel->car_info($car_id);//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function rentnewAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();
                if (isset($arrQueryStringParams['renter_id'])&&
                ($arrQueryStringParams['rentee_id'])&&
                ($arrQueryStringParams['start_date'])&&
                ($arrQueryStringParams['end_date'])&&
                ($arrQueryStringParams['total_cost'])&&
                ($arrQueryStringParams['car_id'])
                ) {

                    $renter_id = $arrQueryStringParams['renter_id'];
                    $rentee_id = $arrQueryStringParams['rentee_id'];
                    $start_date = $arrQueryStringParams['start_date'];
                    $end_date = $arrQueryStringParams['end_date'];
                    $total_cost = $arrQueryStringParams['total_cost'];
                    $car_id = $arrQueryStringParams['car_id'];

                }

                $arrUsers1 = $userModel->new_rent($renter_id,$rentee_id,$start_date,$end_date,$total_cost,$car_id);//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }


    public function renteditAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();
                if (isset($arrQueryStringParams['start_date'])&&
                ($arrQueryStringParams['end_date'])&&
                ($arrQueryStringParams['total_cost'])&&
                ($arrQueryStringParams['rental_id'])
                ) {

                    $start_date = $arrQueryStringParams['start_date'];
                    $end_date = $arrQueryStringParams['end_date'];
                    $total_cost = $arrQueryStringParams['total_cost'];
                    $rental_id = $arrQueryStringParams['rental_id'];

                }

                $arrUsers1 = $userModel->edit_rent($start_date,$end_date,$total_cost,$rental_id);//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function rentdelAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();
                if (isset($arrQueryStringParams['rental_id'])
                ) {
                    
                    $rental_id = $arrQueryStringParams['rental_id'];

                }

                $arrUsers1 = $userModel->delete_rent($rental_id);//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function rentalslistAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();                
                if (isset($arrQueryStringParams['filter'])
                ) {
                    
                    $filter = $arrQueryStringParams['filter'];
                    
                    if ((strcasecmp($filter, "my") == 0)&&
                    isset($arrQueryStringParams['user_id'])
                    ) {
                        // rented cars
                        $user_id = $arrQueryStringParams['user_id'];

                        $arrUsers1 = $userModel->my_rentals_list($user_id);//parameters

                    }
                    
                    if (strcasecmp($filter, "all") == 0) {
                        // customers
                        $arrUsers1 = $userModel->rentals_list();//parameters

                    }
                
                }

                $responseData = json_encode($arrUsers1);
                

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function rentalsactiveAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();

                if (isset($arrQueryStringParams['filter'])
                ) {
                    
                    $filter = $arrQueryStringParams['filter'];
                    
                    if ((strcasecmp($filter, "my") == 0)&&
                    isset($arrQueryStringParams['user_id'])
                    ) {
                        // rented cars
                        $user_id = $arrQueryStringParams['user_id'];

                        $arrUsers1 = $userModel->my_rentals_active($user_id);//parameters

                    }
                    
                    if (strcasecmp($filter, "all") == 0) {
                        // customers
                        $arrUsers1 = $userModel->rentals_active();//parameters

                    }
                
                }

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function rentalsinactiveAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();

                if (isset($arrQueryStringParams['filter'])
                ) {
                    
                    $filter = $arrQueryStringParams['filter'];
                    
                    if ((strcasecmp($filter, "my") == 0)&&
                    isset($arrQueryStringParams['user_id'])
                    ) {
                        // rented cars
                        $user_id = $arrQueryStringParams['user_id'];

                        $arrUsers1 = $userModel->my_rentals_inactive($user_id);//parameters

                    }
                    
                    if (strcasecmp($filter, "all") == 0) {
                        // customers
                        $arrUsers1 = $userModel->rentals_inactive();//parameters

                    }
                
                }

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function rentalsclosedAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();

                if (isset($arrQueryStringParams['filter'])
                ) {
                    
                    $filter = $arrQueryStringParams['filter'];
                    
                    if ((strcasecmp($filter, "my") == 0)&&
                    isset($arrQueryStringParams['user_id'])
                    ) {
                        // rented cars
                        $user_id = $arrQueryStringParams['user_id'];

                        $arrUsers1 = $userModel->my_rentals_closed($user_id);//parameters

                    }
                    
                    if (strcasecmp($filter, "all") == 0) {
                        // customers
                        $arrUsers1 = $userModel->rentals_closed();//parameters

                    }
                
                }

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }


    public function rentalsfilteredAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();
                if (isset($arrQueryStringParams['filter'])&&
                ($arrQueryStringParams['user_id'])
                ) {
                    
                    $filter = $arrQueryStringParams['filter'];
                    $user_id = $arrQueryStringParams['user_id'];

                    if (strcasecmp($filter, "rented") == 0) {
                        // rented cars
                        $arrUsers1 = $userModel->rentals_rented($user_id);//parameters

                    }

                    if (strcasecmp($filter, "rentees") == 0) {
                        // customers
                        $arrUsers1 = $userModel->rentals_rentees($user_id);//parameters

                    }
                    
                }

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function profilecarsAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();
                if (isset($arrQueryStringParams['user_id'])
                ) {
                    
                    $user_id = $arrQueryStringParams['user_id'];

                }

                $arrUsers1 = $userModel->profile_cars_available($user_id);//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function rentalreviewAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();
                if (isset($arrQueryStringParams['rental_id'])&&
                ($arrQueryStringParams['msg'])&&
                ($arrQueryStringParams['score'])
                ) {
                    
                    $rental_id = $arrQueryStringParams['rental_id'];
                    $msg = $arrQueryStringParams['msg'];
                    $score = $arrQueryStringParams['score'];
                    

                }

                $arrUsers1 = $userModel->rental_review($rental_id,$msg,$score);//parameters

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }

    public function carsfilteredAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {

            try {
                $userModel = new UserModel();
                if (isset($arrQueryStringParams['filter'])                
                ) {
                    
                    $filter = $arrQueryStringParams['filter'];                    

                    if ((strcasecmp($filter, "location") == 0) &&
                    (isset($arrQueryStringParams['loc']))
                    ){
                        $loc = $arrQueryStringParams['loc'];  

                        // rented cars
                        $arrUsers1 = $userModel->cars_location($loc);//parameters

                    }
                    /*
                    if (strcasecmp($filter, "rentees") == 0) {
                        // customers
                        $arrUsers1 = $userModel->rentals_rentees($user_id);//parameters

                    }*/
                    
                }

                $responseData = json_encode($arrUsers1);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }

    }
    

    

}

