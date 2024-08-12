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

?>
