<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Defined styling areas for the theme style feature
 * Those string are not translated to keep the language file neat
 * @param  string $type
 * @return array
 */
function get_styling_areas($type = 'admin')
{
    $areas = array(
        'admin' => array(
            array(
                'name' => 'Sidebar Menu/Setup Menu Background Color',
                'id' => 'admin-menu',
                'target' => '.admin #side-menu,.admin #setup-menu',
                'css' => 'background',
                'additional_selectors' => 'body|background+#setup-menu-wrapper|background'
            ),
            array(
                'name' => 'Sidebar Menu/Setup Menu Submenu Open Background Color',
                'id' => 'admin-menu-submenu-open',
                'target' => '.admin #side-menu li .nav-second-level li,.admin #setup-menu li .nav-second-level li',
                'css' => 'background',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Sidebar Menu/Setup Menu Links Color',
                'id' => 'admin-menu-links',
                'target' => '.admin #side-menu li a,.admin #setup-menu li a',
                'css' => 'color',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Sidebar Menu User Welcome Text Color',
                'id' => 'user-welcome-text-color',
                'target' => '#side-menu li.dashboard_user',
                'css' => 'color',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Sidebar Menu/Setup Active Item Background Color',
                'id' => 'admin-menu-active-item',
                'target' => '
                .admin #side-menu li.active > a,
                .admin #setup-menu li.active > a,
                #side-menu.nav > li > a:hover,
                #side-menu.nav > li > a:focus,
                #setup-menu > li > a:hover,
                #setup-menu > li > a:focus',
                'css' => 'background',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Sidebar Menu/Setup Active Item Color',
                'id' => 'admin-menu-active-item-color',
                'target' => '
                .admin #side-menu li.active > a,
                .admin #setup-menu li.active > a',
                'css' => 'color',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Sidebar Menu/Setup Active Subitem Background Color',
                'id' => 'admin-menu-active-subitem',
                'target' => '.admin #side-menu li .nav-second-level li.active a,.admin #setup-menu li .nav-second-level li.active a',
                'css' => 'background',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Sidebar Menu/Setup Submenu links color',
                'id' => 'admin-menu-submenu-links',
                'target' => '.admin #side-menu li .nav-second-level li a,#setup-menu li .nav-second-level li a',
                'css' => 'color',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Top Header Background Color',
                'id' => 'top-header',
                'target' => '.admin #header',
                'css' => 'background-color',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Top Header Links Color',
                'id' => 'top-header-links',
                'target' => '.admin .navbar-nav > li > a, ul.mobile-icon-menu>li>a,.mobile-menu-toggle, .open-customizer-mobile',
                'css' => 'color',
                'additional_selectors' => ''
            ),
        ),
        'customers' => array(
            array(
                'name' => 'Navigation Background Color',
                'id' => 'customers-navigation',
                'target' => '.customers .navbar-default',
                'css' => 'background-color',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Navigation Links Color',
                'id' => 'customers-navigation-links',
                'target' => '.customers .navbar-default .navbar-nav>li>a',
                'css' => 'color',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Invoice/Estimate HTML View Top Header Background Color',
                'id' => 'html-view-top-header',
                'target' => '.viewinvoice .page-pdf-html-logo,.viewestimate .page-pdf-html-logo',
                'css' => 'background',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Proposal view (right side background color)',
                'id' => 'proposal-view',
                'target' => '.proposal-view .proposal-right',
                'css' => 'background',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Footer Background',
                'id' => 'customers-footer-background',
                'target' => '.customers footer',
                'css' => 'background',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Footer Text Color',
                'id' => 'customers-footer-text',
                'target' => '.customers footer',
                'css' => 'color',
                'additional_selectors' => ''
            )
        ),
        'general' => array(
            array(
                'name' => '<a href="#" onclick="return false;">Links</a> Color (href)',
                'id' => 'links-color',
                'target' => 'a',
                'css' => 'color',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Links Hover/Focus Color',
                'id' => 'links-hover-focus',
                'target' => 'a:hover,a:focus',
                'css' => 'color',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Table Headings Color',
                'id' => 'table-headings',
                'target' => 'table.dataTable thead tr>th, .table.dataTable>thead:first-child>tr:first-child>th',
                'css' => 'color',
                'additional_selectors' => '',
                'example' => '<table class="table dataTable"><thead><tr><th style="border-bottom: 1px solid #f0f0f0" class="sorting">Example Heading 1</th><th style="border-bottom: 1px solid #f0f0f0" class="sorting">Example Heading 2</th></tr></thead></table>'
            ),
            array(
                'name' => 'Items Table Headings Background Color',
                'id' => 'table-items-heading',
                'target' => '.table.items thead',
                'css' => 'background',
                'additional_selectors' => '',
                'example' => '<table class="table items"><thead><tr><th>Example Heading 1</th><th>Example Heading 2</th></tr></thead></table>'
            ),
            array(
                'name' => 'Admin Login Background',
                'id' => 'admin-login-background',
                'target' => 'body.login_admin',
                'css' => 'background',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Text Muted',
                'id' => 'text-muted',
                'target' => '.text-muted',
                'css' => 'color',
                'additional_selectors' => '',
                'example' => '<p>Example <span class="bold text-muted">text muted</span></p>'
            ),
            array(
                'name' => 'Text Danger',
                'id' => 'text-danger',
                'target' => '.text-danger',
                'css' => 'color',
                'additional_selectors' => '',
                'example' => '<p>Example <span class="bold text-danger">text danger</span></p>'
            ),
            array(
                'name' => 'Text Warning',
                'id' => 'text-warning',
                'target' => '.text-warning',
                'css' => 'color',
                'additional_selectors' => '',
                'example' => '<p>Example <span class="bold text-warning">text warning</span></p>'
            ),
            array(
                'name' => 'Text Info',
                'id' => 'text-info',
                'target' => '.text-info',
                'css' => 'color',
                'additional_selectors' => '',
                'example' => '<p>Example <span class="bold text-info">text info</span></p>'
            ),
            array(
                'name' => 'Text Success',
                'id' => 'text-success',
                'target' => '.text-success',
                'css' => 'color',
                'additional_selectors' => '',
                'example' => '<p>Example <span class="bold text-success">text success</span></p>'
            )
        ),
        'tabs' => array(
            array(
                'name' => 'Tabs Background Color',
                'id' => 'tabs-bg',
                'target' => '.nav-tabs',
                'css' => 'background',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Tabs Links Color',
                'id' => 'tabs-links',
                'target' => '.nav-tabs>li>a',
                'css' => 'color',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Tabs Link Active/Hover Color',
                'id' => 'tabs-links-active-hover',
                'target' => '.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover, .nav-tabs>li>a:focus, .nav-tabs>li>a:hover',
                'css' => 'color',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Tabs Border Color',
                'id' => 'tabs-border',
                'target' => '.nav-tabs',
                'css' => 'border-color',
                'additional_selectors' => '.navbar-pills.nav-tabs>li>a:focus,.navbar-pills.nav-tabs>li>a:hover|border-color'
            ),
            array(
                'name' => 'Tabs Active Border Color',
                'id' => 'tabs-active-border',
                'target' => '.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover, .nav-tabs>li>a:focus, .nav-tabs>li>a:hover',
                'css' => 'border-bottom-color',
                'additional_selectors' => ''
            )
        ),
        'modals' => array(
            array(
                'name' => 'Heading Background',
                'id' => 'modal-heading',
                'target' => '.modal-header',
                'css' => 'background',
                'additional_selectors' => ''
            ),
            array(
                'name' => 'Heading Color',
                'id' => 'modal-heading-color',
                'target' => '.modal-header .modal-title',
                'css' => 'color',
                'additional_selectors' => ''
            )
        ),
        'buttons' => array(
            array(
                'name' => 'Button Default',
                'id' => 'btn-default',
                'target' => '.btn-default',
                'css' => 'background-color',
                'additional_selectors' => '.btn-default|border-color',
                'example' => '<button type="button" class="btn btn-default">Button Default</button>'
            ),
            array(
                'name' => 'Button Info',
                'id' => 'btn-info',
                'target' => '.btn-info',
                'css' => 'background-color',
                'additional_selectors' => '.btn-info|border-color',
                'example' => '<button type="button" class="btn btn-info">Button Info</button>'
            ),
            array(
                'name' => 'Button Success',
                'id' => 'btn-success',
                'target' => '.btn-success',
                'css' => 'background-color',
                'additional_selectors' => '.btn-success|border-color',
                'example' => '<button type="button" class="btn btn-success">Button Success</button>'
            ),
            array(
                'name' => 'Button Danger',
                'id' => 'btn-danger',
                'target' => '.btn-danger',
                'css' => 'background-color',
                'additional_selectors' => '.btn-danger|border-color',
                'example' => '<button type="button" class="btn btn-danger">Button Danger</button>'
            )
        )
    );
	return $areas;
}