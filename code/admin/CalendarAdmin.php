<?php
/**
 * Calendar Admin
 *
 * @package calendar
 * @subpackage admin
 */
class CalendarAdmin extends LeftAndMain implements PermissionProvider {

	static $menu_title = "Events";
	static $url_segment = "calendar";
	static $menu_icon = "calendar/images/icons/calendar.png";

	private static $allowed_actions = array(
		'pastevents',
		'calendars',
		'ComingEventsForm',
		'PastEventsForm',
		'CalendarsForm',
		'CategoriesForm',
		'categories'
	);

	public function init() {
		parent::init();


		//CSS/JS Dependencies - currently not much there
		Requirements::css("calendar/css/admin/CalendarAdmin.css");
		Requirements::javascript("calendar/javascript/admin/CalendarAdmin.js");
	}

	public function ComingEventsForm(){
		$form = new ComingEventsForm($this, "ComingEventsForm");
		$form->addExtraClass('cms-edit-form cms-panel-padded center ' . $this->BaseCSSClasses());
		return $form;
	}
	public function PastEventsForm(){
		$form = new PastEventsForm($this, "PastEventsForm");
		$form->addExtraClass('cms-edit-form cms-panel-padded center ' . $this->BaseCSSClasses());
		return $form;
	}
	public function CalendarsForm(){
		$form = new CalendarsForm($this, "CalendarsForm");
		$form->addExtraClass('cms-edit-form cms-panel-padded center ' . $this->BaseCSSClasses());
		return $form;
	}
	public function CategoriesForm(){
		$form = new CategoriesForm($this, "CategoriesForm");
		$form->addExtraClass('cms-edit-form cms-panel-padded center ' . $this->BaseCSSClasses());
		return $form;
	}



	public function SubTitle(){
		$str = 'Coming Events';
		$a = $this->Action;
		if ($a == 'pastevents') {
			$str = 'Past Events';
		}
		if ($a == 'calendars') {
			$str = 'Calendars';
		}
		if ($a == 'categories') {
			$str = 'Categories';
		}
		return $str;
	}

	public function CalendarsEnabled(){
		return CalendarConfig::subpackage_enabled('calendars');
	}
	public function CategoriesEnabled(){
		return CalendarConfig::subpackage_enabled('categories');
	}



	/**
	 * Action "pastevents"
	 * @param type $request
	 * @return SS_HTTPResponse
	 */
	public function pastevents($request) {
		return $this->getResponseNegotiator()->respond($request);
	}

	/**
	 * Action "calendars"
	 * @param type $request
	 * @return SS_HTTPResponse
	 */
	public function calendars($request) {
		if ($this->CalendarsEnabled()) {
			return $this->getResponseNegotiator()->respond($request);
		}
	}

	/**
	 * Action "categories"
	 * @param type $request
	 * @return SS_HTTPResponse
	 */
	public function categories($request) {
		if ($this->CategoriesEnabled()) {
			return $this->getResponseNegotiator()->respond($request);
		}
	}

	public function canCreate($member = null) {
		return Permission::check('EVENT_CREATE');
	}
	public function canEdit($member = null) {
		return Permission::check('EVENT_EDIT');
	}
	public function canDelete($member = null) {
		return Permission::check('EVENT_DELETE');
	}
	public function canView($member = null) {
		return Permission::check('CMS_ACCESS_EventAdmin');
	}

	/**
	 * Get an array of {@link Permission} definitions that this object supports
	 *
	 * @return array
	 */
	public function providePermissions() {
		return array(
			'CMS_ACCESS_EventAdmin' => array(
				'name' => "Access to 'Events' section",
				'category' => 'CMS Access'
			),
			'EVENT_VIEW' => array(
				'name' => 'View events',
				'category' => 'Events',
			),
			'EVENT_EDIT' => array(
				'name' => 'Edit events',
				'category' => 'Events',
			),
			'EVENT_DELETE' => array(
				'name' => 'Delete events',
				'category' => 'Events',
			),
			'EVENT_CREATE' => array(
				'name' => 'Create events',
				'category' => 'Events'
			)
		);
	}
}
