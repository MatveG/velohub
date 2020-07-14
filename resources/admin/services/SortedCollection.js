
import {customAlphabet} from "nanoid";

const nanoid = customAlphabet('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', 9);

export default class SortedCollection {
    constructor(items = []) {
        this._items = items;

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

    has(id) {
        return !!this._items.find(el => el.id = id);
    }

    get(id) {
        return this._items.find(el => el.id = id);
    }

    first() {
        return this._items[0];
    }

    last() {
        return this._items[this.count() - 1];
    }

    all() {
        return this._items;
    }

    sum(key) {
        if (this.count()) {
            return this._items.reduce((acc, el) => acc + el[key], this._items[0][key]);
        }
    }

    min(key) {
        if (this.count()) {
            return this._items.reduce((acc, el) => (el[key] < acc) ? el[key] : acc, this._items[0][key]);
        }
    }

    max(key) {
        if (this.count()) {
            return this._items.reduce((acc, el) => (el[key] > acc) ? el[key] : acc, this._items[0][key]);
        }
    }

    avg(key) {
        if (this.count()) {
            return this.sum(key)/this.count();
        }
    }

    contains(key, value) {
        return !!this._items.find(el => el[key] === value);
    }

    where(key, value) {
        return new SortedCollection(this._items.filter(el => el[key] === value));
    }

    orderBy(key) {
        this._items.sort((first, second) => {
            return ((first[key] < second[key]) ? -1 : ((first[key] > second[key]) ? 1 : 0));
        });

        return this;
    }

    orderByDesc(key) {
        this._items.sort((first, second) => {
            return ((first[key] < second[key]) ? 1 : ((first[key] > second[key]) ? -1 : 0));
        });

        return this;
    }

    collect(array) {
        if (array.length) {
            this._items = [...this._items, ...array];
        }

        return this;
    }

    push(obj)  {
        if (!obj.id) {
            obj.id = nanoid(6);
        }
        let lastVal = this.max('ord');
        obj.ord = (lastVal) ? lastVal + 1 : 1;

        this._items.push(obj);

        return this;
    }

    put(id, obj) {
        this._items = this._items.map(el => el.id === id ? obj : el);

        return this;
    }

    update(id, obj) {
        this._items = this._items.map(el => el.id === id ? {...el, ...obj} : el);

        return this;
    }

    remove(id) {
        this._items = this._items.filter(el => {
            if (el.id !== id) {
                return true;
            }

            this._items.forEach(each => each.ord = (each.ord > el.ord) ? --each.ord : each.ord);
            return false;
        });

        return this;
    }

    pop() {
        let result = this._items[this.count() - 1];
        this.remove(this.count() - 1);

        return result;
    }

    shift() {
        let result = this._items[0];
        this.remove(0);

        return result;
    }

    toJson() {
        return JSON.stringify(this._items);
    }

    concat() {
        return console.log('concat is not allowed');
    }

    unshift() {
        return console.log('unshift is not allowed');
    }

    splice() {
        return console.log('splice is not allowed');
    }
}



