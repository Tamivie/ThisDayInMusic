<?php

class Router {
    public static function route() {
        //find the request method and, from the uri, get the parameters involved
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        $path = parse_url( $uri );

        $pattern = sprintf("/^\/api\/v%s\/(?P<action>[^\/]+)(\/.*)?$/", \Webservice\ThisDayInMusic::VERSION );
        preg_match($pattern, $path['path'], $match);

        if( !count( $match ) )
            return \Webservice\ThisDayInMusic::output(null, array("code" => 1, "status" => "Invalid uri supplied to the webservice. Please check the documentation." ));

        $action = ucfirst( $match['action'] );
        $class = "\Webservice\ThisDayInMusic\\$action";
        if (!class_exists($class)) {
            return \Webservice\ThisDayInMusic::output(null, array("code" => 1, "status" => "Invalid action supplied to the webservice. Please check the documentation." ));
        }

        return $class;
    }
}
