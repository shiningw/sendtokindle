import OCA from 'OCA';
import Http from './lib/http';
const fileActions = {
    mimes: ['application/x-mobipocket-ebook', 'application/pdf', 'application/vnd.amazon.ebook', 'AZW/Mobi', 'application/epub+zip', 'text', 'application/x-ms-reader', 'Application/x-rocketbook', 'application/x-newton-compatible-pkg', 'PRC'],
    registerAction() {
        let params = {
            name: 'Kindle',
            displayName: t('files', 'Send to Kindle'),
            permissions: OC.PERMISSION_READ,
            iconClass: 'icon-share',
            actionHandler: this.actionHandler,
        };
        const fileActions = OCA.Files.fileActions;
        fileActions.setDefault('dir', 'Open');
        this.mimes.forEach((mime) => {
            params.mime = mime;
            fileActions.registerAction(params);
        })
    },
    actionHandler(filename, context) {
        var fileList = context.fileList;
        var url = OC.generateUrl('/apps/sendtokindle/send');
        $('#kindle-alert').addClass('sending').text('Sending...Please give it a few seconds').show();
        Http.create(url).setData({
            file: filename,
            dir: fileList.getCurrentDirectory()
        }).setHandler(data => {
            $('#kindle-alert').removeClass('sending');
            if (data.status) {
                $('#kindle-alert').addClass('success');
                OC.msg.finishedSuccess('#kindle-alert', data.message);
            } else {
                $('#kindle-alert').addClass('error');
                OC.msg.finishedError('#kindle-alert', data.error);
            }
        }).send();
    }
}
export default {
    run: function () {
        window.addEventListener('DOMContentLoaded', function () {
            $('#file_action_panel').after('<div id="kindle-alert" style="display:none;"></div>');
            fileActions.registerAction();
        })
    }
}
