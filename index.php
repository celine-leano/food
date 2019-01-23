<?php
// turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// require autoload
require_once('vendor/autoload.php');

// create an instance of the Base class
$f3 = Base::instance();

// turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

// define a default route
$f3->route('GET /', function($f3) {
    /*$view = new View();
    echo $view->render('views/home.html');*/
    // save variables
    $f3->set('username', 'jshmo');
    $f3->set('password', sha1('Password01'));
    $f3->set('title', 'Working with Templates');

    // load template
    $template = new Template();
    echo $template->render('views/info.html');

    // alternate syntax
    //echo Template::instance()->render('views/info.html');
});

// define a breakfast route
$f3->route('GET /breakfast', function() {
    $view = new View();
    echo $view->render('views/breakfast.html');
});

// define a lunch route
$f3->route('GET /lunch', function() {
    $view = new View();
    echo $view->render('views/lunch.html');
});

// define a pancake route
$f3->route('GET /breakfast/pancakes', function() {
    $view = new View();
    echo $view->render('views/pancakes.html');
});

// define a dinner route
$f3->route('GET /dinner', function() {
    $view = new View();
    echo $view->render('views/dinner.html');
});

// define a baked salmon route
$f3->route('GET /dinner/baked-salmon', function() {
    $view = new View();
    echo $view->render('views/baked-salmon.html');
});

// define a steak fajita route
$f3->route('GET /dinner/steak-fajitas', function() {
    $view = new View();
    echo $view->render('views/steak-fajitas.html');
});

// define a route with a parameter
$f3->route('GET /@food', function($f3, $params) {
    echo "<h3>I like " . $params['food'] . "</h3>";
});

// define a route with multiple parameters
$f3->route('GET /@meal/@food', function($f3, $params) {
    print_r($params);

    $validMeals = ['breakfast', 'lunch', 'dinner'];
    $meal = $params['meal'];

    // check validity
    if (!in_array($meal, $validMeals)) {
        echo "<h3>Sorry, we don't serve $meal</h3>";
    } else {

        switch ($meal) {
            case 'breakfast':
                $time = " in the morning";
                break;
            case 'lunch':
                $time = " in noon";
                break;
            case 'dinner':
                $time = " in the evening";
        }
        echo "<h3>I like " . $params['food'] . " $time</h3>";
    }
});

// define a route for dessert that takes a param
$f3->route('GET /dessert/@param', function($f3, $params) {
    $dessert = $params['param'];

    if ($dessert == 'pie') {
        $view = new View();
        echo $view->render('views/pie.html');
    } elseif ($dessert == 'cake' || $dessert == 'cookies' || $dessert == 'brownies') {
        echo "I like $dessert";
    } else {
        $f3->error(404);
    }
});

// define a route to display order form
$f3->route('GET /order', function() {
    $view = new View();
    echo $view->render('views/form1.html');
});

// define a route to process orders
$f3->route('POST /order-process', function($f3) {
    print_r($_POST);

    $food = $_POST['food'];
    echo "You ordered $food";

    if ($food == 'pancakes') {
        //reroute to pizza page
        $f3->reroute('/breakfast/pancakes');
    } else {
        //reroute to the parameter page
        $f3->reroute("$food");
    }
});

// run fat free
$f3->run();