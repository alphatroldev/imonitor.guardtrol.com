<?php



include_once("./company/inc/helpers.php");


function get($route, $path_to_include, $encoded = false){

  if( $_SERVER['REQUEST_METHOD'] == 'GET' ){ route($route, $path_to_include, $encoded); }  
}
function post($route, $path_to_include, $encoded = false){
  $route = $encoded? gd_decode($route): $route;
  if( $_SERVER['REQUEST_METHOD'] == 'POST' ){ route($route, $path_to_include); }  
}
function put($route, $path_to_include){
  if( $_SERVER['REQUEST_METHOD'] == 'PUT' ){ route($route, $path_to_include); }    
}
function patch($route, $path_to_include){
  if( $_SERVER['REQUEST_METHOD'] == 'PATCH' ){ route($route, $path_to_include); }    
}
function delete($route, $path_to_include){
  if( $_SERVER['REQUEST_METHOD'] == 'DELETE' ){ route($route, $path_to_include); }    
}
function any($route, $path_to_include){ route($route, $path_to_include); }

function route($route, $path_to_include, $encoded = false){
  $route = $encoded? gd_decode($route): $route; 
  if($route == "/404"){
    include_once("$path_to_include");
    exit();
  }
  
  
  
  
  //get route path from server  
  $request_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
  
  $request_url = rtrim($request_url, '/'); // trim whotespace
  $request_url = strtok($request_url, '?');//entoken the parmaters
  $route_parts = explode('/', $route);// get the path off route sent accross
  $request_url_parts = explode('/', $request_url);// seperate the server url requested
  $request_url_parts = array_values(array_filter($request_url_parts));
  $request_url_parts = array_values(array_filter($request_url_parts));

// var_dump($_SERVER['REQUEST_URI']);
  if(count($request_url_parts) == 0){
      include_once("index.php");
  }
  
  if(count($request_url_parts) == 1 && $request_url_parts[0] == 'support'){
    //   var_dump($request_url_parts);
      include_once("support/index.php");
  }
  
  if(count($request_url_parts) == 1 && $request_url_parts[0] == 'supervisor'){
    //   var_dump($request_url_parts);
      include_once("supervisor/index.php");
  }
  
  if(count($request_url_parts) == 1 && $request_url_parts[0] == 'client'){
    //   var_dump($request_url_parts);
      include_once("client/index.php");
  }
  
//   var_dump($request_url_parts);
  
  if($encoded && count($request_url_parts) > 0){
    $request_url = gd_decode($request_url_parts[0]); // decode the encode url index
    $request_url_parts = explode('/',$request_url); // turn the string to arrawy seperated by /
  }
  
  if( $_SERVER['REQUEST_METHOD'] != 'POST' ){
        array_shift($request_url_parts); //remove last indx too
  }
  array_shift($route_parts); //remove last index
  
  // var_dump($request_url_parts );
  // var_dump($route_parts);
  // $rev = array_reverse($request_url_parts);
  
  // $pop = array_pop($request_url_parts);
  
  // var_dump($route_parts);
  
  // $request_url_parts = array_filter($request_url_parts,);
  // var_dump("BBBBBBBBBBB");
  
  // exit(print_r($request_url_parts));  
  
  
  if(count($request_url_parts) == 0 ){
    // include_once("index.php");
    return;
  }

  if(count($route_parts) > 1 && ($request_url_parts[0] != $route_parts[0])){
    return;
  }

  if( count($route_parts) != count($request_url_parts) ){ 
    // header("Location: ".url_path('/'));
    return; 
  }

  $parameters = [];
  //removephishing character
  for( $__i__ = 0; $__i__ < count($route_parts); $__i__++ ){
    $route_part = $route_parts[$__i__];
    if( preg_match("/^[$]/", $route_part) ){
      $route_part = ltrim($route_part, '$');
      array_push($parameters, $request_url_parts[$__i__]);
      $$route_part=$request_url_parts[$__i__];
    }
    else if( $route_parts[$__i__] != '' && $route_parts[$__i__] !=  $request_url_parts[$__i__] ){
      // exit("Not matched: ". var_dump($route_parts));
      return;
    } 
  }
  include_once("$path_to_include");
  exit();
}
function out($text){echo htmlspecialchars($text);}
function set_csrf(){
  $csrf_token = bin2hex(random_bytes(25));
  $_SESSION['csrf'] = $csrf_token;
  echo '<input type="hidden" name="csrf" value="'.$csrf_token.'">';
}
function is_csrf_valid(){
  if( ! isset($_SESSION['csrf']) || ! isset($_POST['csrf'])){ return false; }
  if( $_SESSION['csrf'] != $_POST['csrf']){ return false; }
  return true;
}
// 

