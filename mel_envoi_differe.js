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

if (window.rcmail) {
    rcmail.addEventListener('init', function (evt) {
        if (rcmail.env.task == 'mail' && rcmail.env.action == 'compose') {
            rcmail.enable_command('display_mel_envoi_differe', true);
        };

        $('#envoidiffere_date').datepicker({ maxDate: 0, dateFormat: 'dd/mm/yy HH:MM' })
            .change(function () {
                changeInput(this.value);
            });

    });
}

rcube_webmail.prototype.display_mel_envoi_differe = function () {
    var frame = $('<iframe>').attr('id', 'envoidiffereframe')
        .attr('src', rcmail.url('mail/plugin.mel_envoi_differe') + '&_framed=1')
        .attr('frameborder', '0')
        .appendTo(document.body);

    var buttons = {};

    frame.dialog({
        modal: true,
        resizable: false,
        closeOnEscape: true,
        title: '',
        closeText: rcmail.get_label('close'),
        close: function () {
            frame.dialog('destroy').remove();
        },
        buttons: buttons,
        width: 400,
        height: 435,
        rcmail: rcmail
    }).width(380);
};
