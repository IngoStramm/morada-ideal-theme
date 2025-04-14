<?php

#region Constants
define('MI_DIR', get_template_directory());
define('MI_URL', get_template_directory_uri());

#endregion Constants

#region Classes

require_once(MI_DIR . '/classes/classes.php');

#endregion Classes

#region Requires

// Theme Functions
require_once(MI_DIR . '/functions/functions.php');

// Style/Scripts include
require_once(MI_DIR . '/scripts.php');

#endregion Requires
