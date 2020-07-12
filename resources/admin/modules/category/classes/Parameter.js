
const types = {
    string: 'строка',
    number: 'число',
    select: 'выбор',
};

export default class Parameter {
    constructor(product) {
        this.id = null;
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
