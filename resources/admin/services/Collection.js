
export default class Collection {
    constructor(options) {
        this._items = [];

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

    mapIndex(obj, val) {
        Object.defineProperty(obj, 'index', {
            enumerable: false,
            writable: false,
            value : val
        });

        return obj;
    }

    count() {
        return this._items.length;
    }

    has(index) {
        return !!this._items[index];
    }

    get(index) {
        if (this.has(index)) {
            return this.mapIndex({ ...this._items[index] }, index);
        }
    }

    all() {
        return this._items.map((el, index) => this.mapIndex({ ...el }, index));
    }

    pluck(key) {
        return this._items.map(el => el[key]);
    }

    first() {
        return this.get(0);
    }

    last() {
        return this.get(this.count() - 1);
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

    where(key, value) {
        return (new Collection(this._options)).collect(this._items.filter(el => el[key] === value));
    }

    find(key, value) {
        return this._items.find(el => el[key] === value);
    }

    contains(key, value) {
        return !!this._items.find(el => el[key] === value);
    }

    every(callback) {
        return this._items.filter((el, i) => callback(el, i)).length === this.count();
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
            this._items = array;
        }

        return this;
    }

    merge(array) {
        if (array.length) {
            this._items = [...this._items, ...array];
        }

        return this;
    }

    push(item)  {
        if (item) {
            let lastVal = this.max('sort');
            item.sort = (lastVal) ? lastVal +1 : 1;
            this._items.push(item);
        }

        return this;
    }

    unshift(item) {
        if (item) {
            item.sort = 1;
            this._items.map(el => el.sort++);
            this._items.unshift(item);
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
            this._items.forEach((el) => el.sort = (el.sort > this._items[key].sort) ? --el.sort : el.sort);
            this._items.splice(key, 1);
        }

        return this;
    }

    pull(index) {
        let item = this.get(index);
        this.remove(index);

        return item;
    }

    toJson() {
        return JSON.stringify(this._items);
    }
}



