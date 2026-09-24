export default function convocatoriaModal() {
    return {
        modal: null,
        previousBodyOverflow: '',

        open(data) {
            if (!data) return;

            if (this.modal) {
                this.modal = data;
                return;
            }

            this.previousBodyOverflow = document.body.style.overflow;
            this.modal = data;
            document.body.style.overflow = 'hidden';
        },

        close() {
            if (!this.modal) return;

            this.modal = null;
            document.body.style.overflow = this.previousBodyOverflow;
        },

        destroy() {
            if (this.modal) this.close();
        },
    };
}
