![JSDB Logo](jsdb-icon.png?raw=true width=100)
# JSDB (JSON Style DataBase)
JSDB is a free and opensource NoSQL databases that uses files on the system. Its easy to use, it follows JSON style of storing data and allows the developer a fully customizable encryption. 

## How is it different from other DataBases?
 
JSDB allows the complete control in the hands of the developer including deciding the encryption type, key and iv. JSDB also allows store data as files and developer can decide where the file will be stored in the host system. JSDB comes in with built in functions to access the databases and doesnt use SQL. Since this is in JSON formatting a user will not need to worry about accedentally writing a value to the database with a wrong key, ast it won't break the database or the code. JSDB also have basic functions as to prevent any injections from the database, and gives full customization of the main file to the developer. Visual controls through site is not possible hence controling the database is only in the developer's hand, if the developer requires visual control, developer can make a personal visual database control.

## How to use JSDB

To use JSDB on hast to just add the jsdb-conn.php file in the host server, create a new jsdb object in the files using jsdb. User can store database file anywhere in the host server with the filetypr .jsdb and use the functions to call the database. 

To jsdb-conn.php files with different names can be used, with different encryption values, thus providing 2 databases in the site with completely different encryption types.

## Important details

* Messing with any part of the database file will cause unfixable damage, it is recommended that bacup of data is taken often, Developer can take backup by using `get` function and writing it to a file.
* Changing encryption values once databases is populated will destroy the database file, only change values before populating data
* Keep database files and jsdb-conn.php file out of  reach from anyone you dont trust
* It is recommended to change name of jsdb-conn.php for security reasons
* Do not input any code in jsdb-conn.php that will echo out something, or redirect page, as it will be applied on pages it is called.
* Do not reveal encryption values to anyone

## JSDB code

JSDB code is a specific kind of code that can be used to access the data from databases, JSDB example will be entered in functions to identify row(s) from the database.
JSDB code is similar to JSON.
JSDB code file will be found in the help folder

## Who is it useful most for

For people learning developing websites with a backend, hosting providers have a database limit for the free version users or users of a selected plan, but since JSDB is stored as file, there is no limit other than the storage space, and since its encrypted it takes less space depending on the data inputed, there is no row limit in the database. JSDB can also used to store data for releasing websites too.

## Errors you may face

The most common error discovered is the 'NextLineError' Which is caused by passing a string which as a nextline in it. This error can be fixed by replacing
`"\r\n" as <<_rn_>>` and `"\n" as <<_n_>>`, both `<<_rn_>>` and `<<_n_>>` can be written differently by the programmer, theyre like variables. The the developer can store this string in the database and be able to replace them with `<br>` when displaying them from the database.
