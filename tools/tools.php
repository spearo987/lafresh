<?php

function error404($message = 'Page not Found')
{
	header("HTTP/1.0 404 Not Found");
	die($message);
}