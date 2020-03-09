
import Core from './core.class';

class Cart
{
    constructor() {
        let cookie = Core.getCookie('cart');

        this.cart = (cookie && cookie.length) ?
            JSON.parse( decodeURIComponent(cookie) ) :
            { id: null, items: [] };
    }

    add(id) {
        if(this.cart.items.find(el => el.id === id)) return;

        this.cart.items.push({ id: id, q: 1 });

        if(this.cart.id) {
            Core.ajaxPost('/ajax/cart/add/', 'patch', {
                cart_id: this.cart.id,
                sign: this.cart.sign,
                id: id
            }, (data) => {
                if(data.ok) {
                    this.save();
                }
            });

            return;
        }

        Core.ajaxPost('/ajax/cart/new/', 'post', { id: id }, (data) => {
            this.cart.id = data.id;
            this.cart.sign = data.sign;
            this.cart.actual = true;
            this.save();
        });
    }

    remove(id) {
        this.cart.items = this.cart.items.filter((el) => el.id !== id);
        this.changed().save();
    }

    increase(id) {
        this.cart.items.find(el => el.id === id).q++;
        this.changed().save();
    }

    decrease(id) {
        if(this.cart.items.find(el => el.id === id).q > 1) {
            this.cart.items.find(el => el.id === id).q--;
        }
        this.changed().save();
    }

    save() {
        Core.setCookie('cart', encodeURIComponent( JSON.stringify(this.cart) ), 365);
    }

    changed() {
        this.cart.actual = false;

        return this;
    }

    check(id) {
        return !!(this.cart.items.find(el => el.id === id));
    }

    counter() {
        return this.cart.items.length;
    }
}

export default (new Cart);
