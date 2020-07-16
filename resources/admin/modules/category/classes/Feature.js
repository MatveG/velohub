
import {customAlphabet} from "nanoid";

const nanoid = customAlphabet('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-_', 6);

const types = {
    group: 'группа',
    number: 'число',
    string: 'строка',
    text: 'текст',
    bool: 'есть/нет',
    select: 'выбор',
    multiple: 'мульти выбор',
};

export default class Feature {
    constructor(product) {
        this.id = nanoid();
        this.ord = null;
        this.title = null;
        this.latin = null;
        this.type = null;
        this.reset();
    }

    reset() {
        this.required = false;
        this.filter = false;
        this.units = null;
        this.values = [];
        this.sub = [];
    }

    static fromObj(obj) {
        return Object.assign(new Feature(), JSON.parse(JSON.stringify(obj)));
    }

    static getTypes(withGroup = true) {
        if (withGroup) {
            return types;
        }

        let {group, ...res} = types;

        return res;
    }

}
