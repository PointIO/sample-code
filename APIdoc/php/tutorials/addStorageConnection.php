$email = "";
$password = "";
$apiKey = "";
$sessionKey = auth($email, $password, $apiKey);

$storageTypes = list_storage_types($sessionKey)["RESULT"]["DATA"];
$aws = $storageTypes[0];

$params = list_storage_type_params($sessionKey, $aws[0]);
$paramValues = {};
foreach ($params as $p) {
    $paramValues[$p[4]] = "";
}

create_storage_site($sessionKey, $aws[0], "New Storage Site", default_flags(), $paramValues);