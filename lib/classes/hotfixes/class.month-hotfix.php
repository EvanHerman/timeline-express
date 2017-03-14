<?php
/**
 * Month Name Hotfixes for i10n dates
 *
 * Notes: This class wll fix dates in F j, Y format on i10n sites.
 *        strtotime() is used to create the dates in the database,
 *        but does not work with internatinal languages. This class
 *        replaces known i10n month names back to english to strtotime works.
 *
 * @since 1.4.0
 */
class Timeline_Express_Month_Hotfix {

	public $date;

	public $en_months;

	public function __construct( $date ) {

		$this->date        = $date;
		$this->en_months   = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
		$this->i10n_months = $this->get_i10n_months();

	}

	/**
	 * Hotfix the date names
	 *
	 * @param  array $i10n_months Array of translated month names
	 *
	 * @return string             Format
	 */
	public function hotfix_month_name() {

		if ( ! isset( $this->i10n_months[ get_locale() ] ) ) {

			return $this->date;

		}

		foreach ( $this->i10n_months[ get_locale() ] as $key => $month ) {

			$this->date = str_replace( $month, $this->en_months[ $key ], $this->date );

		}

		return $this->date;

	}

	/**
	 * Return the array of i10n month translations
	 *
	 * @uses   timeline_express_i10n_months
	 * @return array
	 *
	 * @since 1.4.0
	 */
	public function get_i10n_months() {

		$i10n_months = array();

		$i10n_months['de_DE'] = array( 'Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember' );

		return apply_filters( 'timeline_express_i10n_months', $i10n_months );

	}
}
