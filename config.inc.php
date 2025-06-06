<?php

# Database management system to use
$DBMS = 'MySQL';

# Database variables
$_DVWA = array();
$_DVWA['db_server']   = 'mysql';          # Nome do serviço do contêiner MySQL
$_DVWA['db_database'] = 'dvwa';           # Nome do banco de dados
$_DVWA['db_user']     = 'user';           # Nome do usuário do banco de dados
$_DVWA['db_password'] = 'password';       # Senha do banco de dados

# ReCAPTCHA settings
$_DVWA['recaptcha_public_key']  = '';
$_DVWA['recaptcha_private_key'] = '';

# Default security level
$_DVWA['default_security_level'] = 'low';

# Default PHPIDS status
$_DVWA['default_phpids_level'] = 'disabled';

# Verbose PHPIDS messages
$_DVWA['default_phpids_verbose'] = 'false';

?>
