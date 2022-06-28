<?php
/* * * * * * * * * * * * * * * * * * * * *
 *
 *  ██████╗ ███╗   ███╗ ██████╗ ███████╗
 * ██╔═══██╗████╗ ████║██╔════╝ ██╔════╝
 * ██║   ██║██╔████╔██║██║  ███╗█████╗
 * ██║   ██║██║╚██╔╝██║██║   ██║██╔══╝
 * ╚██████╔╝██║ ╚═╝ ██║╚██████╔╝██║
 *  ╚═════╝ ╚═╝     ╚═╝ ╚═════╝ ╚═╝
 *
 * @package  : OMGF
 * @author   : Daan van den Bergh
 * @copyright: © 2022 Daan van den Bergh
 * @url      : https://daan.dev
 * * * * * * * * * * * * * * * * * * * */

defined('ABSPATH') || exit;

class OMGF_Admin_Settings_Advanced extends OMGF_Admin_Settings_Builder
{
	/**
	 * OMGF_Admin_Settings_Advanced constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->title = __('Advanced Settings', $this->plugin_text_domain);

		// Open
		add_filter('omgf_advanced_settings_content', [$this, 'do_title'], 10);
		add_filter('omgf_advanced_settings_content', [$this, 'do_description'], 15);
		add_filter('omgf_advanced_settings_content', [$this, 'do_before'], 20);

		// Settings
		add_filter('omgf_advanced_settings_content', [$this, 'do_cache_dir'], 50);
		add_filter('omgf_advanced_settings_content', [$this, 'do_promo_fonts_source_url'], 60);
		add_filter('omgf_advanced_settings_content', [$this, 'do_compatibility'], 70);
		add_filter('omgf_advanced_settings_content', [$this, 'do_uninstall'], 100);

		// Close
		add_filter('omgf_advanced_settings_content', [$this, 'do_after'], 200);
	}

	/**
	 * Description
	 */
	public function do_description()
	{
?>
		<p>
			<?= __('Use these settings to make OMGF work with your specific configuration.', $this->plugin_text_domain); ?>
		</p>
	<?php
	}

	/**
	 *
	 */
	public function do_cache_dir()
	{
	?>
		<tr>
			<th scope="row"><?= __('Fonts Cache Directory', $this->plugin_text_domain); ?></th>
			<td>
				<p class="description">
					<?= sprintf(__('Downloaded stylesheets and font files %s are stored in: <code>%s</code>.', $this->plugin_text_domain), is_multisite() ? __('(for this site)', $this->plugin_text_domain) : '', str_replace(ABSPATH, '', OMGF_UPLOAD_DIR)); ?>
				</p>
			</td>
		</tr>
<?php
	}

	/**
	 *
	 */
	public function do_promo_fonts_source_url()
	{
		$this->do_text(
			__('Modify Source URL (Pro)', $this->plugin_text_domain),
			'omgf_pro_source_url',
			__('e.g. https://cdn.mydomain.com/alternate/relative-path', $this->plugin_text_domain),
			defined('OMGF_PRO_SOURCE_URL') ? OMGF_PRO_SOURCE_URL : '',
			sprintf(
				__("Modify the <code>src</code> attribute for font files and stylesheets generated by OMGF Pro. This can be anything; from an absolute URL pointing to your CDN (e.g. <code>%s</code>) to an alternate relative URL (e.g. <code>/renamed-wp-content-dir/alternate/path/to/font-files</code>) to work with <em>security thru obscurity</em> plugins. Enter the full path to OMGF's files. Default: (empty)", $this->plugin_text_domain),
				'https://your-cdn.com/wp-content/uploads/omgf'
			) . ' ' . $this->promo,
			true
		);
	}

	/**
	 * 
	 */
	public function do_compatibility()
	{
		$this->do_checkbox(
			__('Divi/Elementor Compatibility', $this->plugin_text_domain),
			OMGF_Admin_Settings::OMGF_ADV_SETTING_COMPATIBILITY,
			OMGF_COMPATIBILITY,
			__('Divi and Elementor use the same handle for Google Fonts stylesheets with different configurations. OMGF includes compatibility fixes to make sure these different stylesheets are processed correctly. However, if you have too many different stylesheets and you want to force the usage of 1 stylesheet throughout all your pages, disabling Divi/Elementor Compatibility might help. Default: on', $this->plugin_text_domain)
		);
	}

	/**
	 * Remove Settings/Files at Uninstall.
	 */
	public function do_uninstall()
	{
		$this->do_checkbox(
			__('Remove Settings/Files At Uninstall', $this->plugin_text_domain),
			OMGF_Admin_Settings::OMGF_ADV_SETTING_UNINSTALL,
			OMGF_UNINSTALL,
			__('Warning! This will remove all settings and cached fonts upon plugin deletion.', $this->plugin_text_domain)
		);
	}
}
