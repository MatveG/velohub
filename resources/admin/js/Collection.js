
export default class Collection {
    constructor(options) {
        this._items = [];
        this._options = options;

        return new Proxy(this, {
            get: (target, prop) => {
                if (typeof target[prop] !== 'undefined') {
                    return target[prop];
                }

                if (typeof this._items[prop] === 'function') {
                    return (...args) => this._items[prop](...args);
                }

                return null;
            }
        });
    }

    count() {
        return this._items.length;
    }

    get(key) {
        if (this._items[key]) {
            return { ...this._items[key] };
        }
    }

    first() {
        return this.get(0);
    }

    last() {
        return this.get(this.count() - 1);
    }

    all() {
        return this._items;
    }

    where(key, value) {
        return this._items.filter(el => el[key] === value);
    }

    collect(values) {
        if (values) {
            this._items = values;
        }

        return this;
    }

    push(item)  {
        if (item) {
            if (this._options.customOrd) {
                item[this._options.customOrd] = this.max(this._options.customOrd) + 1;
            }

            this._items.push(item);
        }

        return this;
    }

    put(key, item) {
        if (key >= 0 && item) {
            this._items = this._items.map((el, index) => (key === index) ? item : el);
        }

        return this;
    }

    remove(key) {
        if (this._items[key]) {
            if (this._options.customOrd) {
                this._items.forEach((el) => el.ord = (el.ord > this._items[key].ord) ? --el.ord : el.ord);
            }
            this._items.splice(key, 1);
        }

        return this;
    }

    min(key) {
        return this._items.reduce((acc, el) => (el[key] < acc) ? el[key] : acc, this._items[0][key]);
    }

    max(key) {
        return this._items.reduce((acc, el) => (el[key] > acc) ? el[key] : acc, this._items[0][key]);
    }

    toJson() {
        return JSON.stringify(this._items);
    }

}



