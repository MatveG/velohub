
import {customAlphabet} from "nanoid";

const nanoid = customAlphabet('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-_', 6);

const types = {
    number: 'число',
    string: 'строка',
    select: 'выбор',
};

export default class Parameter {
    constructor(product) {
        this.id = nanoid();
        this.ord = null;
        this.title = null;
        this.latin = null;
        this.type = null;
        this.reset();
    }

    reset() {
        this.filter = false;
        this.units = null;
        this.values = [];
    }

    static fromObj(obj) {
        return Object.assign(new Parameter(), JSON.parse(JSON.stringify(obj)));
    }

    static getTypes() {
        return types;
    }

}
