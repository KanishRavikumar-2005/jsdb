<?php 
//Enter the file location you've saved it in

require_once("jsdb/jsdb-conn.php");
$jsdb = new Jsdb();

//Add row
$jsdb->add_row("databases/people", "{`name`:`John`, `age`:`27`, `job`:`Comedian`, `email`:`john.doe@example.com`, `workType`:`private`}");
// This will add a row in the jsdb database called people.jsdb stored in the folder databases

//Get all data
$data = $jsdb->get("databases/people");
// All data fron the database will be stored as array in $data, each array value is a row.

//Get certain rows
$onlyJohn = $jsdb->get_row("databases/people", "{`name`:`John`}");
// All rows containing 'John' as the value for name, will be stored in $onlyJohn

$onlyJohn27 = $jsdb->get_row("databases/people", "{`name`:`John`, `age`:`27`}");
// All rows containing 'John' as the value for name and '27' for the value of age, will be stored in $onlyJohn27

//Update A row
$jsdb->update_row("databases/people", "{`job`:`Comedian`}", "{`job`:`Entertainer`}");
// All rows containig job as 'Comedian' will have the value of job changed to 'Entertainer'

$jsdb->update_row("databases/people", "{`job`:`Comedian`, `age`:`27`}", "{`workType`:`public`}");
// All rows containig job as 'Comedian' and age as '27' will have the value of workType changed to 'public'

//Remove A row
$jsdb->remove_row("databases/people", "{`email`:`john.doe@example.com`}");
// All rows containig email as 'john.doe@example.com' will be removed from the database

//Generate a random string
echo $jsdb->uniqstr(50);
//ck8qKP6pCGetC0Du3l79NcyfrqpSqf36jgNwMEFUSfoSheSPE1

echo $jsdb->uniqstr(5);
//n5Tys

//Generate a random string with the paramanter being length of the string, this will be useful for assigning id's for a data if relations will be used

//SAFE
$sample_str = "Harry`,`secret`:`this is a secret";
$jsdb->add_row("databases/people", "{`name`:`$sample_str`, `age`:`20`, `job`:`Actor`, `email`:`sampleman@example.com`, `workType`:`public`}");

//This will translate to
$jsdb->add_row("databases/people", "{`name`:`Harry`,`secret`:`this is a secret`, `age`:`20`, `job`:`Actor`, `email`:`sampleman@example.com`, `workType`:`public`}");
//Which is adding a new key 'secret'  into the database, which can be used to over load the database

$safe_str = $jsdb->safe($sample_str);
$jsdb->add_row("databases/people", "{`name`:`$safe_str`, `age`:`20`, `job`:`Actor`, `email`:`sampleman@example.com`, `workType`:`public`}");

//This will translate to
$jsdb->add_row("databases/people", "{`name`:`Harry','secret':'this is a secret`, `age`:`20`, `job`:`Actor`, `email`:`sampleman@example.com`, `workType`:`public`}");
//Here name will be recogonised as "Harry','secret':'this is a secret" instead of creating a new key
?>
