<?php
/**
 * The contents of this source file is the sole property of Dovetorabbit Ltd.
 * Unauthorized duplication or access is prohibited.
 *
 *
 * @package		Dove
 * @author			Dove Tech Team
 * @copyright		Copyright (C) 2007-2017 Dovetorabbit Ltd.
 * @since			Version 1.0
 */

$DOCROOT = $_SERVER["DOCUMENT_ROOT"];
$ORGPATH = "/season5/";
$LIBPATH = $DOCROOT . $ORGPATH . "lib";
$INCPATH = $DOCROOT . $ORGPATH . "include";
$RSCPATH = $DOCROOT . $ORGPATH . "resource";

require_once("{$LIBPATH}/conf/conf.constants.php");
require_once("{$LIBPATH}/conf/conf.db.php");
require_once("{$LIBPATH}/class/class.input.filter.php");
require_once("{$LIBPATH}/funcs/funcs.common.php");
// require_once("{$LIBPATH}/class/class.pdodatabase.php");
require_once("{$LIBPATH}/class/class.thumbnail.php");
// require_once("{$LIBPATH}/class/class.upload.php");
require_once("{$LIBPATH}/class/uploadClass.php");
require_once("{$LIBPATH}/3rdparty/phpexcel/Classes/PHPExcel.php");
// require_once("{$LIBPATH}/3rdparty/google-api-php-client/src/Google_Client.php");
// require_once("{$LIBPATH}/3rdparty/google-api-php-client/src/contrib/Google_YouTubeService.php");

$noHtmlFilter = new clsInputFilter();

if (session_id() === "")
{
	session_start();
}
?>