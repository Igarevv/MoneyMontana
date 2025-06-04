\connect postgres

SELECT 'CREATE DATABASE money_montana'
WHERE NOT EXISTS (SELECT
                  FROM pg_database
                  WHERE datname = 'money_montana')
\gexec

SELECT 'CREATE DATABASE money_montana_test'
WHERE NOT EXISTS (SELECT
                  FROM pg_database
                  WHERE datname = 'money_montana_test')
\gexec