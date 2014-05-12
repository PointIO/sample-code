$email = "";
$password = "";
$apiKey = "";
$sessionKey = APIDoc_auth($email, $password, $apiKey);

$storageTypes = APIDoc_list_storage_types($sessionKey)["RESULT"]["DATA"];
$aws = $storageTypes[0];

$params = APIDoc_list_storage_type_params($sessionKey, $aws[0]);
$paramValues = {};
foreach ($params as $p) {
    $paramValues[$p[4]] = "";
}

APIDoc_create_storage_site($sessionKey, $aws[0], "New Storage Site", default_flags(), $paramValues);