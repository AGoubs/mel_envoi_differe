<?php

/**
 * Plugin Mél Envoi différé
 *
 * Plugin d'envoi de mail différé depuis Roundcube
 * Les messages sont stocké sur un serveur jusqu'au moment de l'envoi
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

class mel_envoi_differe extends rcube_plugin
{
    /**
     * Task courante pour le plugin
     *
     * @var string
     */
    public $task = 'mail';

    /**
     * RFC4155: mbox date format
     */
    const MBOX_DATE_FORMAT = 'D M d H:i:s Y';

    /**
     * Méthode d'initialisation du plugin mel_archivage
     */
    function init()
    {
        $rcmail = rcmail::get_instance();

        $this->load_config();

        if ($rcmail->task == 'mail' && $rcmail->action == 'compose') {
            if ($rcmail->config->get('ismobile', false)) {
                $skin_path = 'skins/mel_larry_mobile';
            } else {
                $skin_path = $this->local_skin_path();
            }
            $this->include_stylesheet($skin_path . '/css/mel_envoi_differe.css');
            $this->include_script('mel_envoi_differe.js');
            $this->add_texts('localization/', true);

            $this->register_action('plugin.mel_envoi_differe', array($this, 'request_action'));

            $this->add_button(array(
                'type'     => 'link',
                'label'    => 'buttontext',
                'command'  => 'plugin.mel_envoi_differe',
                'class'    => 'button mel_envoi_differe disabled',
                'id'       => 'mel_envoi_differe',
                'classact' => 'button mel_envoi_differe',
                'title'    => 'buttontitle',
                'domain'   => 'mel_envoi_differe'
            ), 'toolbar');
        }
    }

    /**
     * Affichage du template archivage
     */
    public function request_action()
    {
        $rcmail = rcmail::get_instance();
    $rcmail->output->send();

    }
}
