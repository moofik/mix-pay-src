CREATE
OR REPLACE FUNCTION create_brainpower_db() RETURNS void AS
$$
BEGIN
    CREATE
EXTENSION dblink;
   IF
NOT EXISTS (
      SELECT
      FROM   pg_catalog.pg_roles
      WHERE  rolname = 'brainpower') THEN

CREATE ROLE brainpower WITH SUPERUSER LOGIN PASSWORD 'brainpower';
END IF;
   IF
EXISTS (SELECT FROM pg_database WHERE datname = 'brainpower') THEN
      RAISE NOTICE 'Database already exists';
ELSE
      PERFORM dblink_exec('dbname=' || current_database()
                        , 'CREATE DATABASE brainpower');
END IF;
   GRANT ALL PRIVILEGES ON DATABASE
brainpower TO brainpower;
END
$$
LANGUAGE plpgsql VOLATILE;

SELECT create_brainpower_db();