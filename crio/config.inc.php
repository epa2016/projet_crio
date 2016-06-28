<?php

// $Id$

/**************************************************************************
 *   MRBS Configuration File
 *   Configure this file for your site.
 *   You shouldn't have to modify anything outside this file.
 *
 *   This file has already been populated with the minimum set of configuration
 *   variables that you will need to change to get your system up and running.
 *   If you want to change any of the other settings in systemdefaults.inc.php
 *   or areadefaults.inc.php, then copy the relevant lines into this file
 *   and edit them here.   This file will override the default settings and
 *   when you upgrade to a new version of MRBS the config file is preserved.
 **************************************************************************/

/**********
 * Timezone
 **********/
 
$timezone = "Europe/Paris";

/*********************************
 * Site identification information
 *********************************/
$mrbs_admin = "votre administrateur";
$mrbs_admin_email = "manager@media9.dauphine.fr";


// The company name is mandatory.   It is used in the header and also for email notifications.
// The company logo, additional information and URL are all optional.

$mrbs_company = "Crio Multimédia";   // This line must always be uncommented ($mrbs_company is used in various places)

// Uncomment this next line to use a logo instead of text for your organisation in the header
//$mrbs_company_logo = "your_logo.gif";    // name of your logo file.   This example assumes it is in the MRBS directory

// Uncomment this next line for supplementary information after your company name or logo
//$mrbs_company_more_info = "Réserver une salle de travail en groupe";  // e.g. "XYZ Department"

$mrbs_company_url = "http://www.media9.dauphine.fr/";

/*******************
 * Database settings
 ******************/
// Which database system: "pgsql"=PostgreSQL, "mysqli"=MySQL
$dbsys = "mysqli";
// Hostname of database server. For pgsql, can use "" instead of localhost
// to use Unix Domain Sockets instead of TCP/IP. For mysql/mysqli "localhost"
// tells the system to use Unix Domain Sockets, and $db_port will be ignored;
// if you want to force TCP connection you can use "127.0.0.1".
$db_host = "localhost";
// If you need to use a non standard port for the database connection you
// can uncomment the following line and specify the port number
// $db_port = 1234;
// Database name:
$db_database = "mrbs";
// Schema name.  This only applies to PostgreSQL and is only necessary if you have more
// than one schema in your database and also you are using the same MRBS table names in
// multiple schemas.
//$db_schema = "public";
// Database login user name:
$db_login = "mrbscrio";
// Database login password:
$db_password = 'mrbscrio2016';
// Prefix for table names.  This will allow multiple installations where only
// one database is available
$db_tbl_prefix = "mrbs_";
// Uncomment this to NOT use PHP persistent (pooled) database connections:
// $db_nopersist = 1;


/* Add lines from systemdefaults.inc.php and areadefaults.inc.php below here
   to change the default configuration. Do _NOT_ modify systemdefaults.inc.php
   or areadefaults.inc.php.  */

/***********************************************
 * Authentication settings - read AUTHENTICATION
 ***********************************************/


$auth["type"] = "db_ext"; // Choix de l'authentification
$auth["admin"][] = "administrateur";

$auth['db_ext']['db_system'] = 'mysqli'; /* Or 'mysqli', 'pgsql' */
$auth['db_ext']['db_host'] = 'localhost'; //Hote de la bdd
$auth['db_ext']['db_username'] = 'mrbscrio'; //identifiant utilisateur de la bdd
$auth['db_ext']['db_password'] = 'mrbscrio2016'; //mdp de la bdd
$auth['db_ext']['db_name'] = 'mrbs'; //nom de la base de données utilisateur
$auth['db_ext']['db_table'] = 'crio_user'; //nom de la table utilisateur
$auth['db_ext']['column_name_username'] = 'user'; //colonne identifiant utilisateur
$auth['db_ext']['column_name_password'] = 'password'; //colonne mdp utilisateur
$auth['db_ext']['password_format'] = 'plaintext'; //cryptage choisi ici plaintext

/*******************
 * Calendar settings
 *******************/

 
  // TIMES SETTINGS
// --------------

 $enable_periods = FALSE;
 
// The beginning of the first slot of the day (DEFAULT VALUES FOR NEW AREAS)
$morningstarts         = 9;   // must be integer in range 0-23
$morningstarts_minutes = 0;   // must be integer in range 0-59

// The beginning of the last slot of the day (DEFAULT VALUES FOR NEW AREAS)
$eveningends           = 21;  // must be integer in range 0-23
$eveningends_minutes   = 00;   // must be integer in range 0-59

$resolution = (60 * 60);  // Resolution - what blocks can be booked, in seconds.

/******************
 * Booking policies
 ******************/

// It is possible to set policies that restrict how far in advance ordinary users can make
// bookings.   Both minimum and maximum values can be set.  It is also possible to distinguish
// between creating new bookings and deleting existing bookings.  Editing an existing booking
// involves deleting the existing booking and creating a new booking at the (possibly) new time.
// So if for example you want to stop people editing existing bookings, but allow the creation
// of new bookings, then you will need to prevent deletion but allow creation.

// If the variables below are set to TRUE, MRBS will force a minimum and/or maximum advance
// booking time on ordinary users (admins can make bookings for whenever they like).   The
// minimum advance booking time allows you to set a policy saying that users must book
// at least so far in advance.  The maximum allows you to set a policy saying that they cannot
// book more than so far in advance.  How the times are determined depends on whether Periods
// or Times are being used.

// DEFAULT VALUES FOR NEW AREAS

// Creating new bookings
$min_create_ahead_enabled = TRUE;    // set to TRUE to enforce a minimum advance booking time
$max_create_ahead_enabled = TRUE;    // set to TRUE to enforce a maximum advance booking time

// Deleting existing bookings
$min_delete_ahead_enabled = TRUE;    // set to TRUE to enforce a minimum advance booking time
$max_delete_ahead_enabled = FALSE;    // set to TRUE to enforce a maximum advance booking time

// The advance booking limits are measured in seconds and are set by the two variables below.
// The relevant time for determining whether a booking is allowed is the start time of the
// booking.  Values may be negative: for example setting $min_delete_ahead_secs = -300 means
// that users cannot delete (and this will include editing) a booking more than 5 minutes in
// the past.


// DEFAULT VALUES FOR NEW AREAS

// Creating new bookings
$min_create_ahead_secs = 0;           // (seconds) cannot book in the past
$max_create_ahead_secs = 60*60*24*14;  // (seconds) no more than two week ahead

// Deleting existing bookings
$min_delete_ahead_secs = 0;           // (seconds) cannot book in the past
$max_delete_ahead_secs = -30*60*1*1;  // (seconds) no more than 30 secondes ahead

// NOTE:  If you are using periods, MRBS has no notion of when the periods occur during the
// day, and so cannot impose policies of the kind "users must book at least one period
// in advance".    However it can impose policies such as "users must book at least
// one day in advance".   The two values above are rounded down to the nearest whole 
// number of days when using periods.   For example 86401 will be rounded down to 86400
// (one day) and 1 will be rounded down to 0.
//
// As MRBS does not know when the periods occur in the day, there is no way of specifying, for example,
// that bookings must be made at least 24 hours in advance.    Setting $min_create_ahead_secs=86400
// will allow somebody to make a booking at 11:59 pm for the first period the next day, which
// which may occur at 8.00 am.


// Set a maximum duration for bookings
$max_duration_enabled = TRUE; // Set to TRUE if you want to enforce a maximum duration
$max_duration_secs = 60*60*2;  // (seconds) - when using "times"
$max_duration_periods = 2;     // (periods) - when using "periods"



// DEFAULT VALUES FOR NEW AREAS
// Set the maximum number of bookings that can be made in an area by any one user, in an
// interval, which can be a day, week, month or year, or else in the future.  (A week is
// defined by the $weekstarts setting).   These are per-area settings but you can use them
// in conjunction with the global settings.   This would allow you to set policies such as
// allowing a maximum of 10 bookings per month in total with a maximum of 1 per day in Area A.
$max_per_interval_area_enabled['day']    = TRUE;
$max_per_interval_area['day'] = 2;      // max 1 bookings per day in an area

$max_per_interval_area_enabled['week']   = TRUE;
$max_per_interval_area['week'] = 10;     // max 5 bookings per week in an area

$max_per_interval_area_enabled['month']  = TRUE;
$max_per_interval_area['month'] = 30;   // max 10 bookings per month in an area

//$max_per_interval_area_enabled['year']   = FALSE;
//$max_per_interval_area['year'] = 50;    // max 50 bookings per year in an area

//$max_per_interval_area_enabled['future'] = FALSE;
//$max_per_interval_area['future'] = 100; // max 100 bookings in the future in an area

/************************
 * Miscellaneous settings
 ************************/
 
// PRIVATE BOOKINGS SETTINGS


$is_private_field['entry.create_by'] = FALSE;
$private_enabled = TRUE;  // DEFAULT VALUE FOR NEW AREAS
           // Display checkbox in entry page to make
           // the booking private.

$private_mandatory = TRUE;  // DEFAULT VALUE FOR NEW AREAS
           // If TRUE all new/edited entries will 
           // use the value from $private_default when saved.
           // If checkbox is displayed it will be disabled.
           
$private_default = TRUE;  // DEFAULT VALUE FOR NEW AREAS
           // Set default value for "Private" flag on new/edited entries.
           // Used if the $private_enabled checkbox is displayed
           // or if $private_mandatory is set.


// SETTINGS FOR BOOKING CONFIRMATION

// Allows bookings to be marked as "tentative", ie not yet 100% certain,
// and confirmed later.   Useful if you want to reserve a slot but at the same
// time let other people know that there's a possibility it may not be needed.
$confirmation_enabled = FALSE;

// The default confirmation status for new bookings.  (TRUE: confirmed, FALSE: tentative)
// Only used if $confirmation_enabled is TRUE.   If $confirmation_enabled is 
// FALSE, then all new bookings are confirmed automatically.
$confirmed_default = FALSE;

/******************
 * Display settings
 ******************/

// [These are all variables that control the appearance of pages and could in time
//  become per-user settings]

// Start of week: 0 for Sunday, 1 for Monday, etc.
$weekstarts = 1;

// Days of the week that should be hidden from display
// 0 for Sunday, 1 for Monday, etc.
// For example, if you want Saturdays and Sundays to be hidden set $hidden_days = array(0,6);
//
// By default the hidden days will be removed completely from the main table in the week and month
// views.   You can alternatively arrange for them to be shown as narrow, greyed-out columns
// by editing the CSS file.   Look for $column_hidden_width in mrbs.css.php.
//
// [Note that although they are hidden from display in the week and month views, they 
// can still be booked from the edit_entry form and you can display the bookings by
// jumping straight into the day view from the date selector.]
$hidden_days = array(0,6);

// Time format in pages. 0 to show dates in 12 hour format, 1 to show them
// in 24 hour format
$twentyfourhour_format = 1;

// The number of years back and ahead the date selectors should go
$year_range['back'] = 0;
$year_range['ahead'] = 1;

// Formats used for dates and times.   For formatting options
// see http://php.net/manual/function.strftime.php
$strftime_format['date']         = "%A %d %B %Y";  // Used in Day view
$strftime_format['dayname']      = "%A";           // Used in Month view
$strftime_format['dayname_edit'] = "%a";           // Used in edit_entry form
$strftime_format['dayname_cal']  = "%a";           // Used in mini calendars
$strftime_format['month_cal']    = "%B";           // Used in mini calendars
$strftime_format['mon']          = "%b";           // Used in date selectors
$strftime_format['ampm']         = "%p";
$strftime_format['time12']       = "%I:%M%p";      // 12 hour clock
$strftime_format['time24']       = "%H:%M";        // 24 hour clock
$strftime_format['datetime']     = "%c";           // Used in Help
$strftime_format['datetime12']   = "%I:%M:%S%p - %A %d %B %Y";  // 12 hour clock
$strftime_format['datetime24']   = "%H:%M:%S - %A %d %B %Y";    // 24 hour clock
// If you prefer dates as "10 Jul" instead of "Jul 10" ($dateformat = TRUE in
// MRBS 1.4.5 and earlier) then use
// $strftime_format['daymonth']     = "%d %b";
$strftime_format['daymonth']     = "%b %d";        // Used in trailer
$strftime_format['monyear']      = "%b %Y";        // Used in trailer
$strftime_format['monthyear']    = "%B %Y";        // Used in Month view

// Whether or not to display the timezone
$display_timezone = FALSE;

// Results per page for searching:
$search["count"] = 10;

// Page refresh time (in seconds). Set to 0 to disable
$refresh_rate = 5;

// Refresh rate (in seconds) for Ajax checking of valid bookings on the edit_entry page
// Set to 0 to disable
$ajax_refresh_rate = 10;

// Trailer type.   FALSE gives a trailer complete with links to days, weeks and months before
// and after the current date.    TRUE gives a simpler trailer that just has links to the
// current day, week and month.
$simple_trailer = TRUE;

// should areas be shown as a list or a drop-down select box?
// $area_list_format = "list";
$area_list_format = "select";

// Entries in monthly view can be shown as start/end slot, brief description or
// both. Set to "description" for brief description, "slot" for time slot and
// "both" for both. Default is "both", but 6 entries per day are shown instead
// of 12.
$monthly_view_entries_details = "both";

// To view weeks in the bottom trailer as week numbers (42) instead of
// 'first day of the week' (13 Oct), set this to TRUE.  Will also give week
// numbers in the month view
$view_week_number = FALSE;

// To display week numbers in the mini-calendars, set this to true. The week
// numbers are only accurate if you set $weekstarts to 1, i.e. set the
// start of the week to Monday
$mincals_week_numbers = TRUE;

// To display times on the x-axis (along the top) and rooms or days on the y-axis (down the side)
// set to TRUE;   the default/traditional version of MRBS has rooms (or days) along the top and
// times along the side.    Transposing the table can be useful if you have a large number of
// rooms and not many time slots.
$times_along_top = FALSE;

// To display the row labels (times, rooms or days) on the right hand side as well as the 
// left hand side in the day and week views, set to TRUE;
// (was called $times_right_side in earlier versions of MRBS)
$row_labels_both_sides = FALSE;

// To display the column headers (times, rooms or days) on the bottom of the table as
// well as the top in the day and week views, set to TRUE;
$column_labels_both_ends = FALSE;

// To display the mini calendars at the bottom of the day week and month views
// set this value to TRUE
$display_calendar_bottom = FALSE; 

// Define default starting view (month, week or day)
// Default is day
$default_view = "day";

// Define default room to start with (used by index.php)
// Room numbers can be determined by looking at the Edit or Delete URL for a
// room on the admin page.
// Default is 0
$default_room = 10;

// Define clipping behaviour for the cells in the day and week views.
// Set to TRUE if you want the cells in the day and week views to be clipped.   This
// gives a table where all the rows have the same height, regardless of content.
// Alternatively set to FALSE if you want the cells to expand to fit the content.
// (FALSE not supported in IE6 and IE7 due to their incomplete CSS support)
$clipped = TRUE;                

// Define clipping behaviour for the cells in the month view.
// Set to TRUE if you want all entries to have the same height. The
// short description may be clipped in this case. If set to FALSE,
// each booking entry will be large enough to display all information.
$clipped_month = TRUE;

// Set to TRUE if you want the cells in the month view to scroll if there are too
// many bookings to display; set to FALSE if you want the table cell to expand to
// accommodate the bookings.   (NOTE: (1) scrolling doesn't work in IE6 and so the table
// cell will always expand in IE6.  (2) In IE8 Beta 2 scrolling doesn't work either and
// the cell content is clipped when $month_cell_scrolling is set to TRUE.)
$month_cell_scrolling = TRUE;

// Define the maximum length of a string that can be displayed in an admin table cell
// (eg the rooms and users lists) before it is truncated.  (This is necessary because 
// you don't want a cell to contain for example a 2 kbyte text string, which could happen
// with user defined fields).
$max_content_length = 20;  // characters

// The maximum length of a database field for which a text input can be used on a form
// (eg when editing a user or room).  If longer than this a text area will be used.
$text_input_max = 70;  // characters

// For inputs that have autocomplete options, eg the area and room match inputs on
// the report page, we can define how many characters need to be input before the 
// options are displayed.  This enables us to prevent a huge long list of options
// being presented.   We define the breakpoints in an array.   For example if we set
// $autocomplete_length_breaks = array(25, 250, 2500); this means that if the number of options
// is less than 25 then they will be displayed when 0 characters are input, ie the input
// receives focus.   If the number of options is less than 250 then they will be displayed
// when 1 character is input and so on.    The array can be as long as you like.   If it
// is empty then the options are displayed when 0 characters are input.

// [Note: this variable is only applicable to older browsers that do not support the
// <datalist> element and instead fall back to a JavaScript emulation.   Browsers that
// support <datalist> present the options in a scrollable select box]
$autocomplete_length_breaks = array(25, 250, 2500);

