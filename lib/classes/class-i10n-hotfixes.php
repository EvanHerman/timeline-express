<?php
/**
 * Hotfixes for i10n dates
 *
 * @since 1.4.0
 */
class I10n_Hotfixes {

	/**
	 * Month name hotfix
	 *
	 * @param  string $date Date to hotfix
	 *
	 * @return string       Patched date
	 *
	 * @since 1.4.0
	 */
	public function month_name( $date ) {

		include_once( TIMELINE_EXPRESS_PATH . '/lib/classes/hotfixes/class-timeline-express-month-hotfix.php' );

		$month_hotfix = new Timeline_Express_Month_Hotfix( $date );

		return $month_hotfix->hotfix_month_name();

	}

}
