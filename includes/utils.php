<?php 
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
function goabrod_install_db() {
	global $wpdb;
	$crm_setting = $wpdb->prefix . 'gocrm_settings';
	$form_group_table = $wpdb->prefix . 'gocrm_form_group';
	$form_fields_table = $wpdb->prefix . 'gocrm_form_fields';
	$gocrm_form_types = $wpdb->prefix . 'gocrm_form_types';
	$form_submit_table = $wpdb->prefix . 'gocrm_submit_log';
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	
	$crm_setting_q = "CREATE TABLE $crm_setting (
		`id` int(20) NOT NULL AUTO_INCREMENT ,
		`option` VARCHAR(100) NULL DEFAULT NULL,
		`value` VARCHAR(100) NULL DEFAULT NULL,
		PRIMARY KEY  (id)
	) ";

	dbDelta( $crm_setting_q );

	$form_group = "CREATE TABLE $form_group_table (
		`id` INT(20) NOT NULL AUTO_INCREMENT,
		`group_name` VARCHAR(100) NULL DEFAULT NULL,
		`status` INT(11) NULL DEFAULT NULL,
		`form_type` VARCHAR(150) NULL DEFAULT NULL,
		`dateadded` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
	) ";

	dbDelta( $form_group );
	
	$form_fields = "CREATE TABLE $form_fields_table (
		`id` INT(20) NOT NULL AUTO_INCREMENT,
		`form_group_id` INT(11) NULL DEFAULT NULL,
		`form_label` VARCHAR(100) NULL DEFAULT NULL,
		`form_name` VARCHAR(100) NULL DEFAULT NULL,
		`dateadded` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
		`sort` INT(2) NULL DEFAULT NULL,
		`required` INT(1) UNSIGNED ZEROFILL NULL DEFAULT '0',
		PRIMARY KEY (`id`)
	) ";

	dbDelta( $form_fields );
	
	$form_xml = "CREATE TABLE $gocrm_form_types (
		`id` INT(11) NOT NULL AUTO_INCREMENT,
		`form_field` VARCHAR(500) NOT NULL,
		`form_type` VARCHAR(500) NOT NULL,
		`form_select_match` VARCHAR(500) NOT NULL,
		`dateadded` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
	) ";

	dbDelta( $form_xml );
	
	$form_submitlog = "CREATE TABLE $form_submit_table (
		`id` int(20) NOT NULL AUTO_INCREMENT ,
		`json_data` VARCHAR(5000) NULL DEFAULT NULL,
		`ip_from` VARCHAR(100) NULL DEFAULT NULL,
		`dateadded` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY  (id)
	) ";

	dbDelta( $form_submitlog );
	
	$dataforformtypes = "INSERT INTO {$gocrm_form_types} (`id`, `form_field`, `form_type`, `form_select_match`, `dateadded`) VALUES
	(1, 'ACADEMIC REFERENCE DATE SIGNED', 'text', '', '2017-09-01 15:54:20'),
	(2, 'ACADEMIC REFERENCE DATE SUBMITTED', 'text', '', '2017-09-01 15:54:20'),
	(3, 'ACADEMIC REFERENCE ELECTRONIC SIGNATURE', 'text', '', '2017-09-01 15:54:20'),
	(4, 'ACADEMIC REFERENCE EMAIL', 'text', '', '2017-09-01 15:54:20'),
	(5, 'ACADEMIC REFERENCE FIRST NAME', 'text', '', '2017-09-01 15:54:20'),
	(6, 'ACADEMIC REFERENCE LAST NAME', 'text', '', '2017-09-01 15:54:20'),
	(7, 'ACADEMIC REFERENCE PHONE', 'text', '', '2017-09-01 15:54:20'),
	(8, 'ACADEMIC REFERENCE TITLE', 'text', '', '2017-09-01 15:54:20'),
	(9, 'ADDITIONAL COMMENT', 'textarea', '', '2017-09-01 15:54:20'),
	(10, 'ADDRESS 1', 'text', '', '2017-09-01 15:54:20'),
	(11, 'ADDRESS 1', 'text', '', '2017-09-01 15:54:20'),
	(12, 'ADDRESS 2', 'text', '', '2017-09-01 15:54:20'),
	(13, 'ADDRESS 2', 'text', '', '2017-09-01 15:54:20'),
	(14, 'AID APPLICATION DEADLINE', 'text', '', '2017-09-01 15:54:20'),
	(15, 'AID DUE TO US', 'text', '', '2017-09-01 15:54:20'),
	(16, 'AID PAYMENT 1', 'text', '', '2017-09-01 15:54:20'),
	(17, 'AID PAYMENT 2', 'text', '', '2017-09-01 15:54:20'),
	(18, 'AID PAYMENT 3', 'text', '', '2017-09-01 15:54:20'),
	(19, 'AID PAYMENT DUE DATE', 'text', '', '2017-09-01 15:54:20'),
	(20, 'AID TO BE DISBURSED', 'text', '', '2017-09-01 15:54:20'),
	(21, 'ALTERNATE EMAIL', 'text', '', '2017-09-01 15:54:20'),
	(22, 'ALTERNATE EMAIL', 'text', '', '2017-09-01 15:54:20'),
	(23, 'ANTICIPATED TRAVEL DATE', 'text', '', '2017-09-01 15:54:20'),
	(24, 'APPLICANT PROFILE BILL PAYER', 'text', '', '2017-09-01 15:54:20'),
	(25, 'APPLICANT PROFILE BILLING CONTACT ADDRESS 1', 'text', '', '2017-09-01 15:54:20'),
	(26, 'APPLICANT PROFILE BILLING CONTACT ADDRESS 2', 'text', '', '2017-09-01 15:54:20'),
	(27, 'APPLICANT PROFILE BILLING CONTACT CITY', 'text', '', '2017-09-01 15:54:20'),
	(28, 'APPLICANT PROFILE BILLING CONTACT COUNTRY', 'select', 'Countries', '2017-09-01 15:54:20'),
	(29, 'APPLICANT PROFILE BILLING CONTACT EMAIL', 'text', '', '2017-09-01 15:54:20'),
	(30, 'APPLICANT PROFILE BILLING CONTACT FIRST NAME', 'text', '', '2017-09-01 15:54:20'),
	(31, 'APPLICANT PROFILE BILLING CONTACT LAST NAME', 'text', '', '2017-09-01 15:54:20'),
	(32, 'APPLICANT PROFILE BILLING CONTACT PHONE', 'text', '', '2017-09-01 15:54:20'),
	(33, 'APPLICANT PROFILE BILLING CONTACT STATE', 'select', 'States', '2017-09-01 15:54:20'),
	(34, 'APPLICANT PROFILE BILLING CONTACT ZIP CODE', 'text', '', '2017-09-01 15:54:20'),
	(35, 'APPLICANT PROFILE BIRTH COUNTRY', 'select', 'Countries', '2017-09-01 15:54:20'),
	(36, 'APPLICANT PROFILE DATE SUBMITTED', 'text', '', '2017-09-01 15:54:20'),
	(37, 'APPLICANT PROFILE DRIVERS LICENSE #', 'text', '', '2017-09-01 15:54:20'),
	(38, 'APPLICANT PROFILE DRIVERS LICENSE STATE', 'select', 'States', '2017-09-01 15:54:20'),
	(39, 'APPLICANT PROFILE GREEN VOLUNTEER', 'text', '', '2017-09-01 15:54:20'),
	(40, 'APPLICANT PROFILE PASSPORT #', 'text', '', '2017-09-01 15:54:20'),
	(41, 'APPLICANT PROFILE PASSPORT EXPIRATION DATE', 'text', '', '2017-09-01 15:54:20'),
	(42, 'APPLICANT PROFILE SPECIAL NEEDS', 'text', '', '2017-09-01 15:54:20'),
	(43, 'APPLICATION COMPLETED DATE', 'text', '', '2017-09-01 15:54:20'),
	(44, 'APPLICATION DATE', 'text', '', '2017-09-01 15:54:20'),
	(45, 'APPLICATION FEE', 'text', '', '2017-09-01 15:54:20'),
	(46, 'APPLICATION PROCESS NOTES', 'text', '', '2017-09-01 15:54:20'),
	(47, 'APPLICATION STARTED DATE', 'text', '', '2017-09-01 15:54:20'),
	(48, 'APPLICATION STATUS 1', 'text', '', '2017-09-01 15:54:20'),
	(49, 'APPLICATION STATUS 2', 'text', '', '2017-09-01 15:54:20'),
	(50, 'APPLICATION STATUS 3', 'text', '', '2017-09-01 15:54:20'),
	(51, 'APPROVAL CONTACT CURRENTLY IN SCHOOL', 'text', '', '2017-09-01 15:54:20'),
	(52, 'APPROVAL CONTACT DATE SUBMITTED', 'text', '', '2017-09-01 15:54:20'),
	(53, 'APPROVAL CONTACT EMAIL', 'text', '', '2017-09-01 15:54:20'),
	(54, 'APPROVAL CONTACT FIRST NAME', 'text', '', '2017-09-01 15:54:20'),
	(55, 'APPROVAL CONTACT LAST NAME', 'text', '', '2017-09-01 15:54:20'),
	(56, 'APPROVAL CONTACT PHONE', 'text', '', '2017-09-01 15:54:20'),
	(57, 'ARE YOU APPLYING FOR A SCHOLARSHIP OR GRANT', 'text', '', '2017-09-01 15:54:20'),
	(58, 'ASSIGNED HOUSING', 'text', '', '2017-09-01 15:54:20'),
	(59, 'BIRTH DATE', 'text', '', '2017-09-01 15:54:20'),
	(60, 'CERTIFICATES', 'text', '', '2017-09-01 15:54:20'),
	(61, 'CITIZENSHIP COUNTRY', 'select', 'Countries', '2017-09-01 15:54:20'),
	(62, 'CITY', 'text', '', '2017-09-01 15:54:20'),
	(63, 'CONVERTED FROM LEAD', 'text', '', '2017-09-01 15:54:20'),
	(64, 'COUNTRY', 'select', 'Countries', '2017-09-01 15:54:20'),
	(65, 'COUNTRY OF INTEREST 1', 'select', 'OrganizationCountries', '2017-09-01 15:54:20'),
	(66, 'COUNTRY OF INTEREST 2', 'select', 'OrganizationCountries', '2017-09-01 15:54:20'),
	(67, 'COUPON CODE', 'text', '', '2017-09-01 15:54:20'),
	(68, 'COURSE SELECTION COURSE 1', 'text', '', '2017-09-01 15:54:20'),
	(69, 'COURSE SELECTION COURSE 10', 'text', '', '2017-09-01 15:54:20'),
	(70, 'COURSE SELECTION COURSE 2', 'text', '', '2017-09-01 15:54:20'),
	(71, 'COURSE SELECTION COURSE 3', 'text', '', '2017-09-01 15:54:20'),
	(72, 'COURSE SELECTION COURSE 4', 'text', '', '2017-09-01 15:54:20'),
	(73, 'COURSE SELECTION COURSE 5', 'text', '', '2017-09-01 15:54:20'),
	(74, 'COURSE SELECTION COURSE 6', 'text', '', '2017-09-01 15:54:20'),
	(75, 'COURSE SELECTION COURSE 7', 'text', '', '2017-09-01 15:54:20'),
	(76, 'COURSE SELECTION COURSE 8', 'text', '', '2017-09-01 15:54:20'),
	(77, 'COURSE SELECTION COURSE 9', 'text', '', '2017-09-01 15:54:20'),
	(78, 'COURSE SELECTION DATE SUBMITTED', 'text', '', '2017-09-01 15:54:20'),
	(79, 'CURRENT YEAR IN SCHOOL', 'select', 'SchoolYears', '2017-09-01 15:54:20'),
	(80, 'DATE DUE', 'text', '', '2017-09-01 15:54:20'),
	(81, 'DEPOSIT', 'text', '', '2017-09-01 15:54:20'),
	(82, 'DESIRED SEMESTER', 'select', 'TermTypes', '2017-09-01 15:54:20'),
	(83, 'DIRECT BILL INSTITUTION', 'text', '', '2017-09-01 15:54:20'),
	(84, 'DISCOUNT AMOUNT', 'text', '', '2017-09-01 15:54:20'),
	(85, 'EMAIL', 'text', '', '2017-09-01 15:54:20'),
	(86, 'EMERGENCY CONTACT 1 ADDRESS 1', 'text', '', '2017-09-01 15:54:20'),
	(87, 'EMERGENCY CONTACT 1 ADDRESS 2', 'text', '', '2017-09-01 15:54:20'),
	(88, 'EMERGENCY CONTACT 1 CITY', 'text', '', '2017-09-01 15:54:20'),
	(89, 'EMERGENCY CONTACT 1 COUNTRY', 'select', 'Countries', '2017-09-01 15:54:20'),
	(90, 'EMERGENCY CONTACT 1 EMAIL', 'text', '', '2017-09-01 15:54:20'),
	(91, 'EMERGENCY CONTACT 1 FIRST NAME', 'text', '', '2017-09-01 15:54:20'),
	(92, 'EMERGENCY CONTACT 1 HOME PHONE', 'text', '', '2017-09-01 15:54:20'),
	(93, 'EMERGENCY CONTACT 1 LAST NAME', 'text', '', '2017-09-01 15:54:20'),
	(94, 'EMERGENCY CONTACT 1 MOBILE PHONE', 'text', '', '2017-09-01 15:54:20'),
	(95, 'EMERGENCY CONTACT 1 RELATIONSHIP', 'text', '', '2017-09-01 15:54:20'),
	(96, 'EMERGENCY CONTACT 1 STATE', 'select', 'States', '2017-09-01 15:54:20'),
	(97, 'EMERGENCY CONTACT 1 ZIP CODE', 'text', '', '2017-09-01 15:54:20'),
	(98, 'EMERGENCY CONTACT 2 ADDRESS 1', 'text', '', '2017-09-01 15:54:20'),
	(99, 'EMERGENCY CONTACT 2 ADDRESS 2', 'text', '', '2017-09-01 15:54:20'),
	(100, 'EMERGENCY CONTACT 2 CITY', 'text', '', '2017-09-01 15:54:20'),
	(101, 'EMERGENCY CONTACT 2 COUNTRY', 'select', 'Countries', '2017-09-01 15:54:20'),
	(102, 'EMERGENCY CONTACT 2 EMAIL', 'text', '', '2017-09-01 15:54:20'),
	(103, 'EMERGENCY CONTACT 2 FIRST NAME', 'text', '', '2017-09-01 15:54:20'),
	(104, 'EMERGENCY CONTACT 2 HOME PHONE', 'text', '', '2017-09-01 15:54:20'),
	(105, 'EMERGENCY CONTACT 2 LAST NAME', 'text', '', '2017-09-01 15:54:20'),
	(106, 'EMERGENCY CONTACT 2 MOBILE PHONE', 'text', '', '2017-09-01 15:54:20'),
	(107, 'EMERGENCY CONTACT 2 RELATIONSHIP', 'text', '', '2017-09-01 15:54:20'),
	(108, 'EMERGENCY CONTACT 2 STATE', 'select', 'States', '2017-09-01 15:54:20'),
	(109, 'EMERGENCY CONTACT 2 ZIP CODE', 'text', '', '2017-09-01 15:54:20'),
	(110, 'EMERGENCY CONTACT DATE SUBMITTED', 'text', '', '2017-09-01 15:54:20'),
	(111, 'END DATE', 'text', '', '2017-09-01 15:54:20'),
	(112, 'ENTRY DATE', 'text', '', '2017-09-01 15:54:20'),
	(113, 'EXPIRATION DATE', 'text', '', '2017-09-01 15:54:20'),
	(114, 'EXTENSION', 'text', '', '2017-09-01 15:54:20'),
	(115, 'FIELD OF INTEREST 1', 'text', '', '2017-09-01 15:54:20'),
	(116, 'FIELD OF INTEREST 2', 'text', '', '2017-09-01 15:54:20'),
	(117, 'FINANCE CURRENCY TYPE ID', 'text', '', '2017-09-01 15:54:20'),
	(118, 'FINANCIAL NOTE', 'textarea', '', '2017-09-01 15:54:20'),
	(119, 'FIRST NAME', 'text', '', '2017-09-01 15:54:20'),
	(120, 'FOREIGN LANGUAGE LEVEL', 'text', '', '2017-09-01 15:54:20'),
	(121, 'FOREIGN LANGUAGE NOTE', 'textarea', '', '2017-09-01 15:54:20'),
	(122, 'GENDER', 'text', '', '2017-09-01 15:54:20'),
	(123, 'GPA', 'text', '', '2017-09-01 15:54:20'),
	(124, 'GRADUATION DATE', 'text', '', '2017-09-01 15:54:20'),
	(125, 'HAS ACCEPTED TERMS', 'checkbox', '', '2017-09-01 15:54:20'),
	(126, 'HOUSING DEPOSIT', 'text', '', '2017-09-01 15:54:20'),
	(127, 'HOUSING DEPOSIT DUE DATE', 'text', '', '2017-09-01 15:54:20'),
	(128, 'INSTITUTION', 'select', 'Institutions', '2017-09-01 15:54:20'),
	(129, 'INSTITUTION (MANUAL INPUT)', 'text', '', '2017-09-01 15:54:20'),
	(130, 'INSTITUTION CONTACT EMAIL', 'text', '', '2017-09-01 15:54:20'),
	(131, 'INSTITUTION CONTACT FIRST NAME', 'text', '', '2017-09-01 15:54:20'),
	(132, 'INSTITUTION CONTACT PHONE', 'text', '', '2017-09-01 15:54:20'),
	(133, 'INTERNSHIP PLACEMENT DATE SUBMITTED', 'text', '', '2017-09-01 15:54:20'),
	(134, 'INTERNSHIP PLACEMENT ELECTRONIC SIGNATURE', 'text', '', '2017-09-01 15:54:20'),
	(135, 'INTERNSHIP PLACEMENT EXPERIENCE HOPING TO GAIN', 'text', '', '2017-09-01 15:54:20'),
	(136, 'INTERNSHIP PLACEMENT IDEAL INTERNSHIP PLACEMENT DESCRIPTION', 'textarea', '', '2017-09-01 15:54:20'),
	(137, 'INTERNSHIP PLACEMENT IMPORTANCE TO SPEAK LANGUAGE?', 'text', '', '2017-09-01 15:54:20'),
	(138, 'INTERNSHIP PLACEMENT INTERNSHIP PREFERENCE NOT GUARANTEED', 'text', '', '2017-09-01 15:54:20'),
	(139, 'INTERNSHIP PLACEMENT SEEKING CREDIT', 'text', '', '2017-09-01 15:54:20'),
	(140, 'INTERNSHIP PLACEMENT SPEAK ANOTHER LANGUAGE?', 'text', '', '2017-09-01 15:54:20'),
	(141, 'INTERNSHIP PLACEMENT STRONG CANDIDATE REASONING', 'text', '', '2017-09-01 15:54:20'),
	(142, 'IS HIGH SCHOOL', 'checkbox', '', '2017-09-01 15:54:20'),
	(143, 'IS PARTICIPANT', 'checkbox', '', '2017-09-01 15:54:20'),
	(144, 'IS USING FINANCIAL AID', 'checkbox', '', '2017-09-01 15:54:20'),
	(145, 'LAST NAME', 'text', '', '2017-09-01 15:54:20'),
	(146, 'LEAD SOURCE', 'select', 'LeadSourceTypes', '2017-09-01 15:54:20'),
	(147, 'LEAD SOURCE DETAIL', 'textarea', '', '2017-09-01 15:54:20'),
	(148, 'LEAD STATUS 1', 'select', 'LeadStatuses', '2017-09-01 15:54:20'),
	(149, 'LEAD STATUS 2', 'select', 'LeadStatuses', '2017-09-01 15:54:20'),
	(150, 'LEAD TYPE', 'select', 'LeadTypes', '2017-09-01 15:54:20'),
	(151, 'MAJOR', 'text', '', '2017-09-01 15:54:20'),
	(152, 'MAJOR 1', 'text', '', '2017-09-01 15:54:20'),
	(153, 'MAJOR 2', 'text', '', '2017-09-01 15:54:20'),
	(154, 'MARKETING CAMPAIGN', 'text', '', '2017-09-01 15:54:20'),
	(155, 'MEDICAL INFORMATION ADDITIONAL INFORMATION', 'text', '', '2017-09-01 15:54:20'),
	(156, 'MEDICAL INFORMATION ALLERGIES', 'text', '', '2017-09-01 15:54:20'),
	(157, 'MEDICAL INFORMATION ALLERGIES EXPLANATION', 'text', '', '2017-09-01 15:54:20'),
	(158, 'MEDICAL INFORMATION DATE SUBMITTED', 'text', '', '2017-09-01 15:54:20'),
	(159, 'MEDICAL INFORMATION DIET', 'text', '', '2017-09-01 15:54:20'),
	(160, 'MEDICAL INFORMATION DIET EXPLANATION', 'textarea', '', '2017-09-01 15:54:20'),
	(161, 'MEDICAL INFORMATION INJURED LAST FIVE YEARS', 'text', '', '2017-09-01 15:54:20'),
	(162, 'MEDICAL INFORMATION INJURED LAST FIVE YEARS EXPLANATION', 'text', '', '2017-09-01 15:54:20'),
	(163, 'MEDICAL INFORMATION MEDICATIONS', 'text', '', '2017-09-01 15:54:20'),
	(164, 'MEDICAL INFORMATION MEDICATIONS EXPLANATION', 'textarea', '', '2017-09-01 15:54:20'),
	(165, 'MEDICAL INFORMATION MENTAL HEALTH', 'text', '', '2017-09-01 15:54:20'),
	(166, 'MEDICAL INFORMATION MENTAL HEALTH EXPLANATION', 'text', '', '2017-09-01 15:54:20'),
	(167, 'MEDICAL INFORMATION PHYSICAL CONDITION', 'text', '', '2017-09-01 15:54:20'),
	(168, 'MEDICAL INFORMATION PHYSICAL CONDITION EXPLANATION', 'textarea', '', '2017-09-01 15:54:20'),
	(169, 'MINOR', 'text', '', '2017-09-01 15:54:20'),
	(170, 'MOBILE PHONE', 'text', '', '2017-09-01 15:54:20'),
	(171, 'NOTE', 'textarea', '', '2017-09-01 15:54:20'),
	(172, 'NOTE 1', 'textarea', '', '2017-09-01 15:54:20'),
	(173, 'NOTE 2', 'textarea', '', '2017-09-01 15:54:20'),
	(174, 'NOTE 3', 'textarea', '', '2017-09-01 15:54:20'),
	(175, 'NOTE 4', 'textarea', '', '2017-09-01 15:54:20'),
	(176, 'NUMBER OF WEEKS', 'text', '', '2017-09-01 15:54:20'),
	(177, 'OTHER DEGREES', 'text', '', '2017-09-01 15:54:20'),
	(178, 'PARTICIPATING PROGRAM', 'select', 'Programs', '2017-09-01 15:54:20'),
	(179, 'PARTICIPATING TERM', 'text', '', '2017-09-01 15:54:20'),
	(180, 'PARTICIPATING YEAR', 'text', '', '2017-09-01 15:54:20'),
	(181, 'PARTICIPATION END DATE', 'text', '', '2017-09-01 15:54:20'),
	(182, 'PARTICIPATION START DATE', 'text', '', '2017-09-01 15:54:20'),
	(183, 'PAYMENT 1', 'text', '', '2017-09-01 15:54:20'),
	(184, 'PAYMENT 2', 'text', '', '2017-09-01 15:54:20'),
	(185, 'PAYMENT 3', 'text', '', '2017-09-01 15:54:20'),
	(186, 'PAYMENT 4', 'text', '', '2017-09-01 15:54:20'),
	(187, 'PERMANENT ADDRESS 1', 'text', '', '2017-09-01 15:54:20'),
	(188, 'PERMANENT ADDRESS 2', 'text', '', '2017-09-01 15:54:20'),
	(189, 'PERMANENT CITY', 'text', '', '2017-09-01 15:54:20'),
	(190, 'PERMANENT COUNTRY', 'select', 'Countries', '2017-09-01 15:54:20'),
	(191, 'PERMANENT STATE', 'select', 'States', '2017-09-01 15:54:20'),
	(192, 'PERMANENT STATE/PROVINCE', 'select', 'States', '2017-09-01 15:54:20'),
	(193, 'PERMANENT ZIP', 'text', '', '2017-09-01 15:54:20'),
	(194, 'PERSON TYPE', 'text', '', '2017-09-01 15:54:20'),
	(195, 'PERSONAL STATEMENT DATE SUBMITTED', 'text', '', '2017-09-01 15:54:20'),
	(196, 'PERSONAL STATEMENT EXPECTATIONS', 'text', '', '2017-09-01 15:54:20'),
	(197, 'PERSONAL STATEMENT GOALS', 'textarea', '', '2017-09-01 15:54:20'),
	(198, 'PERSONAL STATEMENT RELATE TO GOALS', 'textarea', '', '2017-09-01 15:54:20'),
	(199, 'PHONE', 'text', '', '2017-09-01 15:54:20'),
	(200, 'PORTAL ACCESS', 'text', '', '2017-09-01 15:54:20'),
	(201, 'PORTAL SETUP COMPLETE', 'text', '', '2017-09-01 15:54:20'),
	(202, 'PREFERRED HOUSING', 'text', '', '2017-09-01 15:54:20'),
	(203, 'PREFERRED HOUSING DATE SUBMITTED', 'text', '', '2017-09-01 15:54:20'),
	(204, 'PREFERRED HOUSING DO YOU SMOKE', 'text', '', '2017-09-01 15:54:20'),
	(205, 'PREFERRED HOUSING LIVING PREFERENCE 1', 'text', '', '2017-09-01 15:54:20'),
	(206, 'PREFERRED HOUSING LIVING PREFERENCE 2', 'text', '', '2017-09-01 15:54:20'),
	(207, 'PREFERRED HOUSING LIVING PREFERENCE 3', 'text', '', '2017-09-01 15:54:20'),
	(208, 'PREFERRED HOUSING LIVING PREFERENCE 4', 'text', '', '2017-09-01 15:54:20'),
	(209, 'PREFERRED HOUSING LIVING PREFERENCE 5', 'text', '', '2017-09-01 15:54:20'),
	(210, 'PREFERRED HOUSING NOTE', 'text', '', '2017-09-01 15:54:20'),
	(211, 'PREFERRED HOUSING OBJECT TO SMOKING', 'text', '', '2017-09-01 15:54:20'),
	(212, 'PREFERRED HOUSING PREFERRED ROOMMATE 1', 'text', '', '2017-09-01 15:54:20'),
	(213, 'PREFERRED HOUSING PREFERRED ROOMMATE 2', 'text', '', '2017-09-01 15:54:20'),
	(214, 'PREFERRED HOUSING PREFERRED ROOMMATE 3', 'text', '', '2017-09-01 15:54:20'),
	(215, 'PREFERRED HOUSING ROOMMATE GENDER', 'text', '', '2017-09-01 15:54:20'),
	(216, 'PREFERRED HOUSING SLEEPING HABITS OTHER EXPLANATION', 'text', '', '2017-09-01 15:54:20'),
	(217, 'PREFERRED HOUSING SOCIAL HABITS OTHER EXPLANATION', 'text', '', '2017-09-01 15:54:20'),
	(218, 'PREFERRED HOUSING SPECIAL NEEDS', 'text', '', '2017-09-01 15:54:20'),
	(219, 'PREFERRED HOUSING CHILD PREFERENCE', 'text', '', '2017-09-01 15:54:20'),
	(220, 'PREFERRED HOUSING CLEANLINESS', 'text', '', '2017-09-01 15:54:20'),
	(221, 'PREFERRED HOUSING PET PREFERENCE', 'text', '', '2017-09-01 15:54:20'),
	(222, 'PREFERRED HOUSING SLEEPING HABITS', 'text', '', '2017-09-01 15:54:20'),
	(223, 'PREFERRED HOUSING SOCIAL HABITS', 'text', '', '2017-09-01 15:54:20'),
	(224, 'PREFERRED HOUSING STUDY HABITS', 'text', '', '2017-09-01 15:54:20'),
	(225, 'PREFERRED NAME', 'text', '', '2017-09-01 15:54:20'),
	(226, 'PROGRAM COST', 'text', '', '2017-09-01 15:54:20'),
	(227, 'PROGRAM OF INTEREST (TEXT)', 'text', '', '2017-09-01 15:54:20'),
	(228, 'PROGRAM OF INTEREST 1', 'select', 'Programs', '2017-09-01 15:54:20'),
	(229, 'PROGRAM OF INTEREST 1', 'select', 'Programs', '2017-09-01 15:54:20'),
	(230, 'PROGRAM OF INTEREST 2', 'select', 'Programs', '2017-09-01 15:54:20'),
	(231, 'PROGRAM OF INTEREST 2', 'select', 'Programs', '2017-09-01 15:54:20'),
	(232, 'PROGRAM OF INTEREST 3', 'select', 'Programs', '2017-09-01 15:54:20'),
	(233, 'PROGRAM TYPE', 'select', 'ProgramTypes', '2017-09-01 15:54:20'),
	(234, 'QUESTION', 'textarea', '', '2017-09-01 15:54:20'),
	(235, 'REASON FOR WITHDRAWAL', 'textarea', '', '2017-09-01 15:54:20'),
	(236, 'REFERRED FROM FRIEND', 'text', '', '2017-09-01 15:54:20'),
	(237, 'REFERRED FROM FRIEND NAME', 'text', '', '2017-09-01 15:54:20'),
	(238, 'SALUTATION', 'text', '', '2017-09-01 15:54:20'),
	(239, 'SCHOLARSHIP APPLICATION DATE SUBMITTED', 'text', '', '2017-09-01 15:54:20'),
	(240, 'SCHOLARSHIP APPLICATION ELECTRONIC SIGNATURE', 'text', '', '2017-09-01 15:54:20'),
	(241, 'SCHOLARSHIP APPLICATION SCHOLARSHIP APPLYING FOR', 'text', '', '2017-09-01 15:54:20'),
	(242, 'SCHOLARSHIP OR GRANT 1', 'text', '', '2017-09-01 15:54:20'),
	(243, 'SCHOLARSHIP OR GRANT 2', 'text', '', '2017-09-01 15:54:20'),
	(244, 'SCHOLARSHIP OR GRANT 3', 'text', '', '2017-09-01 15:54:20'),
	(245, 'SCHOLARSHIPS AWARDED', 'text', '', '2017-09-01 15:54:20'),
	(246, 'SHOW INVOICE TO CLIENT', 'text', '', '2017-09-01 15:54:20'),
	(247, 'SKYPE', 'text', '', '2017-09-01 15:54:20'),
	(248, 'START DATE', 'text', '', '2017-09-01 15:54:20'),
	(249, 'STATE', 'select', 'States', '2017-09-01 15:54:20'),
	(250, 'STATE/PROVINCE', 'select', 'States', '2017-09-01 15:54:20'),
	(251, 'TERM', 'text', '', '2017-09-01 15:54:20'),
	(252, 'TERM OF INTEREST', 'select', 'TermTypes', '2017-09-01 15:54:20'),
	(253, 'TERM OF INTEREST (TEXT)', 'text', '', '2017-09-01 15:54:20'),
	(254, 'TERM OF INTEREST 1', 'select', 'TermTypes', '2017-09-01 15:54:20'),
	(255, 'TERM OF INTEREST 2', 'select', 'TermTypes', '2017-09-01 15:54:20'),
	(256, 'TERM OF INTEREST 3', 'select', 'TermTypes', '2017-09-01 15:54:20'),
	(257, 'TIME ZONE', 'select', 'TimeZones', '2017-09-01 15:54:20'),
	(258, 'TRAVEL INFORMATION ARRIVAL FLIGHT #', 'text', '', '2017-09-01 15:54:20'),
	(259, 'TRAVEL INFORMATION ARRIVAL FLIGHT AIRLINE', 'text', '', '2017-09-01 15:54:20'),
	(260, 'TRAVEL INFORMATION ARRIVAL FLIGHT AIRPORT', 'text', '', '2017-09-01 15:54:20'),
	(261, 'TRAVEL INFORMATION ARRIVAL FLIGHT DATE', 'text', '', '2017-09-01 15:54:20'),
	(262, 'TRAVEL INFORMATION ARRIVAL FLIGHT TIME', 'text', '', '2017-09-01 15:54:20'),
	(263, 'TRAVEL INFORMATION CONNECTING FLIGHT 1 #', 'text', '', '2017-09-01 15:54:20'),
	(264, 'TRAVEL INFORMATION CONNECTING FLIGHT 1 AIRLINE', 'text', '', '2017-09-01 15:54:20'),
	(265, 'TRAVEL INFORMATION CONNECTING FLIGHT 1 AIRPORT', 'text', '', '2017-09-01 15:54:20'),
	(266, 'TRAVEL INFORMATION CONNECTING FLIGHT 1 DATE', 'text', '', '2017-09-01 15:54:20'),
	(267, 'TRAVEL INFORMATION CONNECTING FLIGHT 1 TIME', 'text', '', '2017-09-01 15:54:20'),
	(268, 'TRAVEL INFORMATION CONNECTING FLIGHT 2 #', 'text', '', '2017-09-01 15:54:20'),
	(269, 'TRAVEL INFORMATION CONNECTING FLIGHT 2 AIRLINE', 'text', '', '2017-09-01 15:54:20'),
	(270, 'TRAVEL INFORMATION CONNECTING FLIGHT 2 AIRPORT', 'text', '', '2017-09-01 15:54:20'),
	(271, 'TRAVEL INFORMATION CONNECTING FLIGHT 2 DATE', 'text', '', '2017-09-01 15:54:20'),
	(272, 'TRAVEL INFORMATION CONNECTING FLIGHT 2 TIME', 'text', '', '2017-09-01 15:54:20'),
	(273, 'TRAVEL INFORMATION CONNECTING FLIGHT 3 #', 'text', '', '2017-09-01 15:54:20'),
	(274, 'TRAVEL INFORMATION CONNECTING FLIGHT 3 AIRLINE', 'text', '', '2017-09-01 15:54:20'),
	(275, 'TRAVEL INFORMATION CONNECTING FLIGHT 3 AIRPORT', 'text', '', '2017-09-01 15:54:20'),
	(276, 'TRAVEL INFORMATION CONNECTING FLIGHT 3 DATE', 'text', '', '2017-09-01 15:54:20'),
	(277, 'TRAVEL INFORMATION CONNECTING FLIGHT 3 TIME', 'text', '', '2017-09-01 15:54:20'),
	(278, 'TRAVEL INFORMATION CONNECTING FLIGHT 4 #', 'text', '', '2017-09-01 15:54:20'),
	(279, 'TRAVEL INFORMATION CONNECTING FLIGHT 4 AIRLINE', 'text', '', '2017-09-01 15:54:20'),
	(280, 'TRAVEL INFORMATION CONNECTING FLIGHT 4 AIRPORT', 'text', '', '2017-09-01 15:54:20'),
	(281, 'TRAVEL INFORMATION CONNECTING FLIGHT 4 DATE', 'text', '', '2017-09-01 15:54:20'),
	(282, 'TRAVEL INFORMATION CONNECTING FLIGHT 4 TIME', 'text', '', '2017-09-01 15:54:20'),
	(283, 'TRAVEL INFORMATION DATE SUBMITTED', 'text', '', '2017-09-01 15:54:20'),
	(284, 'TRAVEL INFORMATION DEPARTURE AIRPORT', 'text', '', '2017-09-01 15:54:20'),
	(285, 'TRAVEL INFORMATION DEPARTURE DATE', 'text', '', '2017-09-01 15:54:20'),
	(286, 'TRAVEL INFORMATION DEPARTURE FLIGHT #', 'text', '', '2017-09-01 15:54:20'),
	(287, 'TRAVEL INFORMATION DEPARTURE FLIGHT AIRLINE', 'text', '', '2017-09-01 15:54:20'),
	(288, 'TRAVEL INFORMATION DEPARTURE TIME', 'text', '', '2017-09-01 15:54:20'),
	(289, 'TRAVEL INFORMATION INSURANCE EMERGENCY #', 'text', '', '2017-09-01 15:54:20'),
	(290, 'TRAVEL INFORMATION INSURANCE NAME', 'text', '', '2017-09-01 15:54:20'),
	(291, 'TRAVEL INFORMATION INSURANCE POLICY #', 'text', '', '2017-09-01 15:54:20'),
	(292, 'TRAVEL INFORMATION PROGRAM DEPARTURE AIRPORT', 'text', '', '2017-09-01 15:54:20'),
	(293, 'TRAVEL INFORMATION PROGRAM DEPARTURE FLIGHT #', 'text', '', '2017-09-01 15:54:20'),
	(294, 'TRAVEL INFORMATION PROGRAM DEPARTURE FLIGHT AIRLINE', 'text', '', '2017-09-01 15:54:20'),
	(295, 'TRAVEL INFORMATION PROGRAM DEPARTURE FLIGHT DATE', 'text', '', '2017-09-01 15:54:20'),
	(296, 'TRAVEL INFORMATION PROGRAM DEPARTURE FLIGHT TIME', 'text', '', '2017-09-01 15:54:20'),
	(297, 'YEAR', 'text', '', '2017-09-01 15:54:20'),
	(298, 'YEAR OF INTEREST', 'text', '', '2017-09-01 15:54:20'),
	(299, 'YEAR OF INTEREST (TEXT)', 'text', '', '2017-09-01 15:54:20'),
	(300, 'YEAR OF INTEREST 1', 'text', '', '2017-09-01 15:54:20'),
	(301, 'YEAR OF INTEREST 2', 'text', '', '2017-09-01 15:54:20'),
	(302, 'YEAR OF INTEREST 3', 'text', '', '2017-09-01 15:54:20'),
	(303, 'ZIP', 'text', '', '2017-09-01 15:54:20');";
	dbDelta( $dataforformtypes );
	
	$dataforformgroups = "INSERT INTO {$form_group_table} (`id`, `group_name`, `status`, `form_type`, `dateadded`) VALUES
	(1, 'Lead Capture Form', 1, 'leads', '2017-08-29 06:41:27'),
	(2, 'Application Form Default', 1, 'participants', '2017-08-30 16:56:57');";
	
	dbDelta( $dataforformgroups );
	
	$dataforformfields = "INSERT INTO {$form_fields_table} (`id`, `form_group_id`, `form_label`, `form_name`, `dateadded`, `sort`, `required`) VALUES
	(1, 1, 'First Name', 'FIRST NAME', '2017-08-30 09:08:59', 1, 1),
	(2, 1, 'Last Name', 'LAST NAME', '2017-08-30 09:08:59', 2, 1),
	(3, 1, 'Email', 'EMAIL', '2017-08-30 09:08:59', 3, 1),
	(4, 1, 'Phone', 'PHONE', '2017-08-30 09:08:59', 4, 0),
	(5, 1, 'Institution', 'INSTITUTION', '2017-08-30 09:08:59', 5, 0),
	(6, 1, 'If Institution is not in the list, please write Institution here', 'INSTITUTION (MANUAL INPUT)', '2017-08-30 09:08:59', 6, 0),
	(7, 1, 'Information/Question', 'QUESTION', '2017-08-30 09:08:59', 7, 0),
	(8, 2, 'First Name', 'FIRST NAME', '2017-09-05 11:46:09', 1, 1),
	(9, 2, 'Last Name', 'LAST NAME', '2017-09-05 11:46:09', 2, 1),
	(10, 2, 'Email', 'EMAIL', '2017-09-05 11:46:09', 3, 1),
	(11, 2, 'Phone', 'PHONE', '2017-09-05 11:46:09', 4, 0),
	(12, 2, 'Gender', 'GENDER', '2017-09-05 11:46:09', 5, 0),
	(13, 2, 'Preferred Name', 'PREFERRED NAME', '2017-09-05 11:46:09', 6, 0),
	(14, 2, 'Birth Date', 'BIRTH DATE', '2017-09-05 11:46:09', 7, 0),
	(15, 2, 'Alternative Email', 'ALTERNATE EMAIL', '2017-09-05 11:46:09', 8, 0),
	(16, 2, 'Mobile', 'MOBILE PHONE', '2017-09-05 11:46:09', 9, 0),
	(17, 2, 'Address 1', 'ADDRESS 1', '2017-09-05 11:46:09', 10, 0),
	(18, 2, 'Address 2', 'ADDRESS 2', '2017-09-05 11:46:09', 11, 0),
	(19, 2, 'State', 'STATE', '2017-09-05 11:46:09', 12, 0),
	(20, 2, 'City', 'CITY', '2017-09-05 11:46:09', 13, 0),
	(21, 2, 'Country', 'COUNTRY', '2017-09-05 11:46:09', 14, 0),
	(22, 2, 'Institution', 'INSTITUTION', '2017-09-05 11:46:09', 15, 0),
	(23, 2, 'Enter institution name if not in list above', 'INSTITUTION (MANUAL INPUT)', '2017-09-05 11:46:09', 16, 0),
	(24, 2, 'Current Year in School', 'CURRENT YEAR IN SCHOOL', '2017-09-05 11:46:09', 17, 0),
	(25, 2, 'Major 1', 'MAJOR 1', '2017-09-05 11:46:09', 18, 0),
	(26, 2, 'Major 2', 'MAJOR 2', '2017-09-05 11:46:09', 19, 0),
	(27, 2, 'Minor', 'MINOR', '2017-09-05 11:46:09', 20, 0),
	(28, 2, 'GPA', 'GPA', '2017-09-05 11:46:09', 21, 0),
	(29, 2, 'Program Type', 'PROGRAM TYPE', '2017-09-05 11:46:09', 22, 0),
	(30, 2, 'Program of Interest 1', 'PROGRAM OF INTEREST 1', '2017-09-05 11:46:09', 23, 0),
	(31, 2, 'Program of Interest 2', 'PROGRAM OF INTEREST 2', '2017-09-05 11:46:09', 24, 0),
	(32, 2, 'Program of Interest 3', 'PROGRAM OF INTEREST 3', '2017-09-05 11:46:09', 25, 0),
	(33, 2, 'Field of Interest 1', 'FIELD OF INTEREST 1', '2017-09-05 11:46:09', 26, 0),
	(34, 2, 'Field of Interest 2', 'FIELD OF INTEREST 2', '2017-09-05 11:46:09', 27, 0),
	(35, 2, 'Anticipated Travel Date', 'ANTICIPATED TRAVEL DATE', '2017-09-05 11:46:09', 28, 0),
	(36, 2, 'Desired Semester', 'DESIRED SEMESTER', '2017-09-05 11:46:09', 29, 0),
	(37, 2, 'Duration', 'NUMBER OF WEEKS', '2017-09-05 11:46:09', 30, 0),
	(38, 2, 'Are you using financial aid?', 'IS USING FINANCIAL AID', '2017-09-05 11:46:09', 31, 0),
	(39, 2, 'Were you referred by a friend?', 'REFERRED FROM FRIEND', '2017-09-05 11:46:09', 32, 0),
	(40, 2, 'Friend\'s Name', 'REFERRED FROM FRIEND NAME', '2017-09-05 11:46:09', 33, 0),
	(41, 2, 'Applying For Scholarship or Grant', 'ARE YOU APPLYING FOR A SCHOLARSHIP OR GRANT', '2017-09-05 11:46:09', 34, 0),
	(42, 2, 'Additional Comment', 'ADDITIONAL COMMENT', '2017-09-05 11:46:09', 35, 0),
	(43, 2, 'Lead Source', 'LEAD SOURCE', '2017-09-05 11:46:09', 36, 0),
	(44, 2, 'Lead Source Detail', 'LEAD SOURCE DETAIL', '2017-09-05 11:46:09', 37, 0),
	(45, 2, 'Terms and Conditions', 'HAS ACCEPTED TERMS', '2017-09-05 11:46:09', 38, 0);";
	
	dbDelta( $dataforformfields );
	
	$dataforgocrmsettings = "INSERT INTO {$crm_setting} (`id`, `option`, `value`) VALUES
	(1, 'ApiUsername', ''),
	(2, 'ApiKey', ''),
	(3, 'ApiOrgId', '');	";
	
	dbDelta( $dataforgocrmsettings );

	add_option( 'hqcrm', $hqcrm );
}

function gocrm_update_db_check() { 
	global $wpdb; 
	$fg = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."gocrm_settings WHERE `option` = 'HqVersion'");
	foreach ($fg  as $v) { 
	$val = $v->value;
	}
	if (empty($val)) { 
	$wpdb->insert($wpdb->prefix."gocrm_settings", array("option" => 'HqVersion', "value" => '1.6.2'));
	$wpdb->insert($wpdb->prefix."gocrm_settings", array("option" => 'Status', "value" => 'Live'));
	}
}
function get_gocrm_hq_status() { 
	if (get_gocrm_settings("Status")=='Staging') { 
		return 'https://staging-api.goabroadhq.com';
	} else { 
		return 'https://hq-api.goabroadhq.com';
	}
}
function gocrm_add_form_group($groupname, $form_type) { 
	global $wpdb; 
	$wpdb->insert($wpdb->prefix."gocrm_form_group", array("group_name" => $groupname, "form_type" => $form_type, "status" => "1"));
	$lastid = $wpdb->insert_id;
	return $lastid;
}
function gocrm_add_forms_fields($groupid, $formlabel, $formname, $order, $required) { 
	global $wpdb; 
	if ($wpdb->insert($wpdb->prefix."gocrm_form_fields", array("form_group_id" => $groupid, "form_label" => $formlabel, "form_name" => $formname, "sort" => $order, "required" => $required))) {
	return true;
	} else { 
	return false;
	}
}

function get_hq_fields($selected="") { 
	$availablefields = getgocrm_available_lead_fields();
	$availablefields2 = getgocrm_available_part_fields();
	$optionv = '<option value="" selected="selected">--Please Select--</option>';
	$optionv = $optionv. '<optgroup class="leads" label="LEAD FIELDS">';
	foreach ($availablefields  as $v) { 
		if ($selected==$v) {
		$optionv = $optionv . '<option value="'.$v.'" selected="selected">'.$v.'</option>';
		} else { 
		$optionv = $optionv . '<option value="'.$v.'">'.$v.'</option>';
		}
	}
	$optionv = $optionv. '</optgroup>';
	$optionv = $optionv. '<optgroup class="participants" label="PARTICIPANTS FIELDS" hidden>';
	foreach ($availablefields2  as $v2) { 
		if ($selected==$v) {
		$optionv = $optionv . '<option value="'.$v2.'" selected="selected">'.$v2.'</option>';
		} else { 
		$optionv = $optionv . '<option value="'.$v2.'">'.$v2.'</option>';
		}
	}
	$optionv = $optionv. '</optgroup>';
	return $optionv;
}

function get_hq_fields_type($ftype, $selected="") {
	$availablefields = getgocrm_available_lead_fields();
	$availablefields2 = getgocrm_available_part_fields();
	if (empty($selected)) { 
	$optionv = '<option value="" selected="selected">--Please Select--</option>';
	} else { 
	$optionv = '<option value="" >--Please Select--</option>';
	}
	if ($ftype=="participants") {
		$optionv = $optionv. '<optgroup class="participants" label="PARTICIPANTS FIELDS" >';
		foreach ($availablefields2  as $v2) { 
			if ($selected==$v2) {
			$optionv = $optionv . '<option value="'.$v2.'" selected="selected">'.$v2.'</option>';
			} else { 
			$optionv = $optionv . '<option value="'.$v2.'">'.$v2.'</option>';
			}
		}
		$optionv = $optionv. '</optgroup>';
	} elseif ($ftype=="leads") { 
		$optionv = $optionv. '<optgroup class="leads" label="LEAD FIELDS">';
		foreach ($availablefields  as $v) { 
			if ($selected==$v) {
			$optionv = $optionv . '<option value="'.$v.'" selected="selected">'.$v.'</option>';
			} else { 
			$optionv = $optionv . '<option value="'.$v.'">'.$v.'</option>';
			}
		}
		$optionv = $optionv. '</optgroup>';
	}
	return $optionv;
} 

function getgocrm_available_lead_fields() { 
	$leads = wp_remote_get(plugin_dir_url(__FILE__) ."leads.json");
	$availablefields = json_decode(wp_remote_retrieve_body($leads));
	return $availablefields;
}
function getgocrm_available_part_fields() { 
	$participants = wp_remote_get(plugin_dir_url(__FILE__) ."participants.json"); 
	$availablefields = json_decode(wp_remote_retrieve_body($participants));
	return $availablefields;
}
function getgocrm_available_selection() { 
	$references = wp_remote_get("https://api.goabroadhq.com/API/GoAbroadHQ.svc/References?userName=".get_gocrm_settings("ApiUsername")."&password=".get_gocrm_settings("ApiKey")."");
	//$references = wp_remote_get(plugin_dir_url(__FILE__) ."references.xml"); 
	$ref_xml = new SimpleXMLElement(wp_remote_retrieve_body($references),  LIBXML_NOCDATA);
	$availablefields2 = simplexml_load_string($ref_xml->asXML());
	return $availablefields2;
}

function gocrmupdate_settings($ApiUsername, $ApiKey, $ApiOrgId, $Status) { 
	global $wpdb; 
	$gocrmstable = $wpdb->prefix."gocrm_settings";
	$wpdb->query($wpdb->prepare("UPDATE {$gocrmstable} SET value = '%s' WHERE `option` = 'ApiUsername'", $ApiUsername)); 
	$wpdb->query($wpdb->prepare("UPDATE {$gocrmstable} SET value = '%s' WHERE `option` = 'ApiKey'",$ApiKey) ); 
	$wpdb->query($wpdb->prepare("UPDATE {$gocrmstable} SET value = '%s' WHERE `option` = 'ApiOrgId'",$ApiOrgId) ); 
	$wpdb->query($wpdb->prepare("UPDATE {$gocrmstable} SET value = '%s' WHERE `option` = 'Status'",$Status) ); 
	return true;
}
function get_gocrm_settings($option) { 
	global $wpdb; 
	$fg = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."gocrm_settings WHERE `option` = '".$option."'");
	foreach ($fg  as $v) { 
	return $v->value;
	}
}

function gocrm_create_form($form_name, $form_type, $required, $form_select_match="") { 
	if ($required=="1") { 
		$req = 'required';
	} 
	
	if ($form_type=="text") { 
		return '<input type="text" name="'.$form_name.'" '.$req.'/>';
	} elseif ($form_type=="checkbox") { 
		return '<input type="checkbox" name="'.$form_name.'" '.$req.'/>';
	} elseif ($form_type=="textarea") { 
		return '<textarea name="'.$form_name.'" '.$req.'></textarea>';
	} elseif ($form_type=="select") { 
		$availablefields = getgocrm_available_selection();
		$i=1;
		foreach ($availablefields  as $k => $v) { 
			if ($k==$form_select_match) {
				$return = '<select name="'.$form_name.'" '.$req.'>';
				if ($form_name=="CURRENT YEAR IN SCHOOL") { 
				$return = $return . "<option value='Unsure'>--Unsure--</option>";
				}
				foreach ($v as $nk => $nv) { 
					$return = $return . '<option value="'.$nv->attributes()->Id.'" >'.$nv[0].'</option>';
				} 
				$return = $return .'</select>';
				$i++;
			}
		}
		return $return;
	}
}
function getgohqcrm_api_token() { 
	$url = get_gocrm_hq_status()."/token";
	$response = wp_remote_post( $url, array(
		'method' => 'POST',
		'timeout' => 45,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking' => true,
		'headers' => array(),
		'body' => array( 'client_id' => ''.get_gocrm_settings("ApiUsername").'', 'client_secret' => ''.get_gocrm_settings("ApiKey").'', 'grant_type' => 'client_credentials' ),
		'cookies' => array()
		)
	);
	$tokenget_r = json_decode($response['body']);
	return $tokenget_r->access_token;
}

function gocrmforms($atts) { 
	return gocrm_selectforms($atts['formname']);
}
function gocrm_delete_record($id) { 
	global $wpdb; 
	$wpdb->delete($wpdb->prefix."gocrm_form_group", array('id'=> $id));
	$wpdb->delete($wpdb->prefix."gocrm_form_fields", array('form_group_id'=> $id));
	return true;
}
function gocrm_copy_record($id) { 
	global $wpdb; 
	$wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}gocrm_form_group (`group_name`, `status`, `form_type`) SELECT concat(`group_name`, ' Copy') as group_name, `status`, `form_type` FROM {$wpdb->prefix}gocrm_form_group WHERE id = '%s'", $id)); 
	$lastid = $wpdb->insert_id;
	$wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}gocrm_form_fields (`form_group_id`, `form_label`, `form_name`, `sort`, `required`) SELECT %s, `form_label`, `form_name`, `sort`, `required` FROM {$wpdb->prefix}gocrm_form_fields WHERE form_group_id = '%s'", $lastid, $id)); 
	return true;
	
}
function gocrm_submitlogs() { 
	global $wpdb; 
	$fg = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."gocrm_submit_log ORDER BY ID DESC LIMIT 50");
	return $fg;
}

function gocrm_log_form($jsonencoded) {  
	global $wpdb; 
	$log = $wpdb->insert($wpdb->prefix.'gocrm_submit_log', array(
		'json_data' => $jsonencoded,
		'ip_from' => $_SERVER['REMOTE_ADDR'],
		'dateadded' => date('Y-m-d h:i:s', time())
	));
	if ($log) {
	return true;	
	} else { 
	return false;	
	}
}
function gocrm_send_form($jsonencoded, $gtype) { 
	$url = get_gocrm_hq_status()."/organizations/".get_gocrm_settings("ApiOrgId")."/".$gtype."/import";
	$jsondata = stripslashes($jsonencoded);
	if (gocrm_log_form($jsonencoded)) {
	$response = wp_remote_post( $url, array(
		'method' => 'POST',
		'timeout' => 45,
		'redirection' => 5,
		'httpversion' => '1.1',
		'blocking' => true,
		'headers' => array( 'Content-Type' => 'application/json', 'Accept' => 'text/html', 'Authorization' => 'Bearer '.getgohqcrm_api_token() ),
		'body' => $jsondata,
		'cookies' => array()
		)
	);
	$send_reponse = json_decode($response['body']);
	return true;
	} else { 
	return false;
	}
}
function gocrm_delete_field(){
      global $wpdb;
      //$wpdb->delete($wpdb->prefix."gocrm_form_fields", array('id'=> $_POST[ 'id' ])); // DISABLED
      exit(); //prevent 0 in the return
}
function gocrm_update_field(){
      global $wpdb;	  
	  $wpdb->update($wpdb->prefix."gocrm_form_fields", array('form_label'=> sanitize_text_field($_POST['form_label']), 'form_name'=> sanitize_text_field($_POST['form_name']), 'sort'=> $_POST['sort'], 'required'=> sanitize_text_field($_POST['required'])), array('id' => sanitize_text_field($_POST['id'])));
	exit();
}
function gocrm_update_formname(){
      global $wpdb;	  
	  $wpdb->update($wpdb->prefix."gocrm_form_group", array('group_name'=> sanitize_text_field($_POST['formgroup'])), array('id' => sanitize_text_field($_POST['form_group_id'])));
	exit();
}
function gocrm_add_field() { 
	gocrm_add_forms_fields(sanitize_text_field($_POST['form_group_id']), sanitize_text_field($_POST['form_label']), sanitize_text_field($_POST['form_name']), sanitize_text_field($_POST['sort']), sanitize_text_field($_POST['required']));
}
function removegocrm() {
     global $wpdb;
    $crm_setting = $wpdb->prefix . 'gocrm_settings';
	$form_group_table = $wpdb->prefix . 'gocrm_form_group';
	$form_fields_table = $wpdb->prefix . 'gocrm_form_fields';
	$gocrm_form_types = $wpdb->prefix . 'gocrm_form_types';
	$form_submit_table = $wpdb->prefix . 'gocrm_submit_log';
     $sql = "DROP TABLE IF EXISTS $crm_setting,$form_group_table,$form_fields_table,$gocrm_form_types,$form_submit_table";
     $wpdb->query($sql);
     delete_option($hqcrm);
}  