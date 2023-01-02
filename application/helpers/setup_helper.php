<?php
/*
Setup
*/

function setup_tabs(){
	$tabs = array(
		array(
		"title" => "Staff",
		"slug" => "users",
		"url" => "users"
		),
		array(
		"title" => "Support",
		"slug" => "support",
		"url" => "departments"
		),
		array(
		"title" => "Finance",
		"slug" => "finance",
		"url" => "taxes"
		),
		array(
		"title" => "Custom Fields",
		"slug" => "customfield",
		"url" => "customfield"
		),
		array(
		"title" => "Roles",
		"slug" => "groups",
		"url" => "groups"
		),
		array(
		"title" => "Theme Setup",
		"slug" => "settings",
		"url" => "settings"
		),
		array(
		"title" => "Menu Setup",
		"slug" => "menus_setting",
		"url" => "settings/menus"
		)
	);
	return $tabs;
}

/* Finace Tabs */
function finance_tabs(){
	$tabs = array(
		array(
		"title" => "Taxes",
		"slug" => "taxes"
		),
		array(
		"title" => "Currencies",
		"slug" => "currencies"
		),
		array(
		"title" => "Payment Modes",
		"slug" => "payment_mode"
		),
		array(
		"title" => "Expense Categories",
		"slug" => "categories"
		)
	);
	return $tabs;
}

/*
Finance Tabs HTML
*/
function finance_tabs_html($currenttab = '') {		
		$result =  '<ul class="nav nav-tabs">';
		foreach(finance_tabs() as $tabs){
			$active_class = ($currenttab == $tabs['slug'])?'active':'';
			$result .= '<li class="'.$active_class.'"><a href="'.base_url().$tabs['slug'].'/" class="tabs_heading">'.$tabs['title'].'</a></li>';
		}			
		$result .= '</ul>';
		return $result;
}


/* Support Tabs */
function support_tabs(){
	$tabs = array(
		array(
		"title" => "Departments",
		"slug" => "departments"
		),
		array(
		"title" => "Predefined Replies",
		"slug" => "predefined_replies"
		),
		array(
		"title" => "Ticket Priorities",
		"slug" => "priorities"
		),
		array(
		"title" => "Ticket Statuses",
		"slug" => "statuses"
		),
		array(
		"title" => "Servies",
		"slug" => "services"
		),
		array(
		"title" => "Spam Filters",
		"slug" => "spam_filters"
		)
	);
	return $tabs;
}

/*
Support Tabs HTML
*/
function support_tabs_html($currenttab = '') {		
		$result =  '<ul class="nav nav-tabs">';
		foreach(support_tabs() as $tabs){
			$active_class = ($currenttab == $tabs['slug'])?'active':'';
			$result .= '<li class="'.$active_class.'"><a href="'.base_url().$tabs['slug'].'/" class="tabs_heading">'.$tabs['title'].'</a></li>';
		}			
		$result .= '</ul>';
		return $result;
}

/* Theme setup Tabs */
function theme_setup_tabs(){
	$tabs = array(
		array(
			"title" => "General",
			"slug" => "settings"
		),
		array(
			"title" => "Tags",
			"slug" => "settings/tags"
		),
		array(
			"title" => "Email",
			"slug" => "settings/email"
		),		
	);
	return $tabs;
}

/*
Support Tabs HTML
*/
function theme_setup_tabs_html($currenttab = '') {		
		$result =  '<ul class="nav nav-tabs">';
		foreach(theme_setup_tabs() as $tabs){
			$active_class = ($currenttab == $tabs['slug'])?'active':'';
			$result .= '<li class="'.$active_class.'"><a href="'.base_url().$tabs['slug'].'/" class="tabs_heading">'.$tabs['title'].'</a></li>';
		}			
		$result .= '</ul>';
		return $result;
}

?>