<?php

copy(dirname(__DIR__) . '/.env.dist', dirname(__DIR__) . '/.env');

chdir(dirname(__DIR__) . '/var/db');
passthru('sqlite3 ticket.sqlite3 --init ticket.sql');
