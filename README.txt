------------------------------------------------------
--------------   Group #32 , class 3   ---------------
----   Traveler - Share your travellign stories   ----
------------------------------------------------------


Groups elements:
- Filipa Manita Santos Durão        up201606640
- Henrique Melo Lima                up201606525
- Rui Pedro Moutinho Moreira Alves  up201606746

------------------------------------------------------

Some user login credentials:

username: SelenaPeterson
password: 12345678

username: rogerMC
password: 12345678

------------------------------------------------------

Deployment instructions:
In order to deploy the website in a gnomo.fe.up.pt, one needs to decompress the ltw32.zip file in the desired folder and run the following script, 
which is present inside the ltw32.zip file:

./server_config.sh <root_path>

where the root_path is the server's root path inside gnomo.fe.up.pt

Example:
To deploy the server in student up2016KXYZW, one needs to extract the ltw32.zip to the public_html folder of user's 2016KXYZW home page.
Then, inside the public_html folder, one needs to run the configuration script:
./server_config.sh "~up2016KXYZW"
The server is now up and running

The script configures the .htaccess file with the necessary environment variables and configures the root path for php files.

To "build" the database, one needs to go the "db" direction (under the public_html folder) and run the following script:
./config_db.sh

This script builds a new database file based on the schema.sql file (containing the database schema) and the data.sql file (containing database "dummie" data).

The website is also live and running under the following hyperlink:
https://web.fe.up.pt/~up201606746/

------------------------------------------------------

No external helper libraries were used.

------------------------------------------------------

Implemented features:

All the required features were implemented successfully.

The were also implemented extra features:
- Multilevel coments (2 levels due to design reasons, although the current database supports multi level comments)
- Sorting -> Stories can be sorted in different ways
- Search engine -> Users can search for stories in the website (both by their title or by their creator user)
- A REST api (featuring authentication)
- User points -> A user has a score based on the total votes on its own stories
- User profiles -> The website features profile pages where all the user stories are visible.
  The user can also configure it's own profile (biography, profile picture and password) in his/hers profile page
- Story pictures and user pictures -> The website allows users to post stories with pictures
- Various design features:
    - Implemented a custom dynamic masonry layout to display stories
    - Added a website banner using parallax effect
    - A generic modal container to allow user to view stories in detail, login, register, ...  

The server is protected (according to all the penetration tests we executed) against the following "mainstream" attacks:
- XSS attacks
- Injection (SQL and others)
- Cross Site Request Forgery (by using csrf tokens to authenticate api requests)
