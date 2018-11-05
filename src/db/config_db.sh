# remove database file (if existant)
rm database.db >/dev/null 2>&1

# initialize db based on schema.sql file that contains db schema
sqlite3 database.db < schema.sql

# populate the db with data in data.sql
sqlite3 database.db < data.sql