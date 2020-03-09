
import Core from './core.class';

class Compare
{
    constructor() {
        let cookie = Core.getCookie('compare');

        this.items = (cookie && cookie.length) ?
            JSON.parse( decodeURIComponent(cookie) ) : [];
    }

    add(id) {
        if(this.items.includes(id)) return;

        this.items.push(id);
        this.save();
    }

    remove(id) {
        this.items = this.items.filter((el) => el !== id);
        this.save();
    }

    save() {
        Core.setCookie('compare', encodeURIComponent( JSON.stringify(this.items) ), 30);
    }

    reset() {
        this.items = [];
        Core.clearCookie('compare');
    }

    check(id) {
        return this.items.includes(id);
    }
}

export default (new Compare);
