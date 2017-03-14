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
		$i10n_months['fr_FR'] = array( 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre' );
		$i10n_months['it_IT'] = array( 'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre' );
		$i10n_months['da_DK'] = array( 'Januar', 'Februar', 'Marts', 'April', 'Maj', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'December' );
		$i10n_months['es_ES'] = array( 'Enero ', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' );
		$i10n_months['ja']    = array( '1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月' );
		$i10n_months['nl_NL'] = array( 'Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December' );
		$i10n_months['pl_PL'] = array( 'Stycznia', 'Lutego', 'Marca', 'Kwietnia', 'Maja', 'Czerwca', 'Lipca', 'Sierpnia', 'Września', 'Października', 'Listopada', 'Grudnia' );
		$i10n_months['pt_BR'] = array( 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro' );
		$i10n_months['pt_PT'] = array( 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro' );
		$i10n_months['tr_TR'] = array( 'Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık' );
		$i10n_months['zh_TW'] = array( '一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月' );

		return apply_filters( 'timeline_express_i10n_months', $i10n_months );

	}
}
