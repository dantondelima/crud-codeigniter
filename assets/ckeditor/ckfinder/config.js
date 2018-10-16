/*
 Copyright (c) 2007-2018, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or https://ckeditor.com/sales/license/ckfinder
 */

function CheckAuthentication() {
	if (!empty($_SESSION['usuario'])){
		return true;
	}

	return false;
}

var config = {};

// Set your configuration options below.

// Examples:
// config.language = 'pl';
// config.skin = 'jquery-mobile';

CKFinder.define( config );
