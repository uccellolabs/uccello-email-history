export class EmailModal {
    constructor() {
        this.initOpenEmailModalLister();
    }

    initOpenEmailModalLister() {
        $('.open-email-modal').on('click', event => {
            this.email = $(event.currentTarget).data('email');
            this.dateFormat = $(event.currentTarget).data('date-format');
            console.log(this.email);

            this.setSubject();
            this.setBody();
            this.setAttachments();
            this.setCc();
            this.setCreated_at();
            this.setTo();
        });
    }

    setSubject() {
        $('#email-modal h5').html(this.email.subject);
        $('#email-modal h4').html(this.email.subject);
    }

    setBody() {
        $('#email-modal p').html(this.email.body);
    }

    setCc() {
        $('#emailDestinataire').html(this.email.cc);
    }
    setTo(){
        $('#email-modal p.test').html(this.email.to);
    }

    setCreated_at() {
        $('#emailCreated_at').html(moment(this.email.created_at).format(this.dateFormat));
    }

    setAttachments() {

    }
}

new EmailModal();
