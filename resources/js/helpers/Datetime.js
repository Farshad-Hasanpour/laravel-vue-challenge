export default class Datetime{
    constructor(date = null) {
        this.date = new Date(date);
    }

    toLocale(){
        return this.date.toLocaleString('en', {
            day: '2-digit',
            year: 'numeric',
            month: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    toDateLocale(){
        return this.date.toLocaleString('en', {
            day: '2-digit',
            year: 'numeric',
            month: '2-digit'
        });
    }

    toString(){
        return this.toLocale();
    }
}
