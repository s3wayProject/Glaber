<?php
global $DB, $HISTORY;
// Zabbix GUI configuration file.

$DB['TYPE']				= 'POSTGRESQL';
$DB['SERVER']			= 'localhost';
$DB['PORT']				= '0';
$DB['DATABASE']			= 'zabbix';
$DB['USER']				= 'zabbix';
$DB['PASSWORD']			= 'glabbix';

// Schema name. Used for PostgreSQL.
$DB['SCHEMA']			= '';

// Used for TLS connection.
$DB['ENCRYPTION']		= true;
$DB['KEY_FILE']			= '';
$DB['CERT_FILE']		= '';
$DB['CA_FILE']			= '';
$DB['VERIFY_HOST']		= false;
$DB['CIPHER_LIST']		= '';

// Vault configuration. Used if database credentials are stored in Vault secrets manager.
$DB['VAULT_URL']		= '';
$DB['VAULT_DB_PATH']	= '';
$DB['VAULT_TOKEN']		= '';

// Use IEEE754 compatible value range for 64-bit Numeric (float) history values.
// This option is enabled by default for new Zabbix installations.
// For upgraded installations, please read database upgrade notes before enabling this option.
$DB['DOUBLE_IEEE754']	= true;

$ZBX_SERVER				= 'localhost';
$ZBX_SERVER_PORT		= '10051';
$ZBX_SERVER_NAME		= 'glaber';

$IMAGE_FORMAT_DEFAULT	= IMAGE_FORMAT_PNG;

// Clickhouse url (can be string if same url is used for all types).
$HISTORY['storagetype']='glaber';
$HISTORY['url']   = 'http://127.0.0.1:8123';
$HISTORY['types'] = ['uint', 'dbl','str','text'];
$HISTORY['dbname'] = 'glaber';
$HISTORY['username'] = 'default';
$HISTORY['password'] = 'glabbix';
