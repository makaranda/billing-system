<?php
if (!function_exists('isChecked')) {
    function isChecked($route, $permissionType, $routesPermissionsMap, $bulkUsersArray) {
        // Check if there are any permissions in the map for the given route and permission type
        if (isset($routesPermissionsMap[$route . '_' . $permissionType])) {
            // Loop through the permissions to see if any match the bulk users
            foreach ($routesPermissionsMap[$route . '_' . $permissionType] as $permission) {
                if (in_array($permission->user_id, $bulkUsersArray)) {
                    return true;
                }
            }
        }
        return false;
    }
}

if (!function_exists('getUserIP')) {
    function getUserIP() {
        // Check if user is behind a proxy
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // IP from shared internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // IP passed from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            // Regular IP address
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}

?>
